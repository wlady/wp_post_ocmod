<?php

/**
 * Эти объявления должны быть перенесены в config.php (или bootstrap.php)
 *
 * define('WP_ADDRESS',  'http://news.opencart.dev');
*/

require_once(DIR_SYSTEM . 'helper/wp_post.php');

class ControllerExtensionModuleWpPost extends Controller
{
    public function index($setting)
    {
        $url = WP_ADDRESS . WP_POSTS;
        if (count($setting['categories'])) {
            $query = array();
            foreach ($setting['categories'] as $category) {
                $query[] = 'categories[]=' . $category;
            }
            $query[] = 'per_page=' . $setting['limit'];
            $concat = stripos($url, '?')!==false ? '&' : '?';
            $url .= $concat . implode('&', $query);
        }
        $res = curl_get($url);
        if ($posts = json_decode($res)) {
            foreach ($posts as &$post) {
                if (isset($post->_links->{'wp:featuredmedia'}) && is_array($post->_links->{'wp:featuredmedia'})) {
                    $media = curl_get($post->_links->{'wp:featuredmedia'}[0]->{'href'});
                    if ($image = json_decode($media)) {
                        if (isset($image->media_details->sizes)) {
                            $post->post_image = $image->media_details->sizes;
                        }
                    }
                }
            }
        }
        $item_tpl = html_entity_decode($setting['tpl']);

        // Внимание!!! Я использую шаблоны Twig - не забудь установить
        // composer require twig/twig --prefer-dist
        $loader = new Twig_Loader_Array([
            'index' => $item_tpl,
        ]);
        $twig = new Twig_Environment($loader);

        $result = $twig->render('index', [
            'posts' => $posts,
        ]);

        return $result;
    }
}
