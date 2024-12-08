jQuery(document).ready(function ($) {

    $('.profile-settings__personalData-wrapper').click(function (event) {
        event.stopPropagation();
        let $currentList = $(this).find('.profile-settings__personalData-list').toggleClass('active');
        $('.profile-settings__personalData-list').not($currentList).removeClass('active')
    });
    $(document).click(function () {
        $('.profile-settings__personalData-list').removeClass('active');
    });

    $('.profile-settings__personalData-list__item').on('click', function (event) {
        let $target = $(event.target);
        let value = $target.attr('data-value') || '';
        let $input = $target.closest('.profile-settings__personalData-wrapper').find('input');
        if ($target.closest('.personalData-list--text').length) {
            $input.attr('data-value', value);
            value = $target.text().trim();
        }
        if (!value) return;

        $input.val(value)
    });

    // $('.js-input-edit').on('click', function(event) {
    //     let $item = $(this).closest('.profile-settings__item');
    //     $item.is(".edit") ? $item.find('input').prop('readonly', true) : $item.find('input').removeAttr('readonly')
    //
    //     if ($item.is('.profile-settings__password-item')) {
    //         let $passwordStrengthMeter = $('.password-strength-meter');
    //         if (typeof LLMS !== 'undefined' && typeof LLMS.PasswordStrength !== 'undefined') {
    //             if ($passwordStrengthMeter.length) {
    //                 $passwordStrengthMeter.toggle();
    //             }
    //         }
    //
    //         let $items = $item.closest('.profile-settings__password').find('.profile-settings__item');
    //         let $hiddenItems = $item.closest('.profile-settings__password').find('.profile-settings__item-hidden');
    //         $items.toggleClass('edit');
    //         $($items[0]).find('input').toggleClass('hidden');
    //         $hiddenItems.toggleClass('hidden');
    //         $items.find('.profile-settings__password-value').toggle();
    //     } else {
    //         $item.toggleClass('edit');
    //     }
    // })
    function getCookie(name) {
        let cookieArray = document.cookie.split(';');
        for(let i = 0; i < cookieArray.length; i++) {
            let cookiePair = cookieArray[i].split('=');
            if (name == cookiePair[0].trim()) {
                return decodeURIComponent(cookiePair[1]);
            }
        }
        return null;
    }

    let currentLanguage = getCookie('wp-wpml_current_language');


    let $llms_phone = $("#llms_phone");
    if ($llms_phone.length) {
        $llms_phone.mask("+38(099)? 999 99 99",{autoclear: false, placeholder: " "});
    }

    $('.js-switch-account-cancel').on('click', function(event) {
        event.preventDefault();
        
        $('.modal__close').click();
    })

    $(document).on('click', '.js-switch-account-change', function (event) {
        event.preventDefault();

        let data = {
            action: 'switchUserToRepresentative',
        };

        $('.modal__close').click();

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('accountType') && response.hasOwnProperty('municipality')) {
                    $('.account-type').val(response['accountType']);
                    $('.js-switch-account').css('opacity', 0).css('pointer-events', 'none');
                    $('.notifications-nav-item').after(response['municipality']);
                    $('#switchAccount').iziModal('close');
                    location.reload();
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        });
    });

    if($('.c-modal-medium').length) {
        $(".c-modal-medium").iziModal({
            width: 552,
            closeButton: false,
            focusInput: false,
            padding: 16,
            overlayColor: 'rgba(19, 19, 22, 0.60)',
            transitionIn: 'fadeInUp',
            transitionOut:	'fadeOutDown',
        });
    }
    function updateEDRPOUCode(edrpouCode,button) {
        jQuery.ajax({
            url: ajaxurl, // Используем глобальную переменную WordPress для URL AJAX-запросов
            type: 'POST',
            data: {
                'action': 'update_edrpou_code', // Действие, определенное в PHP для обработки запроса
                'edrpou_code': edrpouCode // Передаем код EDRPOU
            },
            success: function(response) {
                console.log(response); // Логируем ответ для разработчика

                // Проверяем, успешно ли выполнено обновление на сервере
                if (response.success) {
                    console.log('EDRPOU Code updated successfully.');
                    $('.edrpou_Edit').removeClass('disabled').removeAttr('disabled'); // Активируем элементы управления
                    $('.muni_error').hide(); // Скрываем сообщения об ошибках
                    if(currentLanguage=='en'){
                        button.text('Edit');
                    }else{
                        button.text('Редагувати');
                    }
                    $(this).toggleClass('saveInn');
                }  else {
                    $('.muni_error').text(response.data.message)
                    // Любая другая логика обработки ошибок
                    $('.muni_error').show(); // Скрываем сообщения об ошибках


                }
            },
            error: function(error) {
                console.error('Error:', error); // Обработка ошибки запроса

                // Показываем сообщение об ошибке пользователю
                $('.muni_error').text('An error occurred while updating the EDRPOU Code. Please try again.').show();
                $('.edrpou_Edit').addClass('disabled').attr('disabled', 'disabled'); // Деактивируем элементы управления
            }
        });
    }

    $('#not_have_tin').on('change', function(event) {
        let title = '';
        let $labelTin = $('.form__input-field-tin');
        title = $labelTin.attr('data-title')
        let currentTitle = $labelTin.attr('placeholder');
        $labelTin.attr('placeholder', title);
        $labelTin.attr('data-title', currentTitle);
        $labelTin.val('');
        $labelTin.toggleClass('old-tin');
    });

    $(document).on('input blur', '.form__input-field-tin:not(.old-tin)', function (event) {
        let $tin = $(this);
        let value = $tin.val();
        let tin = value.trim();
        let lngth = 10;
        let error = false;
        if (/[^0-9]+/.test(tin)) {
            $tin.closest('label').addClass('mdc-text-field--invalid');
            tin = tin.replace(/[^0-9]+/, '');
            $(this).val(tin);
            error = true;
        } else if (tin.length > lngth || /\s/.test(value)) {
            $tin.closest('label').addClass('mdc-text-field--invalid');
            tin = tin.slice(0, -1);
            $(this).val(tin);
            error = true;
        } else if (tin && tin.length === lngth) {
            $tin.closest('label').removeClass('mdc-text-field--invalid');
        }
        let $error = $('.error-tip-tin');
        if ($error && $error.length) {
            if (error) {
                $error.show()
            } else {
                $error.hide()
            }
        }
    });

    $(document).on('input blur', '.form__input-field-tin.old-tin', function (event) {
        let $tin = $(this);
        let value = $tin.val();
        let tin = value.trim();
        let error = false;
        let lngth = 9;
        let old = false;//МР 123456
        if ($tin.is('.old-tin')) {
            if (/^[А-Яа-яёЁЇїІіЄєҐґA-Za-z]/.test(tin)) {
                old = true;
            }
        }
        if (!old && /[^0-9]+/.test(tin)) {
            tin = tin.replace(/[^0-9]+/, '');
            $(this).val(tin);
            error = true;
        } else if (((/^\s/.test(value)) || (/\s{2,}/.test(value)) )) {
            value = value.slice(0, -1);
            $(this).val(value);
            error = true;
        } else if (old && (/\s/.test(value) && value.lastIndexOf(' ') !== 2) ) {
            value = value.slice(0, -1);
            $(this).val(value);
            error = true;
        } else if (old && (tin.length === 3 && /[^\s]+/.test(tin.slice(2,3))) ) {
            tin = tin.slice(0, -1);
            tin += ' ';
            $(this).val(tin);
            error = true;
        } else if (old && (tin.length < 3 && /[^А-Яа-яёЁЇїІіЄєҐґA-Za-z]/.test(tin))
             || (tin.length > 3 && tin.length <= 9 && /[^0-9]+/.test(tin.slice(3)))) {
            tin = tin.slice(0, -1);
            $(this).val(tin);
            error = true;
        } else if (tin.length > lngth) {
            tin = tin.slice(0, -1);
            $(this).val(tin);
            error = true;
        } else if (tin && tin.length === lngth) {
            $tin.removeClass('mdc-text-field--invalid');
        }
        let $error = $('.error-tip-tin-old');
        if ($error && $error.length) {
            if (error) {
                $tin.addClass('mdc-text-field--invalid');
                $error.show()
            } else {
                $tin.removeClass('mdc-text-field--invalid');
                $error.hide()
            }
        }
    });

    $('#email_address').on('input blur', function(event) {
        let $target = $(event.target);
        let $field = $('.wrapper-error-email');
        let email = $target.val().trim();
        let $errorEmail = $('.error-email');
        let validEmail = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.(?!ru)[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(email);
        if (!validEmail) {
            $target.addClass('mdc-text-field--invalid');
            if (event.type === 'blur') {
                $('.error-tip').hide();
                $field.removeClass('hidden');
                $errorEmail.show()
            }
        } else {
            $field.addClass('hidden');
            $target.removeClass('mdc-text-field--invalid');
            $('.error-tip').hide();
        }
    });

// Пример использования

    $('.form__input-button').click(function(event) {

        if($(this).hasClass('saveInn')){
            let $tin = $('.form__input-field-tin');
            let isOldTin = $tin.is('.old-tin');
            let length = isOldTin? 9 : 10;
            let $error = isOldTin? $('.error-tip-tin-old') : $('.error-tip-tin');
            if($tin.val().length < length){
                $error.show();
            }else{
                $error.hide();
                updateEDRPOUCode($('input[name="edrpou_code"]').val(),$(this));
            }
            return;
        }

        let $target = $(event.target);
        let modal = $target.attr('data-modal') || '';
        if(modal =="edrpou_code"){
            $('input[name="edrpou_code"]').removeAttr('disabled');
            $('input[name="edrpou_code"]').removeClass('cancelEdit');
            $('input[name="edrpou_code"]').focus();
            if(currentLanguage=='en'){
                $(this).text('Save');
            }else{
                $(this).text('Зберегти');
            }
            $(this).toggleClass('saveInn');

        }
        if (modal) {
            let $modal = $('#modal__'+modal);
            $modal.addClass('active-modal');
            // $('body').css({'overflow': 'hidden'});
        }
    });

    $('.profile-settings__modal-save').on('click', function(event) {
        event.preventDefault();

        let $target = $(event.target);
        let ajax = $target.attr('data-ajax') || '';
        let data = {};
        if (ajax && ajax === 'profile_settings_save_date_of_birth') {
            var day = $('#day_of_birth').val().trim();
            var $month = $('#month_of_birth');
            var month = $month.val().trim();
            if ($month.attr('data-value') !== '') {
                month = $month.attr('data-value')
            }
            var year = $('#year_of_birth').val().trim();
            if (!day || !month || !year) return;

            var yr = new Date().getFullYear();
            var tmpYear = parseInt(year, 10);
            if (yr <= tmpYear || (yr > tmpYear && (yr - tmpYear) >= 100)) {
                return;
            }

            data = {
                action: 'profile_settings_save_date_of_birth',
                day: day,
                month: month,
                year: year,
            };
        } else if (ajax && ajax === 'profile_settings_save_gender') {
            var gender = $('#gender').attr('data-value').trim();
            if (!gender) {
                gender = $('#gender').val().trim();
            }
            if (!gender) return;

            data = {
                action: 'profile_settings_save_gender',
                gender: gender,
            };
        } else if (ajax && ajax === 'profile_settings_save_phone') {
            var phone = $('#llms_phone').val().trim();
            if (!phone || !/^\+38\(0\d{2}\) \d{3} \d{2} \d{2}$/.test(phone)) {
                $('#llms_phone').next('.error-tip').removeClass('hidden');
                return;
            } else {
                $('#llms_phone').next('.error-tip').addClass('hidden')
            }

            data = {
                action: 'profile_settings_save_phone',
                phone: phone,
            };
        }

        Object.keys(data).length && $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('message') && response['message'] && response.hasOwnProperty('modaltext') && response['modaltext']) {
                    if (ajax === 'profile_settings_save_date_of_birth') {
                        $('#date_of_birth').val(response['message']);
                    } else if (ajax === 'profile_settings_save_gender') {
                        $('#gender_input').val(response['message']);
                    } else if (ajax === 'profile_settings_save_phone') {
                        $('#phone_input').val(response['message']);
                    }
                    $('.active-modal').removeClass('active-modal');
                    productAddedMessage(response['modaltext']);
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    })

})