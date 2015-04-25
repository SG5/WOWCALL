(function($){
    'use strict';

    var ajax = function(data, callback) {
        $.post('/front.php', data, function(response) {
            if ('ok' !== response.status) {
                toastr.error(response.reason);
                return;
            }
            callback && callback();
        }, 'json');
    };

    $('.requestCallWithPassword').click(function(){
        var phone = $(this).closest('.input-group').children('input').val();
        var data = {
            class: 'Call',
            action: 'callWithPassword',
            data: [phone]
        };

        ajax(data, function() {
            $(".requestCallWithPassword-passwordField").removeClass("hidden");
        });
    });

    $(".validateCallPassword").click(function() {
        var password = $(this).closest('.input-group').children('input').val();
        if (4 != password.length) {
            toastr.error('Введите 4 цифр пароля');
            return;
        }
        var data = {
            class: 'Call',
            action: 'validatePassword',
            data: [password]
        };

        $.post('/front.php', data, function(response) {
            if (!response) {
                toastr.error('Пароль не верный')
            } else {
                toastr.success('Пароль услышан правильно')
            }
        }, 'json');
    });

    $(".requestCallback").click(function(){
        var phones = [];
        $(this).closest(".col-md-3").find("input").each(function(){
            phones.push($(this).val());
        });

        var data = {
            class: 'Ivr',
            action: 'IvrDemo',
            data: phones
        };

        ajax(data);
    });

}(jQuery));