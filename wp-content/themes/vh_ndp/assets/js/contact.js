const foos = [].map.call(document.querySelectorAll('.mdc-text-field'), function (el) {
    return new mdc.textField.MDCTextField(el);
});

(function ($) {
    $(function () {
        $(".phone__input").mask("(999) 999-99-99");

        $('.modal').on('click', function (event) {
            let $target = $(event.target);
            if ($target.is('.bt-close') || $target.is('.modal')) {
                $('.modal, .modal__block').removeClass('active')

                if ($target.is('.modal-map')) {
                    $('.acf-map').html('<div class="marker" data-lat="50.44881820678711" data-lng="30.530290603637695"></div>');
                }
            }
        });

        function new_map($el) {
            // Переменные
            var $markers = $el.find('.marker');

            // Переменные
            var args = {
                zoom: 14,
                center: new google.maps.LatLng(0, 0),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            // Создаем карту
            var map = new google.maps.Map($el[0], args);

            // Создаем заготовку массива маркеров
            map.markers = [];

            // Добавляем маркеры
            $markers.each(function () {

                add_marker($(this), map);

            });

            // Центрируем карту
            center_map(map);

            // Возвращаем данные
            return map;

        }

        function add_marker($marker, map) {

            // Переменные
            var latlng = new google.maps.LatLng($marker.attr('data-lat'), $marker.attr('data-lng'));

            // Создаем маркер
            var marker = new google.maps.Marker({
                position: latlng,
                map: map
            });

            // Добавляем маркер в массив
            map.markers.push(marker);

            // Если маркер содержит HTML, добавим его в infoWindow
            if ($marker.html()) {
                // оздаем info window
                var infowindow = new google.maps.InfoWindow({
                    content: $marker.html()
                });

                // Показываем info window при нажатии на маркер
                google.maps.event.addListener(marker, 'click', function () {

                    infowindow.open(map, marker);

                });
            }
        }

        /*
        *  center_map
        *
        *  Эта функция центрирует карту и показывает все маркеры, прикрепленные к карте
        *
        *  @type	function
        *  @date	8/11/2013
        *  @since	4.3.0
        *
        *  @param	map (Google Map object)
        *  @return	n/a
        */

        function center_map(map) {

            // Переменные
            var bounds = new google.maps.LatLngBounds();

            // Перебираем все маркеры и создаем bounds
            $.each(map.markers, function (i, marker) {

                var latlng = new google.maps.LatLng(marker.position.lat(), marker.position.lng());

                bounds.extend(latlng);

            });

            // Только 1 маркер?
            if (map.markers.length == 1) {
                // Центрируем карту
                map.setCenter(bounds.getCenter());
                map.setZoom(16);
            } else {
                // fit to bounds
                map.fitBounds(bounds);
            }

        }


        $('.js-contact-map').on('click', function (event) {
            $('.acf-map').each(function () {
                // Создаем карту
                map = new_map($(this));

            });

            $('.modal-map').addClass('active');
        })

    });//document ready
    
    

})(jQuery);


document.addEventListener('wpcf7mailsent', function(event) {
    const popupContainer = document.getElementById('popup-container');
    if (popupContainer) {
        popupContainer.style.display = 'flex'; // Показать попап окно
        showMessage('Спасибо! Ваше сообщение отправлено.');
    }
    
    // Закрытие попап окна при клике на кнопку закрытия
    const closePopup = document.querySelector('.close-popup');
    if (closePopup) {
        closePopup.addEventListener('click', function() {
            popupContainer.style.display = 'none'; // Скрыть попап окно
        });
    }
}, false);

document.addEventListener('wpcf7mailfailed', function(event) {
    const popupContainer = document.getElementById('popup-container');
    if (popupContainer) {
        popupContainer.style.display = 'flex'; // Показать попап окно
        showMessage('Ошибка! Что-то пошло не так.');
    }
    
    // Закрытие попап окна при клике на кнопку закрытия
    const closePopup = document.querySelector('.close-popup');
    if (closePopup) {
        closePopup.addEventListener('click', function() {
            popupContainer.style.display = 'none'; // Скрыть попап окно
        });
    }
}, false);

