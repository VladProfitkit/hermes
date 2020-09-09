<?php
//Отключение админской панели
add_filter('show_admin_bar', '__return_false');

//Отключение Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

//Регистрируем поддержку HTML5
add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));

//Максимальное количество ревизий поста
add_filter( 'wp_revisions_to_keep', function ($revisions) {
    return 20;
});

//Ссылка с галереи всегда на только файл
add_filter('shortcode_atts_gallery', function ($result) {
        if ($result['link'] != 'none') {
            $result['link'] = 'file';
        }
        return $result;
});

//Удаление "лишних" (h1, h2) форматов из редактора TinyMCE
add_filter('tiny_mce_before_init', function ($init) {
    $init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6;Pre=pre';
    return $init;
});

//Подключение jQuery
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('jquery');
});

//Подключение CSS и JS только на front-end
add_action('wp_enqueue_scripts', function () {

    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/libs/bootstrap-4.1.3-dist/css/bootstrap.min.css');

    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_script('main', get_template_directory_uri() . '/main.js', array('jquery'));
    wp_enqueue_script('slider', get_template_directory_uri() . '/slider.js', array('jquery'));
    wp_enqueue_style('slider', get_template_directory_uri() . '/slider.css');

});

//// BlankSlate Theme
add_action('after_setup_theme', function () {

    load_theme_textdomain('aw', get_template_directory() . '/languages'); //Локализация темы, если у темы есть свой файл .mo

    add_theme_support('title-tag');            //Автоматически вставляет <title>
    add_theme_support('automatic-feed-links'); //RSS
    add_theme_support('post-thumbnails');      //Разрешаем миниатюру для поста

    global $content_width;
    if (!isset($content_width)) {
        $content_width = 680;                  //Ширина для встраеваемых объектов (видео) и ширина для размера изображений "Большой"
    }

    register_nav_menus(array(                  //Подключение меню
        'main-menu' => 'Верхнее меню',
    ));
});
////

//// Удаление пунктов из админского меню
//Из админской панели
add_action('admin_menu', function () {

    //remove_submenu_page('themes.php', 'themes.php'); //"Темы"
    remove_submenu_page('themes.php', 'widgets.php'); //"Виджеты"
    remove_submenu_page('themes.php', 'theme-editor.php'); //"Редактор"

    //global $submenu;
    //unset($submenu['themes.php'][6]); //"Настроить"
}, 102);

//Из интерфейса Настроить
add_action('customize_register', function ($wp_customize) {

    $wp_customize->remove_section('themes');
    //$wp_customize->remove_panel('widgets');
    $wp_customize->remove_control('custom_css');
});
////


////Меню по шорткоду
//Шорткод: [manu name="Моё меню"]
add_shortcode('menu', function($atts) {

    $html = '<nav>';

    $args = [
        'theme_location'  => '',
        'menu'            => $atts['name'],
        'container'       => '',
        'menu_class'      => 'menu_on_page',
        'menu_id'         => '',
        'echo'            => false,
        'fallback_cb'     => 'wp_page_menu',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'item_spacing'    => 'discard',
      //  'depth'           => 1
    ];

    //Если находится меню с таким именем (из параметра)
    if (wp_get_nav_menu_object($args['menu'])) {
        $html .= wp_nav_menu($args);
    }

    $html .= '</nav>';

    return $html;
});


//Добавление иконок в меню через ACF
add_filter('wp_nav_menu_objects', function ($items) {

    foreach($items as $item) {

        $image = get_field('image', $item);

        if ($image) {
            $item->title = '<i style="background-image: url(\'' . $image['sizes']['medium'] . '\')"></i>' . $item->title;
        }
    }

    return $items;

}, 10, 2);
////


