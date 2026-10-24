-- Performance indexes for course / lecture / enrollment lookups.
--
-- course_lecture and course_subscription had no secondary indexes, so every
-- "lectures of course X", curriculum load, per-course lecture/learner count and
-- "courses of user Y" check scanned the whole table.
--
-- Safe to run more than once: each index is only added if it does not exist yet.
-- Adding an index does not change any data. On large tables, run it outside peak hours.

-- Legacy rows contain zero dates (e.g. cs_end_date = '0000-00-00'). MySQL 8's strict mode refuses to
-- rebuild such tables, so relax it for THIS SESSION ONLY. No stored values are modified; the original
-- mode is restored at the end of this file.
SET @old_sql_mode := @@SESSION.sql_mode;
SET SESSION sql_mode = REPLACE(REPLACE(REPLACE(@@SESSION.sql_mode, 'NO_ZERO_IN_DATE', ''), 'NO_ZERO_DATE', ''), 'STRICT_TRANS_TABLES', '');

-- 0) course_subscription.cs_status was declared ENUM('0','1','','') (the empty value twice).
--    MySQL 8 refuses ANY ALTER/CREATE INDEX on a table with that definition (error 1291),
--    so remove the duplicate first. Stored values ('0', '1', '') and the default '1' are unchanged.
SET @bad := (SELECT COUNT(*) FROM information_schema.columns
             WHERE table_schema = DATABASE() AND table_name = 'course_subscription'
               AND column_name = 'cs_status' AND column_type = 'enum(''0'',''1'','''','''')');
SET @sql := IF(@bad = 1,
    'ALTER TABLE course_subscription MODIFY cs_status ENUM(''0'',''1'','''') NULL DEFAULT ''1''',
    'SELECT ''cs_status enum already clean''');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Curriculum / lecture lists: WHERE cl_course_id = ? [AND section_id = ?] ORDER BY sort_order
SET @exists := (SELECT COUNT(*) FROM information_schema.statistics
                WHERE table_schema = DATABASE() AND table_name = 'course_lecture' AND index_name = 'idx_cl_course_section_sort');
SET @sql := IF(@exists = 0,
    'ALTER TABLE course_lecture ADD INDEX idx_cl_course_section_sort (cl_course_id, section_id, sort_order)',
    'SELECT ''idx_cl_course_section_sort already exists''');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Learners of a course: WHERE cs_course_id = ? [AND cs_status = '1']
SET @exists := (SELECT COUNT(*) FROM information_schema.statistics
                WHERE table_schema = DATABASE() AND table_name = 'course_subscription' AND index_name = 'idx_cs_course_status');
SET @sql := IF(@exists = 0,
    'ALTER TABLE course_subscription ADD INDEX idx_cs_course_status (cs_course_id, cs_status)',
    'SELECT ''idx_cs_course_status already exists''');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Courses of a learner / enrollment checks: WHERE cs_user_id = ? [AND cs_status = '1'] [AND cs_course_id = ?]
SET @exists := (SELECT COUNT(*) FROM information_schema.statistics
                WHERE table_schema = DATABASE() AND table_name = 'course_subscription' AND index_name = 'idx_cs_user_status_course');
SET @sql := IF(@exists = 0,
    'ALTER TABLE course_subscription ADD INDEX idx_cs_user_status_course (cs_user_id, cs_status, cs_course_id)',
    'SELECT ''idx_cs_user_status_course already exists''');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Sections of a course: WHERE course_id = ? ORDER BY sort_order
SET @exists := (SELECT COUNT(*) FROM information_schema.statistics
                WHERE table_schema = DATABASE() AND table_name = 'course_sections' AND index_name = 'idx_sections_course_sort');
SET @sql := IF(@exists = 0,
    'ALTER TABLE course_sections ADD INDEX idx_sections_course_sort (course_id, sort_order)',
    'SELECT ''idx_sections_course_sort already exists''');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Restore the session's original SQL mode
SET SESSION sql_mode = @old_sql_mode;
