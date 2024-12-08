<?php
    $currentUrl = $_SERVER['REQUEST_URI'];
    $isUA = false;
    $lng_url = '';
    $language_code = '';
    $languages = icl_get_languages('skip_missing=0&orderby=code');
    if(!empty($languages)){
        foreach($languages as $l){
            if($l['active']){
                $lng_url = $l['url'];
                $language_code = $l['language_code'];
            }
        }
    }
    $isUA = $language_code == 'uk';
?>

</main>

<script>
    jQuery('.course__title a').click(function(e){
        e.preventDefault();
        history.back();

    });
</script>
<!-- Footer -->
<div class='footer-block'>
	<div class='container'>
		<div class='row'>
			<div class='col-md-12 col-lg-6'>
				<div class='footer-block-left'>
					<div class='row'>
						<div class='col-sm-12 col-md-6 col-lg-12'>
							<a class="footer__logo" href='/'>
								<img style="width: 225px;" src='<?php echo get_template_directory_uri() ?>/assets/img/footer/logo.svg' />
							</a>
						</div>
						<div class='col-sm-12 col-md-6 col-lg-12'>
							<div class='footer-block-left-actions' >

                                <?php

                                if (strpos($currentUrl, '/en/') !== false) { ?>
                                    <a href='/en/create-application/' class='btn btn_bg_primary'><?php _e('Create Application', 'ndp') ?></a>
                                    <a href='/en/dashboard' class='btn btn-outline-primary'><?php _e('Log In / Sign Up', 'ndp') ?></a>
                             <?php   } else { ?>
                                    <a href='/create-application/' class='btn btn_bg_primary'><?php _e('Create Application', 'ndp') ?></a>
                                    <a href='/dashboard' class='btn btn-outline-primary'><?php _e('Log In / Sign Up', 'ndp') ?></a>
                                <?php } ?>


							</div>
						</div>
					</div>
				</div>
			</div>
			<div class='col-md-12 col-lg-6'>
				<div class='row footer-block-rigth'>
					<div class='col-md-4'>
						<?php
								$menu_args = array(
										'menu' => 'Footer 1',
										'menu_class' => 'footer-block-rigth-menu-list',
										'container' => false,

								);
								wp_nav_menu($menu_args);
						?>
					</div>
					<div class='col-md-4'>
						<?php
								$menu_args = array(
										'menu' => 'Footer 2',
										'menu_class' => 'footer-block-rigth-menu-list',
										'container' => false,

								);
								wp_nav_menu($menu_args);
						?>
					</div>
					<div class='col-md-4'>
						<?php
								$menu_args = array(
										'menu' => 'Footer 3',
										'menu_class' => 'footer-block-rigth-menu-list',
										'container' => false,

								);
								wp_nav_menu($menu_args);
						?>
					</div>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class='col-md-12'>
				<div class='footer-block-bottom'>
					<a href='<?= $isUA ? "/privacy-policy" : '/en/privacy-policy'?>'><?php _e('Terms of Use', 'ndp') ?></a>
					<!-- <a href='/'>Умови використання</a> -->
					<div><?php _e('© Copyright Uprisun Tech', 'ndp') ?></div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

    $ = jQuery;
    $(function () {



        if($('.category-tags').length){
            $('.category-tags').each(function(){
                $(this).height()
                if($(this).height()>38){
                    console.log('detect');
                    let tag = $(this).find('.category-tags__tags-list').get(0);
                    console.log(tag);
                    let last =$(tag).find('li:first').get(0);
                    console.log(last);
                    let tooltip = $(tag).find('.tooltip').get(0);
                    $(tooltip).find('span').text(+$(tooltip).find('span').text()+1).prepend('+');
                    $(tooltip).find('.tooltiptext').append(last);

                }
            });
        }

    //     // Закриття вікна
    //     $('.under-development__button').click(function() {
    //         $('.under-development__modal').hide();
    //     });
    //
    //     $('.static-nav__button__comprasion').click(function(){
    //         let a = $(this).find('a');
    //         window.location.href=$(a).attr('href');
    //     });
    //     $('.header__rgt-column a:first,.create-aplication-action a,a[href="/create-application/"],a[href="en/create-application/"]').click(function(e){
    //         e.preventDefault();
    //         $('#under-development__govua').css('display', 'flex');
    //     });
    //     $('.user,a[href="/dashboard"]').click(function(e){
    //         e.preventDefault();
    //         $('#under-development__application').css('display', 'flex');
    //     })
    // })
        // Закриття вікна
    //     $('.under-development__button').click(function() {
    //         $('.under-development__modal').hide();
    //     });
    //
    //     $('.static-nav__button__comprasion').click(function(){
    //         let a = $(this).find('a');
    //         window.location.href=$(a).attr('href');
    //     });
    //     $('a[href="/create-application"],.header__rgt-column a:first,.create-aplication-action a,a[href="/create-application/"],a[href="en/create-application/"],a[href="/en/create-application/"]').click(function(e){
    //         e.preventDefault();
    //         $('#under-development__govua').css('display', 'flex');
    //     });
    //     $('.user,a[href="/dashboard"],a[href="/dashboard/"]').click(function(e){
    //         e.preventDefault();
    //         $('#under-development__application').css('display', 'flex');
    //     });
    //     $('.vendors__slider__item__text span:contains(+0)').parent().hide();
     })

