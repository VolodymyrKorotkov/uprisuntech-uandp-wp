<?php
/*
Template Name: Contacts
*/

get_header();
?>

<div class='contacts-page'>
  <div class='container'>

    <div class='row'>
      <div class='col-md-4'>
        <div class='contacts-page-left'>
            <div class='ct_breadcrumbs'>
                <?php yoast_breadcrumb(); ?>
            </div>

          <h1 class='contacts-page-title'>Contacts</h1>
          <div class='contacts-page-item'>
            <div class='contacts-page-item-icon'>
              <img src='<?php echo get_field('contact_location_icon'); ?>' />
            </div>
            <div class='contacts-page-item-content'>
              <div class='contacts-page-item-content-text1'><?php echo get_field('contact_location_title'); ?></div>
              <div class='contacts-page-item-content-text2'><?php echo get_field('contact_location_description'); ?></div>
              <div class='contacts-page-item-content-text3'><span class="js-contact-map"><?php echo get_field('contact_location_address'); ?></span></div>
            </div>
          </div>
          <div class='contacts-page-item'>
            <div class='contacts-page-item-icon'>
              <img src='<?php echo get_field('contact_phone_icon'); ?>' />
            </div>
            <div class='contacts-page-item-content'>
              <div class='contacts-page-item-content-text1'><?php echo get_field('contact_phone_title'); ?></div>
              <div class='contacts-page-item-content-text2'><?php echo get_field('contact_phone_description'); ?></div>
                <?php
                $tel_phone = get_field("contact_phone_phone");;
                $tel_phone_trim = str_replace(' ', '', $tel_phone);
                ?>
                <div class='contacts-page-item-content-text3'><a href="tel:<?php echo $tel_phone_trim; ?>"><?php echo get_field("contact_phone_phone"); ?></a></div>
            </div>
          </div>
            <div class='contacts-page-item'>
                <div class='contacts-page-item-icon'>
                    <img src='<?php echo get_field('contact_email_icon'); ?>' />
                </div>
                <div class='contacts-page-item-content'>
                    <div class='contacts-page-item-content-text1'><?php echo get_field('contact_email_title'); ?></div>
                    <div class='contacts-page-item-content-text2'><?php echo get_field('contact_email_description'); ?></div>
                    <?php
                    $tel_phone = get_field("contact_email");;

                    ?>
                    <div class='contacts-page-item-content-text3'><a href="mail:<?php echo $tel_phone; ?>"><?php echo get_field("contact_email"); ?></a></div>
                </div>
            </div>
        </div>

    </div>

      <div class='col-md-8'>
        <div class='contacts-page-map'>
          <img class="js-contact-map" src='<?php bloginfo('template_url');?>/assets/img/contact/map.png' />
        </div>
      </div>

    </div>
  </div>
</div>
<!-- <div class='contacts-departments'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-3'>
        <div class='contacts-departments-title'>Departments</div>
      </div>
    </div>
    <div class='row'>
      <div class='col-md-3'>
        <div class='contacts-departments-item'>
          <div class='contacts-departments-item-title'>Management</div>
          <div class='contacts-departments-item-text'>Serhiy Dovzhenko</div>
          <div class='contacts-departments-item-text2'>Department head</div>
          <a href="tel:+38 (044) 000-00-00" class='contacts-departments-item-phone'>+38 (044) 000-00-00</a>
          <a href='mailto:management@ndp.ua' class='contacts-departments-item-email'>management@ndp.ua</a>
        </div>
      </div>
      <div class='col-md-3'>
        <div class='contacts-departments-item'>
          <div class='contacts-departments-item-title'>Experts</div>
          <div class='contacts-departments-item-text'>Yaroslava Smith</div>
          <div class='contacts-departments-item-text2'>Department head</div>
          <a href="tel:+38 (044) 000-00-00" class='contacts-departments-item-phone'>+38 (044) 000-00-00</a>
          <a href='mailto:management@ndp.ua' class='contacts-departments-item-email'>experts@ndp.ua</a>
        </div>
      </div>
      <div class='col-md-3'>
        <div class='contacts-departments-item'>
          <div class='contacts-departments-item-title'>Executives</div>
          <div class='contacts-departments-item-text'>Andriy Chornyj</div>
          <div class='contacts-departments-item-text2'>Department head</div>
          <a href="tel:+38 (044) 000-00-00" class='contacts-departments-item-phone'>+38 (044) 000-00-00</a>
          <a href='mailto:management@ndp.ua' class='contacts-departments-item-email'>executives@ndp.ua</a>
        </div>
      </div>
      <div class='col-md-3'>
        <div class='contacts-departments-item'>
          <div class='contacts-departments-item-title'>Support</div>
          <div class='contacts-departments-item-text'>Oleksandr Bilenkov</div>
          <div class='contacts-departments-item-text2'>Department head</div>
          <a href="tel:+38 (044) 000-00-00" class='contacts-departments-item-phone'>+38 (044) 000-00-00</a>
          <a href='mailto:management@ndp.ua' class='contacts-departments-item-email'>support@ndp.ua</a>
        </div>
      </div>
    </div>
  </div>
