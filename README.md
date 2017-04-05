## Интеграция OpenCart 2.3 и WP 4.7

Модуль использует **WordPress API** для получения записей и отображения их в ленте новостей **OpenCart 2.3.x**.
При использовании совместно с WP плагином **Post To OpenCart** возможно получать посты непосредственно из WP
и сохранять их локально для дальнейшей обработки/показа (смотри https://github.com/wlady/wp-post-to-opencart).

![screenshot-1](screenshot-1.png)

![screenshot-2](screenshot-2.png)

Необходимо вручную перенести эти определения в файл config.php и указать правильный адрес сервиса:
```
define('NEWS_SERVICE',                  'http://news.opencart.dev');
define('NEWS_CATEGORIES',               '/wp-json/wp/v2/categories');
define('NEWS_POSTS',                    '/wp-json/wp/v2/posts');
```

Я использовал шаблоны Twig для генерации ленты новостей. Пример шаблона для модуля "Все новости":
```
{% for post in posts %}
        <div class="col-sm-6">
                <a href="{{ post.link }}" class="blognews-item" target="_blank">
                    <img class="blognews-pic" src="{{ post.post_image.thumbnail.source_url }}" alt="" />
                    <span class="blognews-info">
                    <h3 class="blognews-title text-overflow">{{ post.title.rendered | raw }}</h3>
                    <span class="blognews-text">{{ post.excerpt.rendered | raw }}
                        <span class="blognews-more">... <i>read more</i></span>
                    </span>
                    <span class="blognews-detail">
                        <span class="blognews-date pull-right">{{ post.date }}</span>
                    </span>
                </span>
            </a>
        </div>
{% endfor %}
```

Для использования Twig в OpenCart 2.3 достаточно установить необходимые пакеты с помощью composer:

```sh
composer require twig/twig --prefer-dist
```