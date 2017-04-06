CREATE TABLE IF NOT EXISTS `oc_wp_post` (
 `wp_post_id` int(11) NOT NULL AUTO_INCREMENT,
 `api_id` int(11) NOT NULL,
 `post_id` int(11) NOT NULL,
 `data` text COLLATE utf8_unicode_ci NOT NULL,
 PRIMARY KEY (`wp_post_id`),
 UNIQUE KEY `post_id` (`post_id`,`api_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
