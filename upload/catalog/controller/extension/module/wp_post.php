<?php

/**
 * Эти объявления должны быть перенесены в config.php (или bootstrap.php)
 *
 * define('NEWS_SERVICE',                  'http://news.opencart.dev');
 * define('NEWS_CATEGORIES',               '/wp-json/wp/v2/categories');
 * define('NEWS_POSTS',                    '/wp-json/wp/v2/posts');
*/

class ControllerExtensionModuleWpPost extends Controller
{
    public function index($setting)
    {
        $url = NEWS_SERVICE . NEWS_POSTS;
        if (count($setting['categories'])) {
            $query = array();
            foreach ($setting['categories'] as $category) {
                $query[] = 'categories[]=' . $category;
            }
            $query[] = 'per_page=' . $setting['limit'];
            $url .= '?' . implode('&', $query);
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

        // Внимание!!! Я использую шаблоны Twig
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