////Опции сайта
//Version 2.0
//Добавление пункта в меню и виртуальной страницы, контент которой будет выдавать функция
add_action('admin_menu', function () {

    //Конфиг
    $admin_pages = [

        [
            'page_title' => 'Общие настройки',
            'menu_title' => 'Общие настройки',
            'capability' => 'manage_options',
            'menu_slug'  => 'aw-options-page',

            'config'     => [

                //Ключ-опция      Подпись, Тип, ... Все параметры обязательны
                'name'        => ['Название', 'text', 50], //Input size
                'subname'     => ['Подпись под названием', 'text', 50], //Input size
                'address'     => ['Адрес', 'textarea', 5], //Количество строк
                'phone'       => ['Телефоны', 'textarea', 2], //Количество строк
                'phone_comment' => ['Подпись под телефоном', 'text', 50], //Количество строк
                'copy_text'   => ['Текст копирайта', 'text', 50], //Input size
                'top_link'    => ['Ссылка в шапке', 'textarea', 2], //Количество строк

                'og_image'    => ['Изоражение для социальных сетей', 'image'], //Изоражение
            ]
        ],

        [
            'page_title' => 'Счетчики',
            'menu_title' => 'Счетчики',
            'capability' => 'manage_options',
            'menu_slug'  => 'aw-counters-page',

            'config'     => [

                //Ключ-опция        Подпись, Тип, ... Все параметры обязательны
                'counters'      => ['Коды счетчиков', 'textarea', 12], //Количество строк
                'counters_area' => ['Выводить', 'select', ['head' => 'В области HEAD', 'body' => 'В области BODY']],
            ]
        ]

    ];


    //Генерация пунктов меню
    foreach ($admin_pages as $admin_page) {

        add_theme_page(
            $admin_page['page_title'],
            $admin_page['menu_title'],
            $admin_page['capability'],
            $admin_page['menu_slug'],
            function () use ($admin_page) {

                $admin_page_config = $admin_page['config'];

                include_once('admin/admin-page.php');
            }
        );
    }
});

function aw_option($key, $nl2br = false)
{
    $option = get_option('aw_' . $key);

    if ($nl2br) {
        $option = nl2br($option);
    }

    return $option;
}

function aw_email()
{
    $emails = preg_split('/\r\n|\n/', get_option('aw_email'), -1, PREG_SPLIT_NO_EMPTY);

    $emails = array_map (function($email) {
        return '<a href="mailto:' . $email . '">' . $email . '</a>';
    }, $emails);

    return join('<br>', $emails);
}

function aw_phone($select_number = '', $separator = '<br>')
{
    $phones = preg_split('/\r\n|\n/', get_option('aw_phone'), -1, PREG_SPLIT_NO_EMPTY);

    $phones = array_map (function($phone) use ($select_number) {
        if ($select_number) {
            $phone = preg_replace('/(\d{3}-?\d{2}-?\d{2})$/', '<' . $select_number . '>\\1</' . $select_number . '>', $phone);
        }

        return '<a href="tel:' . preg_replace('/[^0-9+]/', '', $phone) . '">' . $phone . '</a>';
    }, $phones);

    return join($separator, $phones);
}

//Изображение og:image
if (aw_option('og_image')) {
    add_action('wp_head', function(){
        echo '<meta property="og:image" content="' . wp_get_attachment_image_url(aw_option('og_image'), 'full') . '">' . "\n";
    });
}

//Счетчики в шапке или теле
if (aw_option('counters')) {
    if (aw_option('counters_area') == 'head') {
        add_action('wp_head', function() {
            echo "\n" . aw_option('counters') . "\n";
        });
    } else {
        add_action('wp_body_open', function() {
            echo "\n" . aw_option('counters') . "\n";
        });
    }
}

////


////
//Регистрация типа записи
add_action('init', function () {

    register_post_type('post_slider', array(
        'labels'              => array(
            'name'               => 'Слайдер',
            'singular_name'      => 'Слайд',
            'menu_name'          => 'Слайдер',
            'add_new'            => 'Добавить слайд',
            'add_new_item'       => 'Добавление слайда',
            'new_item'           => 'Новый слайд',
            'edit_item'          => 'Редактирование слайда',
            'view_item'          => 'Смотреть слайд',
            'all_items'          => 'Все слайды',
            'search_items'       => 'Искать слайд',
            'not_found'          => 'Не найдено',
            'not_found_in_trash' => 'Не найдено в корзине'
            ),

        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => true,  //Исключить из поиска
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => false, //Разрешить добавлять в меню навигации
        'menu_position'       => 4,
        'menu_icon'           => 'dashicons-images-alt2',
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'thumbnail', 'page-attributes'), //Поля одной записи: title,editor,author,thumbnail,excerpt,trackbacks,custom-fields,comments,revisions,page-attributes,post-formats
        'taxonomies'          => array(), //Нужна ли таксономия, например категории 'category'
    ));

});
////