</script>
<style>
    .under-development__modal {
        background: rgba(19, 19, 22, 0.60);
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999;
    }
    .under-development__modal-item {
        border-radius: 16px;
        background: #FFF;
        position: relative;
        width: 456px;
        overflow: hidden;
    }
    .under-development__top {
        background: #FBF8FD;
        padding: 24px 20px;
    }
    .under-development__title {
        color: #131316;
        font-size: 32px;
        font-style: normal;
        font-weight: 600;
        line-height: 40px;
        text-align: center;
    }
    .under-development__body {
        padding: 0px 20px;
        padding-bottom: 20px;
    }
    .under-development__img {
        text-align: center;
        margin-top: 32px;
        margin-bottom: 16px;
    }
    .under-development__text {
        color: #1B1B1F;
        text-align: center;
        font-size: 16px;
        font-style: normal;
        font-weight: 400;
        line-height: 24px;
        margin-bottom: 32px;
    }
    .under-development__button {
        display: flex;
        align-items: center;
        justify-content: center;
        column-gap: 8px;
        border: none;
        border-radius: 100px;
        background: #DCE2F9;
        color: #151B2C;
        text-align: center;
        font-size: 14px;
        font-style: normal;
        font-weight: 600;
        line-height: 20px;
        width: 100%;
        padding: 14px 20px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .under-development__button:hover {
        background: #cdd3e7;
        box-shadow: 0px 1px 3px 1px rgba(0, 0, 0, 0.06), 0px 1px 2px 0px rgba(0, 0, 0, 0.12);
        transition: all 0.3s ease;
    }
    #under-development__application .under-development__img {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        border-radius: 32px;
        background: #DAE2FF;
        padding: 12px;
        margin-left: auto;
        margin-right: auto;
    }
    @media ( max-width: 576px ) {
        .under-development__modal-item {
            width: 100%;
            border-radius: 12px;
            margin: 0px 16px;
        }
        .under-development__top {
            padding: 16px;
        }
        .under-development__title {
            font-size: 24px;
            line-height: 32px;
        }
        .under-development__text {
            font-size: 14px;
            line-height: 20px;
        }
        .under-development__body {
            padding: 0px 16px;
            padding-bottom: 16px;
        }
    }
