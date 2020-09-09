<?php
/*
Plugin Name: Awart Lightbox
Plugin URI: https://awart.ru
Description: Simple Lightbox
Version: 1.1
Author: Andrew Miagkov
Author URI: https://awart.ru
*/
?>
<?php
/*  Copyright 2017  Andrew Miagkov  (email: andr@awart.ru)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php

if (!is_admin()) {

    add_action('wp_enqueue_scripts', function () {

        wp_enqueue_script('awart-lightbox', plugin_dir_url(__FILE__) . 'lightbox.js', ['jquery']);
        wp_enqueue_style('awart-lightbox', plugin_dir_url(__FILE__) . 'lightbox.css');

    });
}

?>