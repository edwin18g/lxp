-- Course Overview insights read lecture completions per course:
--   WHERE course_id = ? [GROUP BY user_id]
-- user_lecture_progress only had UNIQUE(user_id, lecture_id). Safe to run more than once.
SET @exists := (SELECT COUNT(*) FROM information_schema.statistics
                WHERE table_schema = DATABASE() AND table_name = 'user_lecture_progress' AND index_name = 'idx_ulp_course_user');
SET @sql := IF(@exists = 0,
    'ALTER TABLE user_lecture_progress ADD INDEX idx_ulp_course_user (course_id, user_id, lecture_id)',
    'SELECT ''idx_ulp_course_user already exists''');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