//Альтернатива the_excerpt
function the_announcement($trim = '', $show_link = null, $allow_tags = null, $more_link_text = null)
{
    global $post;

    $trim_words = false;
    $possible_link = false;
    $output = '';

    //Если Отрывок задан отдельно - ничего резать не будем
    if ($post->post_excerpt) {

        $post_content = $post->post_excerpt;

    } else {

        if (preg_match('/(\d+)/', $trim, $matches)) {
            $trim_length = $matches[1];
        } else {
            $trim_length = 55;
        }

        if (preg_match('/more/', $trim) && preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches)) {

            if (!empty($matches[1])) {
                $more_link_text = strip_tags(wp_kses_no_null(trim($matches[1])));
            }

            $post_content = get_the_content('');

            $possible_link = true;

        } else {

            $post_content = $post->post_content;

            $trim_words = true;
        }
    }

    if ($show_link === null) {
        $show_link = -1;
    }

    if ($allow_tags === null) {
        $allow_tags = '<p><br><ul><ol><li><em><strong><i><b><blockquote>';
    }

    if ($more_link_text === null) {
        $more_link_text = sprintf(__('Continue reading %s'), '&rarr;');
    }

    $post_content = strip_shortcodes($post_content);
    $post_content = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $post_content);
    $post_content = str_replace(']]>', ']]&gt;', $post_content);

    if ($allow_tags !== true) {

        $post_content = strip_tags($post_content, $allow_tags);

        if (!preg_match('/<p>|<br>/', $allow_tags)) {
            $post_content = preg_replace('/[\r\n\t ]+/', ' ', $post_content);
        }
    }

    if ($trim_words) {

        $parts = preg_split('/(<\/?[a-z][^>]*>|[\n\r\t ]+|[.,:;!?+]+)/', $post_content, $trim_length + 1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        if (count(preg_split('/(<\/?[a-z][^>]*>|[\n\r\t ]+|[.,:;!?+]+)/', $post_content, $trim_length + 1, PREG_SPLIT_NO_EMPTY)) > $trim_length) {

            array_pop($parts);

            $possible_link = true;
        }

        $output = join('', $parts);

    } else {
        $output = $post_content;
    }

    $output = trim($output);

    $output = force_balance_tags($output);

    if ($show_link > 0 || ($show_link == -1 && $possible_link)) {
        $output .= '&hellip; <a href="' . get_permalink($post->ID) . '" class="read_more">' . $more_link_text . '</a>';
    }

    echo apply_filters('the_content', $output);
}

function the_breadcrumb($separator = null, $front_page = null, $links = null)
{
    //Текущий объект
    $term_object = get_queried_object();

    if ($separator === null) {
        $separator = ' / ';
    }

    if ($front_page === null) {
        $front_page = __('Home', 'aw');
    }

    $breadcrumb = array();

    if (is_page()) {

        if ($term_object->post_title) {
            array_unshift($breadcrumb, '<span>' . trim_by_words($term_object->post_title) . '</span>');
        }

        //Пока есть родители
        while ($term_object->post_parent) {

            $term_object = get_post($term_object->post_parent);

            array_unshift($breadcrumb, '<a href="' . get_permalink($term_object->ID) . '">' . trim_by_words($term_object->post_title) . '</a>');
        }

    } elseif (is_single()) {

        if ($term_object->post_title) {
            array_unshift($breadcrumb, '<span>' . trim_by_words($term_object->post_title) . '</span>');
        }

        $object_taxonomies = get_object_taxonomies($term_object);

        if ($object_taxonomies) {

            //Грубо берем нулевую таксономию
            $post_terms = get_the_terms($term_object->ID, $object_taxonomies[0]);

            //Грубо берем последний объект категории ("Без рубрики" - всегда первая)
            $term_object = $post_terms[count($post_terms) - 1];

            array_unshift($breadcrumb, '<a href="' . get_category_link($term_object->term_id) . '">' . $term_object->name . '</a>');

            //Пока есть родители
            while ($term_object->parent) {

                $term_object = get_term($term_object->parent, $term_object->taxonomy);

                array_unshift($breadcrumb, '<a href="' . get_category_link($term_object->term_id) . '">' . $term_object->name . '</a>');
            }
        }

    } elseif (is_category() || is_tax()) {

        array_unshift($breadcrumb, '<span>' . $term_object->name . '</span>');

        //Пока есть родители
        while ($term_object->parent) {

            $term_object = get_term($term_object->parent, $term_object->taxonomy);

            array_unshift($breadcrumb, '<a href="' . get_category_link($term_object->term_id) . '">' . $term_object->name . '</a>');
        }
    }

    if (is_array($links)) {
        foreach (array_reverse($links) as $link) {
            array_unshift($breadcrumb, $link);
        }
    }

    if ($front_page) {
        array_unshift($breadcrumb, '<a href="/">' . $front_page . '</a>');
    }

    echo join($separator, $breadcrumb);
}