</div> -->
<div class='contacts-form'>
  <img src="<?php bloginfo('template_url');?>/assets/img/contact/ct_bg.png" class="contacts-form-bg">
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='contacts-form-container'>
          <div class='contacts-form-container-block'>
            <div class='row'>
              <div class='col-md-12'>
                <div class='contacts-form-title'>Contact Us</div>
                <div class='contacts-form-text'>We’d love to hear from you. Please fill out this form</div>
              </div>
            </div>
            
            <?php echo do_shortcode('[contact-form-7 id="44f107b" title="contacts"]'); ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-map">

    <div class="modal__block">
        <div class="modal__header">
            <span class="bt-close"></span>
        </div>
        <div class="modal__body">
            <div class="acf-map">
                <div class="marker" data-lat="50.44881820678711" data-lng="30.530290603637695"></div>
            </div>
        </div>
    </div>

</div>
<div id="popup-container" class="popup-container">
    <div class="popup-content">
        <span class="close-popup">&times;</span>
        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12.4999 20L17.4999 25L27.4999 15M36.6666 20C36.6666 29.2047 29.2047 36.6666 19.9999 36.6666C10.7952 36.6666 3.33325 29.2047 3.33325 20C3.33325 10.7952 10.7952 3.33331 19.9999 3.33331C29.2047 3.33331 36.6666 10.7952 36.6666 20Z" stroke="#2A59BD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

        <p>Ваше повідомлення було відправлене</p>
        <span>Наш експерт зв'яжеться з вами найближчим часом</span>
    </div>
</div>
<script>

function showMessage(message) {
    const popupContent = document.querySelector('.popup-content');
    if (popupContent) {
        popupContent.innerHTML = ''; // Очищаем содержимое попапа перед добавлением нового

        const svgImage = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svgImage.setAttribute('width', '100');
        svgImage.setAttribute('height', '100');
        svgImage.setAttribute('viewBox', '0 0 126 126');
        svgImage.style.background = '#EEF0FF'; // Задаем фон
        svgImage.style.borderRadius = '50%'; // Задаем border-radius
        svgImage.style.marginBottom = '20px';
        
        // Создаем элемент rect
        const rect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
        rect.setAttribute('width', '126');
        rect.setAttribute('height', '126');
        rect.setAttribute('rx', '63');
        rect.setAttribute('fill', '#EEF0FF');
        
        // Создаем элемент path с нужной формой
        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        path.setAttribute('d', 'M55.4999 63L60.4999 68L70.4999 58M79.6666 63C79.6666 72.2047 72.2047 79.6666 62.9999 79.6666C53.7952 79.6666 46.3333 72.2047 46.3333 63C46.3333 53.7952 53.7952 46.3333 62.9999 46.3333C72.2047 46.3333 79.6666 53.7952 79.6666 63Z');
        path.setAttribute('stroke', '#2A59BD');
        path.setAttribute('stroke-width', '2');
        path.setAttribute('stroke-linecap', 'round');
        path.setAttribute('stroke-linejoin', 'round');
        path.setAttribute('fill', 'none');
        
        // Добавляем элементы в SVG-изображение
        svgImage.appendChild(rect);
        svgImage.appendChild(path);

        // Добавляем SVG-изображение в контент попапа
        popupContent.appendChild(svgImage);

        // Создаем параграф с текстом
        const firstParagraph = document.createElement('p');
        firstParagraph.textContent = 'Your message has been sent';
        firstParagraph.classList.add('first-text-popup'); // Добавляем класс для первой строки
        popupContent.appendChild(firstParagraph);

        // Создаем второй параграф с второй строкой текста и применяем другой стиль через класс
        const secondParagraph = document.createElement('p');
        secondParagraph.textContent = 'Our expert will contact you soon';
        secondParagraph.classList.add('second-text-popup'); // Добавляем класс для второй строки
        popupContent.appendChild(secondParagraph);
        
       
       

        // Добавляем кнопку закрытия попапа в виде крестика
        const closeButton = document.createElement('span');
        closeButton.classList.add('close-popup');
        closeButton.innerHTML = '&#10006;'; // Код символа крестика
        popupContent.appendChild(closeButton);

        // Обработчик события для закрытия попапа при клике на крестик
        closeButton.addEventListener('click', function() {
            const popupContainer = document.getElementById('popup-container');
            if (popupContainer) {
                popupContainer.style.display = 'none'; // Скрыть попап окно
            }
        });
    }
}

</script>

<?php

get_footer();