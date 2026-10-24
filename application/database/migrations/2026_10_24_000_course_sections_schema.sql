-- Course curriculum sections: tables/columns the code uses that older databases (production) don't have yet.
--   * course_sections table            (sections in the course curriculum)
--   * course_lecture.sort_order         (lecture order inside a section)
--   * course_lecture.section_id         (which section a lecture belongs to; 0 = "General / Uncategorized")
--   * sliders table                     (homepage sliders; only created if missing)
--
-- Runs before 2026_10_24_course_performance_indexes.sql (filename order), which indexes these columns.
-- Safe to run more than once: everything is created only if it doesn't exist. No existing data is changed;
-- existing lectures get sort_order = 0 and section_id = 0, i.e. they show under "General / Uncategorized".

-- Legacy rows may contain zero dates; relax strict mode for THIS SESSION ONLY (restored at the end).
SET @old_sql_mode := @@SESSION.sql_mode;
SET SESSION sql_mode = REPLACE(REPLACE(REPLACE(@@SESSION.sql_mode, 'NO_ZERO_IN_DATE', ''), 'NO_ZERO_DATE', ''), 'STRICT_TRANS_TABLES', '');

CREATE TABLE IF NOT EXISTS `course_sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- course_lecture.sort_order
SET @missing := (SELECT COUNT(*) = 0 FROM information_schema.columns
                 WHERE table_schema = DATABASE() AND table_name = 'course_lecture' AND column_name = 'sort_order');
SET @sql := IF(@missing,
    'ALTER TABLE course_lecture ADD COLUMN sort_order int DEFAULT ''0''',
    'SELECT ''course_lecture.sort_order already exists''');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- course_lecture.section_id
SET @missing := (SELECT COUNT(*) = 0 FROM information_schema.columns
                 WHERE table_schema = DATABASE() AND table_name = 'course_lecture' AND column_name = 'section_id');
SET @sql := IF(@missing,
    'ALTER TABLE course_lecture ADD COLUMN section_id int DEFAULT ''0''',
    'SELECT ''course_lecture.section_id already exists''');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `button_text` varchar(64) NOT NULL,
  `button_link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `order_index` int DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET SESSION sql_mode = @old_sql_mode;