</style>
<div class="under-development__modal" id="under-development__govua">
    <div class="under-development__modal-item">
        <div class="under-development__top">
            <h2 class="under-development__title">Розділ у розробці</h2>
        </div>
        <div class="under-development__body">
            <div class="under-development__img">
                <svg xmlns="http://www.w3.org/2000/svg" width="200" height="54" viewBox="0 0 200 54" fill="none">
                    <g clip-path="url(#clip0_6551_91844)">
                        <path d="M118.789 0H64.9301C50.0573 0 38.0005 12.0883 38.0005 27C38.0005 41.9117 50.0573 54 64.9301 54H118.789C133.662 54 145.719 41.9117 145.719 27C145.719 12.0883 133.662 0 118.789 0Z" fill="black"/>
                        <path d="M91.8598 39C89.4926 39 87.1786 38.2962 85.2104 36.9776C83.2421 35.6591 81.7081 33.7849 80.8022 31.5922C79.8963 29.3995 79.6593 26.9867 80.1211 24.6589C80.5829 22.3312 81.7228 20.193 83.3967 18.5147C85.0705 16.8365 87.2031 15.6936 89.5248 15.2306C91.8465 14.7676 94.2531 15.0052 96.44 15.9135C98.627 16.8217 100.496 18.3598 101.811 20.3332C103.127 22.3066 103.829 24.6266 103.829 27C103.825 30.1815 102.563 33.2317 100.319 35.4813C98.0752 37.731 95.033 38.9964 91.8598 39ZM91.8598 19.5C90.3803 19.5 88.9341 19.9399 87.7039 20.764C86.4738 21.5881 85.515 22.7594 84.9488 24.1299C84.3826 25.5003 84.2345 27.0083 84.5231 28.4632C84.8118 29.918 85.5242 31.2544 86.5704 32.3033C87.6165 33.3522 88.9494 34.0665 90.4005 34.3559C91.8515 34.6453 93.3556 34.4968 94.7225 33.9291C96.0893 33.3614 97.2576 32.4002 98.0796 31.1668C98.9015 29.9334 99.3403 28.4834 99.3403 27C99.3379 25.0116 98.549 23.1053 97.1467 21.6993C95.7443 20.2933 93.843 19.5024 91.8598 19.5Z" fill="white"/>
                        <path d="M163.522 39C160.349 38.9964 157.307 37.731 155.063 35.4813C152.819 33.2317 151.557 30.1815 151.554 27V17.25C151.554 16.6533 151.79 16.081 152.211 15.659C152.632 15.2371 153.203 15 153.798 15C154.393 15 154.964 15.2371 155.385 15.659C155.806 16.081 156.042 16.6533 156.042 17.25V27C156.042 28.9891 156.83 30.8968 158.233 32.3033C159.636 33.7098 161.538 34.5 163.522 34.5C165.506 34.5 167.409 33.7098 168.812 32.3033C170.215 30.8968 171.003 28.9891 171.003 27V17.25C171.003 16.6533 171.239 16.081 171.66 15.659C172.081 15.2371 172.652 15 173.247 15C173.842 15 174.413 15.2371 174.834 15.659C175.255 16.081 175.491 16.6533 175.491 17.25V27C175.488 30.1815 174.225 33.2317 171.982 35.4813C169.738 37.731 166.696 38.9964 163.522 39Z" fill="black"/>
                        <path d="M117.443 39.0003C117.02 39.0002 116.606 38.8803 116.248 38.6545C115.89 38.4287 115.603 38.106 115.42 37.7238L106.444 18.9738C106.218 18.4415 106.206 17.8425 106.409 17.3012C106.613 16.76 107.016 16.318 107.536 16.0671C108.055 15.8162 108.652 15.7756 109.2 15.9538C109.749 16.1319 110.209 16.5151 110.483 17.0238L117.443 31.5513L124.397 17.0268C124.515 16.7466 124.69 16.4935 124.909 16.2827C125.128 16.072 125.387 15.908 125.671 15.8007C125.955 15.6934 126.258 15.645 126.562 15.6585C126.865 15.6719 127.162 15.7469 127.436 15.879C127.709 16.0111 127.953 16.1974 128.153 16.4267C128.353 16.6561 128.504 16.9236 128.597 17.2132C128.691 17.5028 128.725 17.8085 128.697 18.1116C128.669 18.4147 128.581 18.7091 128.436 18.9768L119.46 37.7268C119.277 38.1076 118.99 38.429 118.634 38.6542C118.277 38.8794 117.864 38.9994 117.443 39.0003Z" fill="white"/>
                        <path d="M197.757 38.9997C197.334 39.0001 196.919 38.8805 196.561 38.6546C196.202 38.4288 195.915 38.1058 195.732 37.7232L188.779 23.1987L181.825 37.7232C181.551 38.2319 181.092 38.6151 180.543 38.7932C179.994 38.9713 179.398 38.9307 178.878 38.6798C178.358 38.4289 177.955 37.987 177.751 37.4457C177.548 36.9045 177.56 36.3055 177.786 35.7732L186.762 17.0232C186.946 16.6427 187.233 16.3219 187.59 16.0974C187.948 15.873 188.361 15.7539 188.782 15.7539C189.204 15.7539 189.617 15.873 189.974 16.0974C190.331 16.3219 190.618 16.6427 190.802 17.0232L199.778 35.7732C199.943 36.1161 200.019 36.4954 199.997 36.8755C199.976 37.2555 199.859 37.624 199.657 37.9464C199.455 38.2687 199.175 38.5345 198.843 38.7187C198.51 38.9029 198.137 38.9996 197.757 38.9997Z" fill="black"/>
                        <path d="M182.092 31.0572H195.159H182.092Z" fill="black"/>
                        <path d="M64.6309 39C62.6626 38.9999 60.7248 38.5132 58.989 37.5829C57.2532 36.6526 55.773 35.3075 54.6796 33.6666C53.5861 32.0258 52.9131 30.1399 52.7202 28.1761C52.5273 26.2122 52.8205 24.2309 53.5737 22.4077C54.3269 20.5846 55.517 18.9758 57.0384 17.7239C58.5599 16.472 60.3658 15.6156 62.2962 15.2306C64.2266 14.8456 66.2219 14.9438 68.1054 15.5167C69.9889 16.0895 71.7024 17.1191 73.0942 18.5145C73.3086 18.7221 73.4795 18.9703 73.5971 19.2448C73.7148 19.5194 73.7767 19.8146 73.7793 20.1133C73.7818 20.4121 73.7251 20.7084 73.6122 20.9849C73.4994 21.2614 73.3328 21.5126 73.1221 21.7239C72.9113 21.9351 72.6608 22.1022 72.385 22.2153C72.1092 22.3285 71.8137 22.3854 71.5157 22.3828C71.2177 22.3802 70.9233 22.3182 70.6495 22.2002C70.3757 22.0823 70.128 21.9109 69.921 21.696C68.7664 20.5383 67.2656 19.7912 65.6478 19.5688C64.03 19.3464 62.3841 19.6608 60.9612 20.4642C59.5383 21.2675 58.4167 22.5155 57.7676 24.0178C57.1184 25.5201 56.9774 27.1941 57.366 28.7842C57.7547 30.3744 58.6516 31.7934 59.9199 32.8246C61.1883 33.8558 62.7583 34.4426 64.3904 34.4954C66.0225 34.5482 67.627 34.0641 68.9589 33.1169C70.2909 32.1698 71.2772 30.8117 71.7672 29.25H64.6309C64.0357 29.25 63.4649 29.0129 63.044 28.591C62.6232 28.169 62.3867 27.5967 62.3867 27C62.3867 26.4033 62.6232 25.831 63.044 25.409C63.4649 24.9871 64.0357 24.75 64.6309 24.75H74.3554C74.9506 24.75 75.5214 24.9871 75.9423 25.409C76.3631 25.831 76.5996 26.4033 76.5996 27C76.596 30.1815 75.3339 33.2317 73.0901 35.4813C70.8463 37.731 67.8041 38.9964 64.6309 39Z" fill="white"/>
                        <path d="M21.0947 15H11.3701C10.7749 15 10.2041 15.2371 9.78327 15.659C9.36241 16.081 9.12598 16.6533 9.12598 17.25V36.75C9.12598 37.3467 9.36241 37.919 9.78327 38.341C10.2041 38.7629 10.7749 39 11.3701 39H21.0947C24.269 39 27.3133 37.7357 29.5578 35.4853C31.8024 33.2348 33.0634 30.1826 33.0634 27C33.0634 23.8174 31.8024 20.7652 29.5578 18.5147C27.3133 16.2643 24.269 15 21.0947 15ZM21.0947 34.5H13.6142V19.5H21.0947C23.0786 19.5 24.9813 20.2902 26.3841 21.6967C27.787 23.1032 28.5751 25.0109 28.5751 27C28.5751 28.9891 27.787 30.8968 26.3841 32.3033C24.9813 33.7098 23.0786 34.5 21.0947 34.5Z" fill="black"/>
                        <path d="M2.24413 15C1.64895 15 1.07815 15.2371 0.657291 15.659C0.236435 16.081 0 16.6533 0 17.25L0 36.75C0 37.3467 0.236435 37.919 0.657291 38.341C1.07815 38.7629 1.64895 39 2.24413 39C2.83931 39 3.41012 38.7629 3.83097 38.341C4.25183 37.919 4.48826 37.3467 4.48826 36.75V17.25C4.48826 16.6533 4.25183 16.081 3.83097 15.659C3.41012 15.2371 2.83931 15 2.24413 15Z" fill="black"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M195.159 33.0632H182.092V29.0527H195.159V33.0632Z" fill="black"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_6551_91844">
                            <rect width="200" height="54" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            </div>
            <p class="under-development__text">Ми вже працюємо над тим, щоб реєстрація через ID.GOV.UA запрацювала найближчим часом</p>
            <button class="under-development__button">
                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M15.5 8.25H6.3725L10.565 4.0575L9.5 3L3.5 9L9.5 15L10.5575 13.9425L6.3725 9.75H15.5V8.25Z" fill="#151B2C"/>
                </svg>
                Повернутися назад</button>
        </div>
    </div>
