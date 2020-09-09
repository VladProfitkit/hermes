<?php

//Сохранение
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    foreach (array_keys($admin_page_config) as $key) {
        update_option('aw_' . $key, stripslashes($_POST['aw_' . $key]));
    }
}

?>

<script>

(function($){
$(document).ready(function() {

    var wp_media_frame;
    var wp_media_type;
    var add_attachment_parent;

    //На кнопку Добавить и Изменить
    $('.button_attachmen_add, .button_attachment_edit').on('click', function(event){
        event.preventDefault();

        //image,audio,video,application
        if ($(this).hasClass('type_image')) {
            wp_media_type = 'image';
        } else {
            wp_media_type = 'application';
        }

        add_attachment_parent = $(event.target).parent();

        // If the media frame already exists, reopen it.
        /*if ( wp_media_frame ) {
            wp_media_frame.open();
            return;
        }*/

        // Create the media frame.
        wp_media_frame = wp.media({
            multiple: false,
            frame: 'post',
            library: {type: wp_media_type}
        });

        // When an image is selected, run a callback.
        wp_media_frame.on('insert', function() {

            var selection = wp_media_frame.state().get('selection');

            add_attachment_parent.find('input:hidden').first().val(selection.first().id);

            //Получаем из системного AJAX данные об аттачменте
            $.post(ajaxurl, {'action': 'get-attachment', id: selection.first().id}, function(data) {

                //Создаем ссылку на файл или изображение налету
                if (wp_media_type == 'application') {

                    add_attachment_parent.find('div.attachment_area')
                        .empty()
                        .append('<a href="' + data['data']['url'] + '">' + data['data']['filename'] + '</a>');

                } else if (wp_media_type == 'image') {

                    //Подбор изображения оптимального размера для превью
                    var img_url = data['data']['sizes']['full']['url'];
                    var img_h   = data['data']['sizes']['full']['height'];

                    //Если full-height > 150 - пытаемся найти поменьше
                    if (img_h > 150) {

                        for (var size in data['data']['sizes']) {

                            if (size != 'thumbnail' && data['data']['sizes'][size]['height'] < img_h && data['data']['sizes'][size]['height'] >= 150) {

                                img_url = data['data']['sizes'][size]['url'];
                                img_h = data['data']['sizes'][size]['height'];
                            }
                        }

                        img_h = 150;
                    }

                    add_attachment_parent.find('div.attachment_area')
                        .empty()
                        .append('<img src="' + img_url + '" height="' + img_h + '" alt="">');

                }

                add_attachment_parent.find('.button_attachment_edit').show();
                add_attachment_parent.find('.button_attachment_delete').show();
                add_attachment_parent.find('.button_attachmen_add').hide();
            });
        });

        wp_media_frame.open();
    });

    //На кнопку Удалить
    $('.button_attachment_delete').on('click', function(event){

        add_attachment_parent = $(event.target).parent();

        add_attachment_parent.find('input:hidden').first().val('');
        add_attachment_parent.find('div.attachment_area').empty();

        add_attachment_parent.find('.button_attachment_edit').hide();
        add_attachment_parent.find('.button_attachment_delete').hide();
        add_attachment_parent.find('.button_attachmen_add').show();
    });

});
})(jQuery);

</script>

<div class="wrap">

    <h1>Общие настройки</h1>

    <form method="post">

        <input type="hidden" name="action" value="update">

        <table class="form-table">

