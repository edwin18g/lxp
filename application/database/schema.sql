DROP TABLE IF EXISTS `b_bookings`;
CREATE TABLE `b_bookings` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `customers_id` int DEFAULT NULL,
  `course_categories_id` int DEFAULT NULL,
  `courses_id` int DEFAULT NULL,
  `batches_id` int DEFAULT NULL,
  `fees` int DEFAULT NULL,
  `net_fees` int DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `batch_title` varchar(256) DEFAULT NULL,
  `batch_description` text,
  `batch_capacity` int DEFAULT NULL,
  `batch_recurring` tinyint DEFAULT NULL,
  `batch_weekdays` text,
  `batch_start_date` date DEFAULT NULL,
  `batch_end_date` date DEFAULT NULL,
  `batch_start_time` time DEFAULT NULL,
  `batch_end_time` time DEFAULT NULL,
  `course_title` varchar(256) DEFAULT NULL,
  `course_category_title` varchar(256) DEFAULT NULL,
  `customer_name` varchar(256) DEFAULT NULL,
  `customer_email` varchar(156) DEFAULT NULL,
  `customer_address` varchar(256) DEFAULT NULL,
  `customer_mobile` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `cancellation` tinyint NOT NULL DEFAULT '0' COMMENT '0:disable;1:pending;2:approved;3:refunded;',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `b_bookings_members`;
CREATE TABLE `b_bookings_members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(256) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(155) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `b_bookings_id` int DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `b_bookings_payments`;
CREATE TABLE `b_bookings_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `b_bookings_id` int DEFAULT NULL,
  `paid_amount` int DEFAULT NULL,
  `total_amount` int NOT NULL DEFAULT '0',
  `payment_type` enum('locally','stripe','paypal') DEFAULT NULL,
  `payment_status` tinyint DEFAULT NULL COMMENT '0:pending;1:successful;2:failed',
  `transactions_id` int DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `tax_title` varchar(56) DEFAULT NULL,
  `tax_rate_type` enum('percent','fixed') DEFAULT NULL,
  `tax_rate` tinyint DEFAULT NULL,
  `tax_net_price` enum('including','excluding') DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `batches`;
CREATE TABLE `batches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(250) DEFAULT NULL,
  `description` text,
  `fees` int DEFAULT NULL COMMENT 'per customer',
  `capacity` int DEFAULT NULL COMMENT 'max customers',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL COMMENT '24 hours format',
  `end_time` time DEFAULT NULL COMMENT '24 hours format',
  `weekdays` text,
  `recurring` tinyint(1) DEFAULT '0',
  `recurring_type` enum('first_week','second_week','third_week','fourth_week','every_week') NOT NULL DEFAULT 'every_week',
  `status` tinyint(1) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `courses_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `batches_tutors`;
