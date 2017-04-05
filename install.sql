CREATE TABLE `oc_wp_post` (
  `wp_post_id` int(11) NOT NULL,
  `api_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `oc_wp_post`
  ADD PRIMARY KEY (`wp_post_id`),
  ADD UNIQUE KEY `post_id` (`post_id`,`api_id`) USING BTREE;

ALTER TABLE `oc_wp_post`
  MODIFY `wp_post_id` int(11) NOT NULL AUTO_INCREMENT;