</div>
<div class="under-development__modal" id="under-development__application">
    <div class="under-development__modal-item">
        <div class="under-development__top">
            <h2 class="under-development__title">Розділ у розробці</h2>
        </div>
        <div class="under-development__body">
            <div class="under-development__img">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <mask id="mask0_6578_75382" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
                        <rect width="40" height="40" fill="#D9D9D9"/>
                    </mask>
                    <g mask="url(#mask0_6578_75382)">
                        <path d="M19.9999 36.6663C17.7129 36.6663 15.5555 36.2288 13.5277 35.3538C11.4999 34.4788 9.73141 33.2867 8.22213 31.7775C6.71288 30.2682 5.52075 28.4997 4.64575 26.4719C3.77075 24.4441 3.33325 22.2867 3.33325 19.9997C3.33325 17.6941 3.77075 15.5275 4.64575 13.4997C5.52075 11.4719 6.71288 9.70801 8.22213 8.20801C9.73141 6.70801 11.4999 5.52051 13.5277 4.64551C15.5555 3.77051 17.7129 3.33301 19.9999 3.33301C22.3055 3.33301 24.4721 3.77051 26.4999 4.64551C28.5277 5.52051 30.2916 6.70801 31.7916 8.20801C33.2916 9.70801 34.4791 11.4719 35.3541 13.4997C36.2291 15.5275 36.6666 17.6941 36.6666 19.9997C36.6666 20.7867 36.6157 21.5691 36.5138 22.3469C36.412 23.1247 36.2546 23.8793 36.0416 24.6108C35.7083 24.2589 35.3309 23.958 34.9096 23.708C34.4884 23.458 34.0277 23.2775 33.5277 23.1663C33.6481 22.6571 33.7384 22.1409 33.7985 21.6178C33.8587 21.0946 33.8888 20.5552 33.8888 19.9997C33.8888 16.1293 32.5416 12.8469 29.8472 10.1524C27.1527 7.45798 23.8703 6.11076 19.9999 6.11076C16.1481 6.11076 12.8703 7.45798 10.1666 10.1524C7.46286 12.8469 6.111 16.1293 6.111 19.9997C6.111 23.8515 7.46286 27.1293 10.1666 29.833C12.8703 32.5367 16.1481 33.8886 19.9999 33.8886C21.5462 33.8886 23.0161 33.6478 24.4097 33.1663C25.8032 32.6849 27.0786 32.0228 28.236 31.1802C28.5324 31.5599 28.8726 31.9025 29.2569 32.208C29.6411 32.5136 30.0555 32.7543 30.4999 32.9302C29.0647 34.1062 27.4559 35.0228 25.6735 35.6802C23.8911 36.3376 21.9999 36.6663 19.9999 36.6663ZM32.361 29.9719C31.8518 29.9719 31.4236 29.7983 31.0763 29.4511C30.7291 29.1038 30.5555 28.6756 30.5555 28.1663C30.5555 27.6571 30.7291 27.2289 31.0763 26.8816C31.4236 26.5344 31.8518 26.3608 32.361 26.3608C32.8703 26.3608 33.2985 26.5344 33.6458 26.8816C33.993 27.2289 34.1666 27.6571 34.1666 28.1663C34.1666 28.6756 33.993 29.1038 33.6458 29.4511C33.2985 29.7983 32.8703 29.9719 32.361 29.9719ZM25.9166 27.9719L18.6944 20.5552V11.3052H21.4721V19.4441L27.9444 25.9441L25.9166 27.9719Z" fill="#2A59BD"/>
                    </g>
                </svg>
            </div>
            <p class="under-development__text">Ми вже працюємо над тим, щоб створення заявки запрацювало найближчим часом</p>
            <button class="under-development__button">
                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M15.5 8.25H6.3725L10.565 4.0575L9.5 3L3.5 9L9.5 15L10.5575 13.9425L6.3725 9.75H15.5V8.25Z" fill="#151B2C"/>
                </svg>
                Повернутися назад</button>
        </div>
    </div>
</div>
<?php wp_footer(); ?>

</body>

</html>