<?php

    foreach ($admin_page_config as $key => $data) {

        $option = 'aw_' . $key;
        $type = $data[1];

        echo '<tr>';
        echo '<th>' . $data[0] . '</th>';
        echo '<td>';

        if ($type == 'text') {
            echo '<input type="text" name="' . $option . '" value="' . htmlspecialchars(get_option($option)) . '" size="' . $data[2] . '">';
        } elseif ($type == 'tel') {
            echo '<input type="tel" name="' . $option . '" value="' . htmlspecialchars(get_option($option)) . '" size="' . $data[2] . '">';
        } elseif ($type == 'email') {
            echo '<input type="email" name="' . $option . '" value="' . htmlspecialchars(get_option($option)) . '" size="' . $data[2] . '">';
        } elseif ($type == 'textarea') {
            echo '<textarea name="' . $option . '" rows="' . $data[2] . '" style="width: 100%; max-width: 1000px">' . esc_textarea(get_option($option)) . '</textarea>';
        } elseif ($type == 'checkbox') {
            echo '<input type="checkbox" name="' . $option . '"' . (get_option($option) ? ' checked' : '') . '>';
        } elseif ($type == 'color') {
            echo '<input type="color" name="' . $option . '" value="' . get_option($option) . '">';
        } elseif ($type == 'number') {
            echo '<input type="number" name="' . $option . '" value="' . get_option($option) . '" min="' . $data[2][0] . '" max="' . $data[2][1] . '" step="' . $data[2][2] . '">';
        } elseif ($type == 'range') {
            echo '<input type="range" name="' . $option . '" value="' . get_option($option) . '" min="' . $data[2][0] . '" max="' . $data[2][1] . '" step="' . $data[2][2] . '">';
        } elseif ($type == 'select') {
            echo '<select name="' . $option . '">';
            foreach ($data[2] as $opt) {
                echo '<option' . (($opt == get_option($option))?' selected':'') . '>' . $opt . '</option>';
            }
            echo '</select>';
        } elseif ($type == 'wysiwyg') {
            echo '<div style="max-width: 1000px">';
            wp_editor(get_option($option), $option, array(
                'media_buttons' => $data[2][0],
                'textarea_rows' => $data[2][1],
            ));
            echo '</div>';
        } elseif ($type == 'image') {

            //Инициализация окна загрузки и выбора медиафайлов
            wp_enqueue_media();

            if (get_option($option)) {
                echo '<input type="hidden" name="' . $option . '" value="' . get_option($option) . '">';
                echo '<div style="float: left; margin-right: 10px" class="attachment_area">' . wp_get_attachment_image(get_option($option), array(500,150)) . '</div>';
                echo '<input type="button" class="button button_attachment_edit type_image" style="margin-bottom: 10px" value="Изменить изображение"><br>';
                echo '<input type="button" class="button button_attachment_delete" value="Удалить изображение">';
                echo '<input type="button" class="button button_attachmen_add type_image" style="display: none" value="Добавить изображение">';
            } else {
                echo '<input type="hidden" name="' . $option . '">';
                echo '<div style="float: left; margin-right: 10px" class="attachment_area"></div>';
                echo '<input type="button" class="button button_attachment_edit type_image" style="display: none; margin-bottom: 10px" value="Изменить изображение"><br>';
                echo '<input type="button" class="button button_attachment_delete" style="display: none" value="Удалить изображение">';
                echo '<input type="button" class="button button_attachmen_add type_image" value="Добавить изображение">';
            }

        } elseif ($type == 'file') {

            //Инициализация окна загрузки и выбора медиафайлов
            wp_enqueue_media();

            if (get_option($option)) {
                echo '<input type="hidden" name="' . $option . '" value="' . get_option($option) . '">';
                echo '<div style="float: left; margin-right: 10px" class="attachment_area">' . wp_get_attachment_link(get_option($option), null, false, false, basename(get_attached_file(get_option($option)))) . '</div>';
                echo '<input type="button" class="button button_attachment_edit type_application" value="Изменить файл">&nbsp;';
                echo '<input type="button" class="button button_attachment_delete" value="Удалить файл">';
                echo '<input type="button" class="button button_attachmen_add type_application" style="display: none" value="Добавить файл">';
            } else {
                echo '<input type="hidden" name="' . $option . '">';
                echo '<div style="float: left; margin-right: 10px" class="attachment_area"></div>';
                echo '<input type="button" class="button button_attachment_edit type_application" style="display: none" value="Изменить файл">&nbsp;';
                echo '<input type="button" class="button button_attachment_delete" style="display: none" value="Удалить файл">';
                echo '<input type="button" class="button button_attachmen_add type_application" value="Добавить файл">';
            }
        }

        echo '</td>';
        echo '</tr>';

    }

?>

        </table>

        <?php submit_button(); ?>

    </form>

</div>
