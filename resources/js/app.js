import './bootstrap';
import 'bootstrap';
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;
import '../sass/app.scss';

$(function() {
    console.log("Tokyo Current: Söya. Engine Started");

    const $menu = $('#globalNav');
    const $trigger = $('#menuTrigger');

    // メニュー開閉
    $trigger.on('click', function() {
        $(this).toggleClass('is-active');
        $menu.toggleClass('is-open');

        // 丼がカチャッと動く振動演出
        if($(this).hasClass('is-active')) {
            $(this).addClass('animate__animated animate__headShake');
            setTimeout(() => {
                $(this).removeClass('animate__animated animate__headShake');
            }, 500);
        }
    });

    // リンククリックで閉じる
    $('.nav-item').on('click', function() {
        $trigger.removeClass('is-active');
        $menu.removeClass('is-open');
    });
});
