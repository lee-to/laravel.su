<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Name
    |--------------------------------------------------------------------------
    |
    | Этот параметр отвечает за имя сайта, которое используется в теге <title>
    | и как часть метаданных в SEO и социальных сетях. Указанное здесь имя
    | будет представлять ваш сайт в поисковой выдаче и при его упоминаниях.
    |
    */

    'name' => 'Laravel Framework Russian Community',

    /*
    |--------------------------------------------------------------------------
    | Site Description
    |--------------------------------------------------------------------------
    |
    | Этот параметр определяет описание сайта для метатегов SEO и социальных
    | сетей. Хорошее описание может улучшить видимость сайта в поисковых
    | системах и повысить его привлекательность при шаринге в соцсетях.
    |
    */

    'description' => 'Русская документация Laravel',

    /*
    |--------------------------------------------------------------------------
    | Site Image
    |--------------------------------------------------------------------------
    |
    | Здесь вы можете указать ссылку на изображение, которое будет
    | использоваться в качестве картинки предпросмотра для SEO и
    | социальных сетей. Это изображение появляется при делении ссылок
    | на сайт и помогает заинтересовать пользователя содержимым.
    |
    */

    'image' => '',

    /*
    |--------------------------------------------------------------------------
    | PWA Manifest
    |--------------------------------------------------------------------------
    |
    | Настройки манифеста для Progressive Web App (PWA), которые определяют
    | внешний вид и настройки при добавлении сайта на главный экран устройства.
    | Здесь можно задать такие параметры, как имя приложения, иконки,
    | цвета и описание в контексте PWA.
    |
    */

    'pwa' => [
        'name'             => 'Laravel Russian Community',
        'short_name'       => 'Laravel',
        'description'      => 'Русскоязычное комьюнити по Laravel',
        'background_color' => '#ffffff',
        'theme_color'      => '#f4645f',
        'display'          => 'standalone',
        'orientation'      => 'portrait',
        'scope'            => '/',
        'lang'             => 'ru',
        'start_url'        => '/?source=pwa',
        'capture_links'    => 'new-client',
        'url_handlers'     => [
            [
                'origin' => 'https://laravel.su',
            ],
            [
                'origin' => 'https://*.laravel.su',
            ],
        ],
        'intent_filters'   => [
            'scope_url_scheme' => 'https',
            'scope_url_host'   => parse_url(config('app.url'), PHP_URL_HOST),
            'scope_url_path'   => '/',
        ],
        'splash'           => [
            '2778x1284' => '/pwa/splash/apple-splash-2778-1284.png', // TODO
        ],
        'icons'            => [
            '512x512' => [
                'path'    => '/icons/icon-512x512.png', // TODO
                'purpose' => 'any maskable',
            ],
        ],
    ],

];