CREATE TABLE `batches_tutors` (
  `users_id` int DEFAULT NULL,
  `batches_id` int DEFAULT NULL,
  UNIQUE KEY `users_id` (`users_id`,`batches_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE `blogs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `slug` varchar(512) DEFAULT NULL,
  `content` mediumtext,
  `users_id` int DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '0' COMMENT '0:disable;1:published;2:pending',
  `image` varchar(256) DEFAULT NULL,
  `meta_title` varchar(128) DEFAULT NULL,
  `meta_tags` varchar(256) DEFAULT NULL,
  `meta_description` text,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `captcha`;
CREATE TABLE `captcha` (
  `captcha_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `captcha_time` int unsigned DEFAULT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=MyISAM AUTO_INCREMENT=32767 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `ce_sessn`;
CREATE TABLE `ce_sessn` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `anonym_sessn_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `controllers`;
CREATE TABLE `controllers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `course_categories`;
CREATE TABLE `course_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `description` text,
  `image` varchar(256) DEFAULT NULL,
  `icon` varchar(256) DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `status` tinyint DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `course_lecture`;
CREATE TABLE `course_lecture` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cl_course_id` int NOT NULL,
  `cl_name` varchar(200) NOT NULL,
  `cl_type` int NOT NULL COMMENT '1-> video, 2->pdf',
  `cl_file_name` varchar(200) NOT NULL,
  `cl_decsription` text,
  `cl_status` int NOT NULL DEFAULT '0',
  `cl_secure` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1446 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `course_subscription`;
CREATE TABLE `course_subscription` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cs_user_id` int NOT NULL,
  `cs_course_id` int NOT NULL,
  `cs_start_date` date NOT NULL,
  `cs_end_date` date NOT NULL,
  `cs_status` enum('0','1','','') DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=128548 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `description` text,
  `images` text,
  `course_categories_id` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `meta_title` varchar(128) DEFAULT NULL,
  `meta_tags` varchar(256) DEFAULT NULL,
  `meta_description` text,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies` (
  `iso_code` varchar(3) NOT NULL,
  `symbol` varchar(3) DEFAULT NULL,
  `unicode` varchar(8) DEFAULT NULL,
  `position` varchar(6) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`iso_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `custom_fields`;
CREATE TABLE `custom_fields` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `input_type` enum('input','textarea','radio','dropdown','file','email','checkbox') CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `options` text COMMENT 'Use for radio and dropdown: key|value on each line',
  `is_numeric` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'forces numeric keypad on mobile devices',
  `show_editor` enum('0','1') NOT NULL DEFAULT '0',
  `help_text` varchar(256) DEFAULT NULL,
  `validation` text,
  `label` varchar(128) DEFAULT NULL,
  `value` text COMMENT 'If translate is 1, just start with your default language',
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `e_bookings`;
CREATE TABLE `e_bookings` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `customers_id` int DEFAULT NULL,
  `event_types_id` int DEFAULT NULL,
  `events_id` int DEFAULT NULL,
  `fees` int DEFAULT NULL,
  `net_fees` int DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `event_title` varchar(256) DEFAULT NULL,
  `event_description` text,
  `event_capacity` int DEFAULT NULL,
  `event_weekdays` text,
  `event_recurring` tinyint(1) DEFAULT NULL,
  `event_start_date` date DEFAULT NULL,
  `event_end_date` date DEFAULT NULL,
  `event_start_time` time DEFAULT NULL,
  `event_end_time` time DEFAULT NULL,
  `event_type_title` varchar(256) DEFAULT NULL,
  `customer_name` varchar(256) DEFAULT NULL,
  `customer_email` varchar(156) DEFAULT NULL,
  `customer_address` varchar(256) DEFAULT NULL,
  `customer_mobile` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `cancellation` tinyint NOT NULL DEFAULT '0' COMMENT '0:disable;1:pending;2:approved;3:refunded;',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `e_bookings_members`;
CREATE TABLE `e_bookings_members` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fullname` varchar(256) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `email` varchar(155) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `e_bookings_id` int DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `e_bookings_payments`;
CREATE TABLE `e_bookings_payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `e_bookings_id` int DEFAULT NULL,
  `paid_amount` int DEFAULT NULL,
  `total_amount` int NOT NULL DEFAULT '0',
  `payment_type` enum('locally','stripe','paypal') DEFAULT NULL,
  `payment_status` tinyint DEFAULT NULL COMMENT '0:pending;1:successful;2:failed',
  `transactions_id` int DEFAULT NULL,
  `currency` varchar(3) DEFAULT NULL,
  `tax_title` varchar(56) DEFAULT NULL,
  `tax_rate_type` enum('percent','fixed') DEFAULT NULL,
  `tax_rate` tinyint DEFAULT NULL,
  `tax_net_price` enum('including','excluding') DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `email_templates`;
CREATE TABLE `email_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `subject` varchar(256) DEFAULT NULL,
  `message` text,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `emails`;
CREATE TABLE `emails` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `message` text,
  `created` datetime DEFAULT NULL,
  `read` datetime DEFAULT NULL,
  `read_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `title` (`title`),
  KEY `created` (`created`),
  KEY `read` (`read`),
  KEY `read_by` (`read_by`),
  KEY `email` (`email`(78))
) ENGINE=MyISAM AUTO_INCREMENT=1894 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `event_types`;
CREATE TABLE `event_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  `icon` varchar(256) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_types_id` int DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `description` text,
  `images` text,
  `fees` int DEFAULT NULL COMMENT 'per customer',
  `capacity` int DEFAULT NULL COMMENT 'max customers',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL COMMENT '24 hours format',
  `end_time` time DEFAULT NULL COMMENT '24 hours format',
  `weekdays` text,
  `recurring` tinyint(1) NOT NULL DEFAULT '0',
  `recurring_type` enum('first_week','second_week','third_week','fourth_week','every_week') NOT NULL DEFAULT 'every_week',
  `status` tinyint(1) DEFAULT NULL,
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `meta_title` varchar(128) DEFAULT NULL,
  `meta_tags` varchar(256) DEFAULT NULL,
  `meta_description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `events_tutors`;
CREATE TABLE `events_tutors` (
  `users_id` int DEFAULT NULL,
  `events_id` int DEFAULT NULL,
  UNIQUE KEY `users_id` (`users_id`,`events_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question` varchar(256) DEFAULT NULL,
  `answer` text,
  `status` tinyint(1) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `gallaries`;
CREATE TABLE `gallaries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(128) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `flag` varchar(256) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `login_attempts`;
CREATE TABLE `login_attempts` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `slug` varchar(256) DEFAULT NULL,
  `position` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1:custom;2:top',
  `content` longtext,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `n_type` enum('batches','events','bbookings','ebookings','contacts','users','b_cancellation','e_cancellation') DEFAULT NULL,
  `n_content` varchar(128) DEFAULT NULL,
  `n_url` text,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `users_id` int DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18168 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(256) DEFAULT NULL,
  `slug` varchar(256) DEFAULT NULL,
  `content` text,
  `image` varchar(256) DEFAULT NULL,
  `meta_title` varchar(128) DEFAULT NULL,
  `meta_tags` varchar(256) DEFAULT NULL,
  `meta_description` text,
  `status` tinyint(1) DEFAULT NULL COMMENT '0:disable;1:published;2:draft;',
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `controllers_id` int NOT NULL,
  `groups_id` int NOT NULL,
  `p_add` int NOT NULL,
  `p_edit` int NOT NULL,
  `p_delete` int NOT NULL,
  UNIQUE KEY `controllers_id` (`controllers_id`,`groups_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_type` enum('institute','site','home','theme','booking','email','login','payment','disqus','regional','ion_auth') NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `input_type` enum('input','textarea','radio','dropdown','timezones','file','languages','currencies','email','email_templates','taxes','files') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `options` text COMMENT 'Use for radio and dropdown: key|value on each line',
  `is_numeric` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'forces numeric keypad on mobile devices',
  `show_editor` enum('0','1') NOT NULL DEFAULT '0',
  `input_size` enum('large','medium','small') DEFAULT NULL,
  `translate` enum('0','1') NOT NULL DEFAULT '0',
  `help_text` varchar(256) DEFAULT NULL,
  `validation` varchar(256) NOT NULL,
  `sort_order` smallint unsigned NOT NULL,
  `label` varchar(256) DEFAULT NULL,
  `value` text COMMENT 'If translate is 1, just start with your default language',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `taxes`;
CREATE TABLE `taxes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `rate_type` enum('percent','fixed') DEFAULT NULL,
  `rate` tinyint DEFAULT NULL,
  `net_price` enum('including','excluding') DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` int NOT NULL AUTO_INCREMENT,
  `t_name` varchar(128) DEFAULT NULL,
  `t_type` varchar(64) DEFAULT NULL,
  `t_feedback` varchar(256) DEFAULT NULL,
  `image` varchar(128) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `payer_email` varchar(256) DEFAULT NULL,
  `payer_id` varchar(256) DEFAULT NULL,
  `payer_status` varchar(256) DEFAULT NULL,
  `payer_name` varchar(256) DEFAULT NULL,
  `payer_address` text,
  `txn_id` text,
  `currency` varchar(10) DEFAULT NULL,
  `total_amount` decimal(10,0) DEFAULT NULL,
  `protection_eligibility` varchar(20) DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `pending_reason` varchar(256) DEFAULT NULL,
  `payment_type` varchar(128) DEFAULT NULL,
  `item_name` varchar(256) DEFAULT NULL,
  `item_number` varchar(128) DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `txn_type` varchar(128) DEFAULT NULL,
  `payment_date` varchar(128) DEFAULT NULL,
  `business` varchar(256) DEFAULT NULL,
  `notify_version` varchar(128) DEFAULT NULL,
  `verify_sign` text,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `user_data`;
CREATE TABLE `user_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `lock` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=813 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `user_lecture_progress`;
CREATE TABLE `user_lecture_progress` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `lecture_id` int NOT NULL,
  `course_id` int NOT NULL,
  `completed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_lecture` (`user_id`,`lecture_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `salt` varchar(128) DEFAULT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `dob` date NOT NULL DEFAULT '1994-09-20',
  `profession` varchar(256) DEFAULT NULL,
  `experience` tinyint DEFAULT NULL COMMENT 'in years',
  `about` varchar(256) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `role` tinyint NOT NULL DEFAULT '3' COMMENT '1:admin;2:tutors;3:customers',
  `image` varchar(256) DEFAULT NULL,
  `language` varchar(64) DEFAULT NULL,
  `fb_uid` varchar(256) DEFAULT NULL,
  `fb_token` mediumtext,
  `g_uid` varchar(256) DEFAULT NULL,
  `g_token` text,
  `ip_address` varchar(45) DEFAULT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `last_login` int DEFAULT NULL,
  `active` tinyint DEFAULT NULL,
  `device_locked` tinyint(1) DEFAULT '0',
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `secure_device` set('0','1','') NOT NULL DEFAULT '0',
  `secure_key` text,
  `last_session_id` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=16280 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL,
  `group_id` mediumint unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  UNIQUE KEY `user_id` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16261 DEFAULT CHARSET=utf8mb3;

DROP TABLE IF EXISTS `visitors`;
CREATE TABLE `visitors` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_ip` varchar(256) DEFAULT NULL,
  `total_visits` int DEFAULT NULL,
  `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3084 DEFAULT CHARSET=utf8mb3;

