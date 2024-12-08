$(function() {

    // FIXED BLACK ALERT

    $(".fixed-alert__close").click(function(){
        let $parent = $(this).parent();
        $parent.addClass('hidden');
        $parent.find('.fixed-alert__text').empty()
    })

    // MODALS

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


    if($('.c-modal-large').length) {
        $(".c-modal-large").iziModal({
            width: 744,
            closeButton: false,
            focusInput: false,
            padding: 16,
            overlayColor: 'rgba(19, 19, 22, 0.60)',
            transitionIn: 'fadeInUp',
            transitionOut:	'fadeOutDown',
        });
    }

    $(document).on('click', '.btn-izimodal', function (event) {
        let $target = $(event.target);
        $target.addClass('opened')
    });

    $(document).on('closing', '.c-modal-medium', function (e) {
        $('.btn-izimodal.opened').removeClass('opened')
    });
    

    $(".js-request").click(function(){
        $('.account__nav').toggleClass('open');
        $('body').toggleClass('faded');
        $(this).toggleClass('open')
        $(this).find('span').text(function(_, text) {
            return text === 'Action' ? 'Close' : 'Action';
        });
    })

    $(".account__nav-buttons .btn").click(function(){
        $('.account__nav').removeClass('open');
        $('body').removeClass('faded');
        $('.c-fix-menu ').removeClass('open')
        $('.c-fix-menu span').text('Action');
    })

    // TABS JQUERY 

    $(".acc-tabs__content").addClass('shows')

    $(".acc-tabs__content-item").not(":first").hide();
    $(".acc-tabs__nav-btn").click(function() {
        $(".acc-tabs__nav-btn").removeClass("active").eq($(this).index()).addClass("active");
        $(".acc-tabs__content-item").hide().eq($(this).index()).fadeIn()
    }).eq(0).addClass("active");


    // INPUT TEXT MATERIAL INIT

    const foos = [].map.call(document.querySelectorAll('.mdc-text-field'), function (el) {
        return new mdc.textField.MDCTextField(el);
    });

    // SELECT MATERIAL INIT

    if($('.mdc-select').length) {
        $('.mdc-select').each(function(i,el) {
            const select = new mdc.select.MDCSelect(el);
        })
    }

    // MENU MATERIAL INIT

    // const buttons = document.querySelectorAll('.mdc-button');

    // buttons.forEach(button => {
    //     const menu = button.parentNode.querySelector('.mdc-menu');
    //     const mdcMenu = new mdc.menu.MDCMenu(menu);
    //     console.log('mdcMenu', mdcMenu);
    //
    //     button.addEventListener('click', function() {
    //         mdcMenu.open = !mdcMenu.open;
    //     });
    // });

    $(document).on('click', '.mdc-button', function (event) {
        let $target = $(event.target).closest('button');
        let $menu = $target.parent().find('.mdc-menu');
        const mdcMenu = new mdc.menu.MDCMenu($menu[0]);
        mdcMenu.open = !mdcMenu.open;
    })

    // RADIO INIT

    const radios = document.querySelectorAll('.c-course__radio input[type="radio"]');

    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            radios.forEach(r => {
            const radioParent = r.closest('.c-course__radio');
            if (r.checked) {
                radioParent.classList.add('active');
            } else {
                radioParent.classList.remove('active');
            }
            });
        });
    });

    // CHECKBOX INIT

    const checkboxes = document.querySelectorAll('.c-course__checkbox input[type="checkbox"]');

    checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        checkboxes.forEach(chk => {
        const checkboxParent = chk.closest('.c-course__checkbox');
        if (chk.checked) {
            checkboxParent.classList.add('active');
        } else {
            checkboxParent.classList.remove('active');
        }
        });
    });
    });



    // ACCORDION 

    if ($('.js-accordion').length) {
        $('.js-accordion').each(function(){
            $(this).find('> li:eq(0) a').addClass('active').next().slideDown();
        })
        $('.js-accordion > li > a').unbind('click').click(function(e) {
            var dropDown = $(this).closest('li').find('.js-accordion-hide');
    
            $(this).closest('.js-accordion').find('.js-accordion-hide').not(dropDown).slideUp();
    
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
            } else {
                $(this).closest('.js-accordion').find('a.active').removeClass('active');
                $(this).addClass('active');
            }
    
            dropDown.stop(false, true).slideToggle();
    
            e.preventDefault()
        });
    }

    $(document).on('click', '.account__content .pagination a', function (event) {
        event.preventDefault();

        let $target = $(event.target).closest('a');
        let page = $target.attr('href').match(/page=([0-9]+)/);
        page = page.length === 2? +page[1] : 1;
        if (typeof page === 'number') {
            let data = {
                action: 'municipality_requests_ajax',
                page: page || 1,
                status: $target.closest('.acc-tabs__content-item').attr('data-status') || '',
                pathname: window.location.pathname,
            };

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                success: function(response) {
                    // console.log(response);
                    if (response && response.hasOwnProperty('requests') && typeof response['requests']['requests'] != 'undefined') {
                        let html = response['requests']['requests'];
                        if (html) {
                            let $parent = $target.closest('.acc-tabs__content-item');
                            $parent.find('.tr-request-data').not(':first').remove();
                            $parent.find('.tr-request-data').replaceWith(html);

                            if (typeof response['requests']['pagination'] != 'undefined') {
                                $parent.find('.pagination').replaceWith(response['requests']['pagination']);
                            }
                        }
                    }
                },
                error: function (jqXHR, exception) {
                    // console.log('error');
                    // console.log(jqXHR);
                    // console.log(exception);
                },
            });
        }
    });

    let requestIsExists = false;
    $('.field__input--approve-organization').on('input', function(event) {
        let input = $(this).val().trim().length;
        if (input > 3 && requestIsExists) {
            $('.btn-approve').removeClass('disabled')
        }
    });

    //Проверяет существует ли запрос к оператору от муниципалитета
    $('.nav-buttons--approve').on('click', function(event) {
        let data = {
            action: 'checkIfOperatorRequestExists',
            request_id: $('.account__content').attr('data-id'),
        };

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                if (response && response.hasOwnProperty('success')) {
                    if (response['success'] === 'ok') {
                        requestIsExists = true;
                        if ($('.field__input--approve-organization').val().trim().length > 3) {
                            $('.btn-approve').removeClass('disabled')
                        }
                    } else {
                        if (response.hasOwnProperty('message')) {
                            $('#modalInvite').find('.h2').text(response['message']);
                            setTimeout(function() {
                                $('#modalInvite').iziModal('close');
                                if (requestsEndpoint) {
                                    document.location.href = requestsEndpoint;
                                }
                            }, 2000)
                        }
                    }
                } else {
                    alert('Error');
                    $('#modalInvite').iziModal('close');
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    })

    //Одобрение запроса муниципалитета оператором
    $('.btn-approve').on('click', function(event) {
        event.preventDefault();

        if (!requestIsExists) {
            console.log('request not exists');
        }

        let data = {
            action: 'approveMunicipalityRequest',
            request_id: $('.account__content').attr('data-id'),
            status: 'Approved',
            text: $('.field__input--approve-organization').val() || '',
            eventType: 'approve request',
        };
        console.log('data', data);

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                console.log(response);
                if (response && response.hasOwnProperty('message') && response['message'] && response.hasOwnProperty('status')) {
                    $('.nav-buttons--reject').remove();
                    $('.nav-buttons--approve').addClass('disabled').text(response['status']);
                    $('.fixed-alert').removeClass('hidden')
                        .find('.fixed-alert__text').text(response['message'])
                }
                $('#modalInvite').iziModal('close');
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });

    //Отклонение запроса муниципалитета оператором
    $('.btn-reject').on('click', function(event) {
        event.preventDefault();

        let rejectText = $('.reject-text').val();
        if (!rejectText) return;

        let data = {
            action: 'approveMunicipalityRequest',
            request_id: $('.account__content').attr('data-id'),
            status: 'Rejected',
            text: rejectText,
            eventType: 'reject request',
        };
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('message') && response['message'] && response.hasOwnProperty('status') ) {
                    $('.nav-buttons--approve').remove();
                    $('.nav-buttons--reject').addClass('disabled').text(response['status']);
                    $('#modalReject').iziModal('close');
                    $('.fixed-alert').removeClass('hidden')
                        .find('.fixed-alert__text').text(response['message'])
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });

    $('.js-job-title-add').length && $('.js-job-title-add').click();

    let $tin = $('.field-input-tin, .field__input--invite-tin:not(.old-tin)');
    $(document).on('input blur', '.field-input-tin, .field__input--invite-tin:not(.old-tin)', function (event) {
        let tin = $(this).val().trim();
        let lngth = 8;
        if ($(this).is('.field__input--invite-tin')) {
            lngth = 10;
        }
        let error = false;
        if (/[^0-9]+/.test(tin)) {
            $tin.closest('label').addClass('mdc-text-field--invalid');
            tin = tin.replace(/[^0-9]+/, '');
            $(this).val(tin);
            error = true;
        } else if (tin.length > lngth) {
            $tin.closest('label').addClass('mdc-text-field--invalid');
            tin = tin.slice(0, -1);
            $(this).val(tin);
            error = true;
        } else if (tin && tin.length === lngth) {
            $tin.closest('label').removeClass('mdc-text-field--invalid');
        }
        let $error = $(this).closest('.c-modal__row')?.find('.error:not(.error-tin-old)');
        if ($error && $error.length) {
            if (error) {
                $error.show()
            } else {
                $error.hide()
            }
        }
    });

    //dashboard/municipalities/ запрос к оператору на регистрацию view-add-municipality.php
    $('.btn-manual-request').on('click', function(event) {
        event.preventDefault();

        let tin = $('.field-input-tin').val().trim();
        if (!tin || !/[0-9]+/.test(tin) || tin.length !== 8) {
            $tin.closest('label').addClass('mdc-text-field--invalid')
            return;
        }
        let data = {
            action: 'addMunicipalityToRequestTable',
            tin: tin,
        };

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('message') && response['message'] === 'ok') {
                    $('.acc-form__row--in-progress').removeClass('hidden');
                    $('.fixed-alert--sent').removeClass('hidden');
                    $('.acc-form__row--gov').remove();
                    $('.acc-form__row--operator').remove();
                    $('.mdc-text-field-tin').addClass('mdc-text-field--disabled mdc-select--disabled');
                    $('.mdc-select-job').addClass('mdc-text-field--disabled mdc-select--disabled');
                    $('.field-input-tin').prop('disabled', true);
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });


    //Если отклонили запрос, отправка сообщения оператору
    $('.btn-send-message').on('click', function(event) {
        event.preventDefault();

        let message = $('.textarea-message').val();
        if (!message) return;

        let data = {
            action: 'municipality_send_message_to_operator',
            message: message,
            eventType: 'message to operator',
        };

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('message') && response['message']) {
                    $('#modalSend').iziModal('close');
                    let $alert = $('.fixed-alert');
                    $alert.removeClass('hidden');
                    $alert.find('.fixed-alert__text').text(response['message'])
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });

    $(document).on('input blur', '.field__input--invite-tin.old-tin', function (event) {
        let $tin = $(this);
        let tin = $tin.val().trim();
        let error = false;
        let lngth = 9;
        let old = false;//МР 123456
        if (tin && $tin.is('.old-tin')) {
            if (/^[А-Яа-яёЁЇїІіЄєҐґA-Za-z]/.test(tin)) {
                old = true;
            }
        }
        if (!old && /[^0-9]+/.test(tin)) {
            tin = tin.replace(/[^0-9]+/, '');
            $(this).val(tin);
            error = true;
        } else if (old && ((tin.length < 3 && /[^А-Яа-яёЁЇїІіЄєҐґA-Za-z]/.test(tin)) || (tin.length === 3 && /[^\s]+/.test(tin.slice(2,3))))) {
            tin = tin.slice(0, -1);
            $(this).val(tin);
            error = true;
        } else if (old && tin.length > 3 && tin.length <= 9 && /[^0-9]+/.test(tin.slice(3))) {
            tin = tin.slice(0, -1);
            $(this).val(tin);
            error = true;
        } else if (tin.length > lngth) {
            tin = tin.slice(0, -1);
            $(this).val(tin);
            error = true;
        } else if (tin && tin.length === lngth) {
            $tin.closest('label').removeClass('mdc-text-field--invalid');
        }
        let $error = $(this).closest('.c-modal__row')?.find('.error-tin-old');
        if ($error && $error.length) {
            if (error) {
                $tin.closest('label').addClass('mdc-text-field--invalid');
                $error.show()
            } else {
                $tin.closest('label').removeClass('mdc-text-field--invalid');
                $error.hide()
            }
        }
    });

    $('.field__input--invite-name').on('input blur', function(event) {
        let name = $(this).val().trim();
        let error = false;
        if (/[0-9!@_\.,\[\]\(\)]+/.test(name)) {
            $(this).closest('label').addClass('mdc-text-field--invalid');
            name = name.replace(/[0-9]/, '');
            $(this).val(name);
            error = true;
        } else {
            $(this).closest('label').removeClass('mdc-text-field--invalid');
        }
        let $error = $(this).closest('.c-modal__row')?.find('.error');
        if ($error && $error.length) {
            if (error) {
                $error.show()
            } else {
                $error.hide()
            }
        }
    });

    //Отправка приглашения в муниципалитет, проверка полей
    function checkInvitedFields(event=null,emailChecked=false) {
        let $target = event? $(event.target) : null;
        let $tin = $('.field__input--invite-tin');
        let tin = $tin.val().trim();
        let name = $('.field__input--invite-name').val().trim();
        let job = $('.job-text').attr('data-position') || '';
        let phone = $('.field__input--invite-phone').val().trim();
        let email = $('.field__input--invite-email').val().trim();
        $('.error').removeClass('show');
        let error = false;
        if (tin) {
            if (!$tin.is('.old-tin') && tin.length !== 10) {
                error = true;
            } else if ($tin.is('.old-tin') && (tin.length !== 9 || (/^[А-Яа-яёЁЇїІіЄєҐґA-Za-z]/.test(tin[0]) && !/^[А-Яа-яёЁЇїІіЄєҐґA-Za-z]{2}\s?[0-9]{6}$/.test(tin)))) {
                error = true;
            }
        }
        if (!error && tin && name && job && phone && email && /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.(?!ru)[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(email)) {
            $('.btn-send-invite').removeClass('disabled');
            $('.mdc-text-field--outlined, .mdc-select--outlined').removeClass('mdc-text-field--invalid');
            error = false;
        } else {
            $('.btn-send-invite').addClass('disabled');
            error = true;
        }
        // if ($target && error) {
        //
        // }
    }

    $('.field__input--invite,.job-text').on('input blur DOMSubtreeModified', checkInvitedFields);

    //job position
    $('.item-text-position').on('click', function(event) {
        let position = $(this).find('.mdc-deprecated-list-item__text').attr('data-position');
        $('.job-text').attr('data-position', position)
    })

    $(".phone-input").length && $(".phone-input").mask("(999) 999-99-99",{
        completed:function(){
            checkInvitedFields({target: this})
        }
    });


    $('.field__input--invite-email').on('input blur', function(event) {
        let $target = $(event.target);
        let $field = $target.closest('.mdc-text-field--outlined');
        let email = $target.val().trim();
        let validEmail = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.(?!ru)[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(email);
        if (!validEmail) {
            setTimeout(function() {
                $field.addClass('mdc-text-field--invalid');
                $field.find('.material-icons.error-icon').show()
            }, 100);
            if (event.type === 'blur') {
                $('#email-error-message').addClass('show')
            }
        } else {
            $field.removeClass('mdc-text-field--invalid');
            if (event.type === 'blur') {
                $('#email-error-message').removeClass('show')
            }
        }
    });

    $('#not_have_tin').on('change', function(event) {
        let title = '';
        let $labelTin = $('.mdc-floating-label-tin');
        title = $labelTin.attr('data-title')
        let currentTitle = $labelTin.text();
        $labelTin.text(title);
        $labelTin.attr('data-title', currentTitle);
        const foos = [].map.call(document.querySelectorAll('.mdc-text-field'), function (el) {
            return new mdc.textField.MDCTextField(el);
        });
        $('.field__input--invite-tin').val('');
        $('.field__input--invite-tin').toggleClass('old-tin');
    })

    $('.btn-send-invite').on('click', function(event) {
        event.preventDefault();

        let $email = $('.field__input--invite-email');
        let email = $email.val().trim();
        let $tin = $('.field__input--invite-tin');
        let tin = $tin.val().trim();
        let name = $('.field__input--invite-name').val().trim();
        let job = $('.job-text').attr('data-position') || '';
        let phone = $('.field__input--invite-phone').val().trim();

        checkInvitedFields();
        if (!email || !tin || !name || !job || !phone || !/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.(?!ru)[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/.test(email)) {
            $('.mdc-text-field--outlined, .mdc-select--outlined').each(function(i,field) {
                let $field = $(field);
                let $fieldInput = $field.find('.field__input--invite');
                if (($field.is('.mdc-text-field--outlined') && $fieldInput.val() === '') || ($field.is('.mdc-select--outlined') && $fieldInput.text() === '')) {
                    $field.addClass('mdc-text-field--invalid');
                }
            });
            return;
        }

        if (!$tin.is('.old-tin') && tin.length !== 10) {
            return;
        } else if ($tin.is('.old-tin') && (tin.length !== 9 || !/^[А-Яа-яёЁЇїІіЄєҐґA-Za-z]{2}\s?[0-9]{6}$/.test(tin))) {
            return;
        }

        let data = {
            action: 'send_invite_to_municipality',
            email: email,
            tin: tin,
            name: name,
            job: job,
            phone: phone,
        };

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                let $error = $email.closest('.c-modal__row').find('.error');
                $error.removeClass('show');
                let $alert = $('.fixed-alert');
                if (response && response.hasOwnProperty('message') && response['message'] && response.hasOwnProperty('status') && response['status'] === 'invited' && response.hasOwnProperty('tr')) {
                    $alert.removeClass('hidden');
                    $alert.find('.fixed-alert__text').text(response['message'])
                    $('#modalInvite').iziModal('close');
                    let $boxInvited = $('.acc-box-invited');
                    if ($boxInvited.hasClass('acc-box--empty')) {
                        $boxInvited.removeClass('acc-box--empty');
                        $boxInvited.find('.acc-table-scroll-y.hidden')?.removeClass('hidden');
                        $('span.no-registered').length && $('span.no-registered').remove()
                    }
                    $('.acc-table--registr').find('tr:first').after(response['tr']);
                    $('.c-modal__form input').val('');

                } else if (response && response.hasOwnProperty('message') && response['message'] && response.hasOwnProperty('status') && response['status'] !== 'invited') {
                    $error.addClass('show').text(response['message']);
                } else {
                    alert('Error')
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });


    $('.btn-change-job').on('click', function(event) {
        event.preventDefault();

        let $button = $('.btn-izimodal.opened');
        let invited = $button.is('.invited');
        let $tr = $button.closest('tr');

        let job = $('.change-job-text').text().trim();
        if (!job || !$tr.length) return;

        let municipality_id = +$('.account__content').attr('data-municipality_id');
        let user_email = $tr.find('.td-user_email').text().trim();
        if (!municipality_id || !user_email) return;
        let data = {
            action: 'change_job',
            job: job,
            municipality_id: municipality_id,
            user_email: user_email,
            invited: invited,
        };

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('message') && response['message'] === 'ok') {
                    $('#modalJob').iziModal('close');
                    $button.removeClass('opened');
                    $tr.find('.td-position').text(job)
                } else {
                    $('#modalJob').iziModal('close');
                    $button.removeClass('opened');
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });

    $('.btn-send-admin-message').on('click', function(event) {
        event.preventDefault();

        let message = $('.textarea-admin').val();
        if (!message) return;

        let data = {
            action: 'send_message_to_admin',
            message: message,
            eventType: 'message to admin',
        };

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('message') && response['message']) {
                    $('#modalSend').iziModal('close');
                    let $alert = $('.fixed-alert');
                    $alert.removeClass('hidden');
                    $alert.find('.fixed-alert__text').text(response['message'])
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });


    $('.btn-revoke-invite').on('click', function(event) {
        event.preventDefault();

        let $button = $('.btn-izimodal.opened');
        let invited = $button.is('.invited');
        let $tr = $button.closest('tr');

        if (!$tr.length) return;

        let municipality_id = +$('.account__content').attr('data-municipality_id');
        let user_email = $tr.find('.td-user_email').text().trim();
        if (!municipality_id || !user_email) return;
        let data = {
            action: 'remove_invite_by_municipality',
            municipality_id: municipality_id,
            user_email: user_email,
            invited: invited,
        };

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('message') && response['message'] === 'ok') {
                    $('#modalRevoke').iziModal('close');
                    $button.removeClass('opened');
                    $tr.remove();
                    let $alert = $('.fixed-alert');
                    $alert.addClass('hidden');
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });

    $('.btn-remove-user').on('click', function(event) {
        event.preventDefault();

        let $button = $('.btn-izimodal.opened');
        let $tr = $button.closest('tr');

        if (!$tr.length) return;

        let municipality_id = +$('.account__content').attr('data-municipality_id');
        let user_email = $tr.find('.td-user_email').text().trim();
        let invited_email = $tr.attr('data-invited-email').trim() || '';//если email отличается от изначального
        if (!municipality_id || !user_email) return;
        let data = {
            action: 'remove_representative_by_municipality',
            municipality_id: municipality_id,
            user_email: user_email,
            invited_email: invited_email,
        };
        // console.log('data', data);

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('message') && response['message'] === 'ok') {
                    $('#modalRemove').iziModal('close');
                    $button.removeClass('opened');
                    $tr.remove();
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });


    $('.btn-launch-survey').on('click', function(event) {
        event.preventDefault();

        let $button = $('.btn-izimodal.opened');
        let $tr = $button.closest('tr');
        if (!$tr.length) return;
        let survey_id = $tr.attr('data-id');
        if (!survey_id) return;

        let data = {
            action: 'launchSurveyByOperator',
            survey_id: survey_id,
        };
        console.log('data', data);

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('message') && response.hasOwnProperty('date')) {
                    $('#modalLaunch').iziModal('close');
                    $button.removeClass('opened');
                    $button.closest('tr').find('.start-date').text(response['date']);
                    let $alert = $('.fixed-alert');
                    $alert.removeClass('hidden');
                    $alert.find('.fixed-alert__text').text(response['message'])
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });

    $('.btn-finish-survey').on('click', function(event) {
        event.preventDefault();

        let $button = $('.btn-izimodal.opened');
        let $tr = $button.closest('tr');
        if (!$tr.length) return;
        let survey_id = $tr.attr('data-id');
        if (!survey_id) return;

        let data = {
            action: 'finishSurveyByOperator',
            survey_id: survey_id,
        };
        console.log('data', data);

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('message') && response.hasOwnProperty('date')) {
                    $('#modalFinish').iziModal('close');
                    $button.removeClass('opened');
                    $button.closest('tr').find('.finish-date').text(response['date']);
                    let $alert = $('.fixed-alert');
                    $alert.removeClass('hidden');
                    $alert.find('.fixed-alert__text').text(response['message'])
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });

    $('.btn-collect-data').on('click', function(event) {
        event.preventDefault();

        let $button = $(event.target);
        let $tr = $button.closest('tr');
        if (!$tr.length) return;
        let survey_id = $tr.attr('data-id');
        if (!survey_id) return;

        let data = {
            action: 'getSurveyResults',
            survey_id: survey_id,
        };
        console.log('data', data);

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(data, textStatus, request) {
                console.log(data, textStatus, request);
                if (data) {
                    var downloadLink = document.createElement("a");
                    var fileData = ['\ufeff'+data];

                    var blobObject = new Blob(fileData,{
                        type: "text/csv;charset=utf-8;"
                    });

                    var url = URL.createObjectURL(blobObject);
                    downloadLink.href = url;
                    var now = new Date();
                    downloadLink.download = 'survey_data_'+survey_id+'_'+now.getHours()+now.getMinutes()+'_'+now.getDate()+(now.getMonth()+1)+now.getFullYear()+'.csv';

                    /*
                     * Actually download CSV
                     */
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });

});