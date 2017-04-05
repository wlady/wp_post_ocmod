<?php

class ModelWpPost extends Model
{
    /**
     * Новая запись
     *
     * @param int $api_id API ID
     * @param array $post WP Post
     * @return int Last Inserted ID
     */
    public function add($api_id, $post)
    {
        $post_id = $post['ID'];
        $post = serialize($post);
        $this->db->query(
            'INSERT INTO `' . DB_PREFIX . 'wp_post` SET `api_id`=?, `post_id`=?, `data`=? ON DUPLICATE KEY UPDATE `data`=?',
            array(
                $api_id,
                $post_id,
                $post,
                $post,
            )
        );
        $last_id = $this->db->getLastId();

        return $last_id;
    }

    /**
     * Получить запись
     *
     * @param int $wp_post_id ID записи
     * @return array WP Post
     */
    public function get($wp_post_id)
    {
        $query = $this->db->query('SELECT * FROM `' . DB_PREFIX . 'wp_post` WHERE `wp_post_id`=?',
            array(
                $wp_post_id,
            )
        );
        $post = unserialize($query->row['data']);

        return $post;
    }
}
