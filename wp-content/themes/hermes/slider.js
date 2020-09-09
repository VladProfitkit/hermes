//Version 2.0
(function($){

$(document).ready(function() {

    //Slider
    (function() {

        var config = {
                        'type'           : 'slide',    //Эффект смены кадров: slide - новый слайд выдавливает старый; slide_over - новый поверх старого; fade - старый расстворяется
                        'duration'       : 500,        //Продолжительность анимации, мс
                        'easing'         : 'swing',    //linear
                        'force_complete' : true,       //Прерывать анимацию до окончания, чтобы отработать нажатие по плюшке или < >

                        'slider_class'   : '.slider',
                        'slider_element' : 'li',

                        'autoplay'       : true,
                        'autoplay_delay' : 4000,       //Задержа между авто-анимацией, мс

                        'show_bullets'   : true,       //Генерировать скриптом блок для вывода плюшек * * * * - как альтернатива, их можно нарисовать самостоятельно.
                        'show_nav'       : false        //Генерировать скриптом блоки для стрелок < > - как альтернатива, их можно нарисовать самостоятельно.
                     };

        //Если есть слайдер со слайдами
        if ($(config['slider_class'] + ' ' + config['slider_element'] + '.slider_slide').length) {

            //Для каждого слайдера на странице
            $(config['slider_class']).each(function() {

                var slider = $(this);
                var slider_container = slider.find('.slider_container');

                var slider_bullets;

                var slides = [];
                var current_i = 0;

                var timeout;
                var pause_flag, stop_flag;
                var animated_flag;

                //Функция смены слайдов
                var show_slide = function(direction, n)
                {
                    var next_i;

                    if (n == current_i) {
                        return;
                    }

                    if (direction > 0) {
                        next_i = (n == undefined) ? ((current_i + 1 < slides.length) ? current_i + 1 : 0) : n;
                    } else {
                        next_i = (current_i - 1 >= 0) ? current_i - 1 : slides.length - 1;
                    }

                    //Если сейчас анимация и ее не разрешено прирывать
                    if (animated_flag && !config['force_complete']) {
                        return;
                    }

                    //Тип перехода - один выдавливает другой
                    if (config['type'] == 'slide') {

                        if (animated_flag) {
                            slider_container.stop();
                        }

                        slider_container.empty()

                        slides[current_i]
                            .css({position: 'absolute', top: 0})
                            .appendTo(slider_container);

                        slides[next_i]
                            .css({position: 'absolute', top: 0})
                            .appendTo(slider_container);

                        if (direction > 0) {

                            slides[current_i].css({left: 0});
                            slides[next_i].css({left: '100%'});

                            slider_container
                                .css({left: 0})
                                .animate({left: '-100%'}, config['duration'], config['easing'], complete);

                        } else {

                            slides[current_i].css({left: '100%'})
                            slides[next_i].css({left: 0})

                            slider_container
                                .css({left: '-100%'})
                                .animate({left: 0}, config['duration'], config['easing'], complete);
                        }

                    //Тип перехода - слайд сверху
                    } else if (config['type'] == 'slide_over') {

                        if (animated_flag) {
                            slides[current_i]
                                .stop()
                                .css({left: 0});
                        }

                        slider.find(config['slider_element'] + '.slider_slide').hide();

                        slides[current_i]
                            .show()
                            .css({zIndex: 5});

                        slides[next_i]
                            .show()
                            .css({position: 'absolute', top: 0, zIndex: 10});

                        if (direction > 0) {
                            slides[next_i].css({left: '100%'});
                        } else {
                            slides[next_i].css({left: '-100%'});
                        }

                        slides[next_i].animate({left: 0}, config['duration'], config['easing'], complete);

                    //Тип перехода - слайд тает
                    } else if (config['type'] == 'fade') {

                        if (animated_flag) {
                            slider.find(':animated')
                                .stop()
                                .css({display: 'none', opacity: 1});
                        }

                        slides[next_i]
                            .show()
                            .css({position: 'absolute', top: 0, left: 0, zIndex: 5});

                        slides[current_i]
                            .css({zIndex: 10})
                            .fadeOut(config['duration'], config['easing'], complete);
                    }

                    animated_flag = true;

                    current_i = next_i;

                    bullet(current_i);
                }

                //Вывод актуальной плюшки
                var bullet = function(n)
                {
                    if (slider_bullets.length) {

                        slider_bullets.find('div').removeClass('active');
                        slider_bullets.find('div:eq(' + n + ')').addClass('active');
                    }
                }

                var complete = function() {

                    animated_flag = false;

                    play();
                }

                var play = function() {

                    if (config['autoplay'] && !stop_flag && !pause_flag) {

                        timeout = setTimeout(function() {
                            show_slide(+1);
                        }, config['autoplay_delay']);
                    }
                }

                var pause_autoplay = function() {

                    if (pause_flag) {

                        pause_flag = false;

                        play();

                    } else {

                        clearTimeout(timeout);

                        pause_flag = true;
                    }

                }

                var stop_autoplay = function() {

                    clearTimeout(timeout);

                    stop_flag = true;
                }

                //// Начало

                //Если слайдов больше одного
                if (slider.find(config['slider_element'] + '.slider_slide').length > 1) {

                    //Если автодобавка плюшек
                    if (config['show_bullets']) {

                        $('<div></div>')
                            .addClass('slider_bullets')
                            .appendTo(slider);
                    }

                    //Если автодобавка стрелок < >
                    if (config['show_nav']) {

                        $('<div></div>')
                            .addClass('slider_prev')
                            .appendTo(slider);

                        $('<div></div>')
                            .addClass('slider_next')
                            .appendTo(slider);
                    }

                    //Если добавлено здесь или прямо в HTML
                    slider_bullets = slider.find('.slider_bullets');

                    //Клик по "<"
                    slider.find('.slider_prev').click(function(){
                        stop_autoplay();
                        show_slide(-1);
                    });

                    //Клик по ">"
                    slider.find('.slider_next').click(function(){
                        stop_autoplay();
                        show_slide(+1);
                    });

                    //Собираем в массив, чтобы потом иметь доступ к любому по буллету
                    slider.find(config['slider_element'] + '.slider_slide').each(function(){

                        slides.push($(this));

                        //Если надо выводить плюшки
                        if (slider_bullets.length) {

                            $('<div></div>')
                                .appendTo(slider_bullets)
                                .click(function(e){

                                    //От всплытия
                                    e.stopPropagation();

                                    stop_autoplay();

                                    show_slide(+1, $(this).index());
                                });
                        }
                    });

                    slider.mouseover(function() {

                        pause_autoplay();
                    });

                    slider.mouseout(function() {

                        pause_autoplay();
                    });

                    bullet(0);

                    play();

                } else {

                    slider.find('.slider_prev').hide();
                    slider.find('.slider_next').hide();
                }
            });
        }

    })();
    ////Slider

});

})(jQuery);