function the_links2pages($text = '', $arrow_prev = '', $arrow_next = '', $before = '', $after = '')
{
    global $paged;
    global $wp_query;

    $max_num_pages = $wp_query->max_num_pages;

    if ($max_num_pages>1) {

        echo $before;

        if (!$paged) {
            $paged = 1;
        }

        if ($text) {
            echo '<span class="nav_before">' . $text . '</span>';
        }

        if (isset($arrow_prev) && $paged>1) {
            echo '<a href="' . get_pagenum_link($paged-1) . '" class="nav_prev">' . $arrow_prev . '</a>';
        }

        for($i = 1; $i <= $max_num_pages; $i++) {

            if ($max_num_pages <= 10 || $i <= 3 || $i > $max_num_pages - 3 || ($i >= $paged - 2 && $i <= $paged + 2)) {
                echo ($i == $paged) ? '<span class="nav_current">' . $i . '</span>' : '<a href="' . get_pagenum_link($i) . '" class="nav_link">' . $i . '</a>';
            } elseif ($i == $paged + 3 || $i == $paged - 3) {
                echo '...';
            }
        }

        if (isset($arrow_next) && $paged<$max_num_pages) {
            echo '<a href="' . get_pagenum_link($paged+1) . '" class="nav_next">' . $arrow_next . '</a>';
        }

        echo $after;
    }
}

function the_group_class($class = null)
{
    echo ' class="post_group';

    if (is_category()) {
        $term_object = get_queried_object();
        echo ' category category_' . $term_object->slug;
    } elseif (is_page()) {
        echo ' page';
    } elseif (is_singular()) {
        echo ' singular';
    } elseif (is_search()) {
        echo ' search';
    }

    if ($class) {
        echo " $class";
    }

    echo '"';
}

function the_entry_class($class = null)
{
    global $post;

    echo ' class="type_' . $post->post_type;

    if (is_singular()) {
        echo ' post_singular';
    } elseif (is_category()) {
        echo ' post_category';
    } elseif (is_search()) {
        echo ' post_search';
    }

    if (has_category()) {
        foreach (get_the_category() as $wpt_obj) {

            if (preg_match('/^[A-Za-z0-9_-]+$/', $wpt_obj->slug)) {
                $term_class = $wpt_obj->slug;
            } else {
                $term_class = $wpt_obj->term_id;
            }

            echo ' post_category_' . $term_class;
        }
    }

    echo ' ' . $post->post_type . '_id' . $post->ID;

    if ($class) {
        echo " $class";
    }

    echo '"';
}

function trim_by_words($str, $count = 100, $after = '...')
{
    if (strlen($str) > $count) {

        $str = wordwrap($str, $count);
        return substr($str, 0, strpos($str, "\n")) . $after;

    }  else {
        return $str;
    }
}

function get_month_rus($date)
{
    $months = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');

    if (preg_match('/(\d+)\.(\d+)\.(\d+)/', $date, $matches)) {
        return $matches[1] . ' ' . $months[$matches[2]-1] . ' ' . $matches[3];
    } else {
        return $date;
    }
}

//Debug
function pre($var)
{
    echo '<pre>'; print_r($var); echo '</pre>';
}