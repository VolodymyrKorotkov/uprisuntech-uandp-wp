<?php
/*
Template Name: Register step 1
*/
wp_enqueue_style('lifterlms-authorization', get_template_directory_uri() . '/assets/css/registration-govua.css');
wp_enqueue_script('vh_ndp-authorization', get_template_directory_uri() . '/assets/js/registration-govua.js', array(), _S_VERSION, true);
wp_enqueue_style('lifterlms-material', get_template_directory_uri() . '/assets/css/material-components-web.min.css');
wp_enqueue_script('lifterlms-material', get_template_directory_uri() . '/assets/js/material-components-web.min.js', array('jquery'), _S_VERSION, true);
get_header();


?>
<?php if(!empty($_SESSION['invite'])){ ?>
    <script>
        $('#personalAccount').click();
        var accountType = "Personal";
        var $tin = $('#TIN-organization');
        var tin = $tin.val() || '';

        // Создание объекта данных
        var formData = {
            'account-type': accountType,
            'tin': tin
        };

        // Отправка данных на сервер
        $.ajax({
            url: '/wp-json/register/v1/step1/',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            headers: {
                'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'  // Add the nonce here
            },
            success: function (data) {
                console.log('Success:', data);
                // Редирект на следующий шаг регистрации
                if (data.data && data.data.redirect) {
                    window.location.href = data.data.redirect;
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    </script>

<?php } ?>
<section class="registration">
    <div class="container">
        <div class="registration__block" id="registration__type">
            <div class="registration__header">
                <h1 class="registration__title"><?php _e('UANDP Account', 'ndp'); ?></h1>
            </div>
            <form <?php if(!empty($_SESSION['invite'])){ ?>disabled="disabled" <?php } ?> action="#" class="registration__form">
                <h2 class="registration__form-title"><?php _e('Select account type', 'ndp'); ?></h2>
                <div class="registration__form-wrapper">
                    <input type="radio" id="personalAccount" value="Personal" name="account-type">
                    <label for="personalAccount"><?php _e('Personal account', 'ndp'); ?></label>
                </div>
                <div class="registration__form-wrapper">
                    <input type="radio" id="representativeAccount" value="Representative" name="account-type">
                    <label for="representativeAccount"><?php _e('Representative account', 'ndp'); ?></label>
                </div>
                <div class="mdc-select mdc-select--outlined">
                    <div class="mdc-select__anchor" role="button" aria-haspopup="listbox" aria-expanded="false"
                         tabindex="0">
              <span class="mdc-notched-outline">
                <span class="mdc-notched-outline__leading"></span>
                <span class="mdc-notched-outline__notch">
                  <span class="mdc-floating-label"><?php _e('Type of representative', 'ndp'); ?></span>
                </span>
                <span class="mdc-notched-outline__trailing"></span>
              </span>
                        <div class="mdc-select__selected-text"></div>
                        <div class="registration__selected"></div>
                        <span class="mdc-select__dropdown-icon">
                <svg
                        class="mdc-select__dropdown-icon-graphic"
                        viewBox="7 10 10 5"
                        focusable="false"
                >
                  <polygon
                          class="mdc-select__dropdown-icon-inactive"
                          stroke="none"
                          fill-rule="evenodd"
                          points="7 10 12 15 17 10"
                  />
                  <polygon
                          class="mdc-select__dropdown-icon-active"
                          stroke="none"
                          fill-rule="evenodd"
                          points="7 15 12 10 17 15"
                  />
                </svg>
              </span>
                    </div>
                    <div class="mdc-select__menu mdc-menu mdc-menu-surface">
                        <ul class="mdc-list">
                            <li class="mdc-list-item" data-value="option1"><?php _e('Head of municipality', 'ndp'); ?></li>
                        </ul>
                    </div>
                </div>
                <!-- ПОЛЕ З'ЯВЛЯЄТЬСЯ ЯКЩО ПОПЕРЕДНІЙ ЕЛЕМЕНТ НЕ ПУСТИЙ -->
                <div class="mdc-text-field mdc-text-field--outlined" id="hidden__field">
                    <input type="text" class="mdc-text-field__input" name="tin" id="TIN-organization">
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="TIN-organization" class="mdc-floating-label"><?php _e('edrpou', 'ndp'); ?></label>
                        </div>
                        <div class="mdc-notched-outline__trailing"></div>
                    </div>
                </div>




                <button type="button" class="registration__button disabled__button"><?php _e('Go to account','ndp'); ?></button>



            </form>
        </div>
    </div>
</section>
<style>


    input#TIN-organization {
        margin-top: 0px !important;
    }
     .active_select .mdc-select__menu.mdc-menu.mdc-menu-surface {
        display: inline-flex;
        opacity: 1;
        width: 100%;
    }

   .selected span.mdc-floating-label {
        top: 0px !important;
        background: white;
    }
</style>

<script>
    $(document).on('click','.mdc-select.mdc-select--outlined[style="display: inline-flex;"]',function (){
        if($(this).hasClass('active_select')){
            $(this).addClass('selected');
            $(this).removeClass('active_select');
            return;
        }
        $(this).toggleClass('active_select');
    });



    $(document).ready(function () {
        $('.registration__form').submit(function (e) {
            e.preventDefault();

            // Сбор данных из формы
            var accountType = $('input[name="account-type"]:checked').val();
            var $tin = $('#TIN-organization');
            var tin = $tin.val() || '';
            if (!/[0-9]+$/.test(tin) || tin.length !== 8) {
                if(accountType =='Representative'){
                    $tin.parent().addClass('mdc-text-field--invalid');
                    return;
                }

            } else {
                $tin.parent().removeClass('mdc-text-field--invalid');
            }

            // Создание объекта данных
            var formData = {
                'account-type': accountType,
                'tin': tin
            };

            // Отправка данных на сервер
            $.ajax({
                url: '/wp-json/register/v1/step1/',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                headers: {
                    'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'  // Add the nonce here
                },
                success: function (data) {
                    console.log('Success:', data);
                    // Редирект на следующий шаг регистрации
                    if (data.data && data.data.redirect) {
                        window.location.href = data.data.redirect;
                    }
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        });
    });
</script>
<?php get_footer(); ?>
