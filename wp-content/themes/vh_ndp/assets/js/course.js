jQuery(document).ready(function ($) {
  $('.course__accordion-header').click(function () {
    var accordionItem = $(this).closest('.course__accordion-item');
    $('.course__accordion-item').not(accordionItem).find('.course__accordion-list').slideUp(200);
    $('.course__accordion-item').not(accordionItem).find('.accordion-plus').removeClass('accordion-plus-active');
    accordionItem.find('.course__accordion-list').slideToggle(200); 
    accordionItem.find('.accordion-plus').toggleClass('accordion-plus-active');
  });


  $('.modal-btn').on('click', function(event) {
    $('.modal, .modal__block').removeClass('active')
    // $('body').css({'overflow': 'hidden', 'padding-right': '17px'});

    let modal = $(this).data('modal');
    let $modal = $('.modal__'+modal);

    if ($modal.length) {
      $('.modal').addClass('active');
      $($modal).addClass('active');
    }
  })

  $('.modal').on('click', function(event) {
    let $target = $(event.target);
    if ($target.is('.modal__close') || !$target.closest('.authorization__block').length) {
      $('.modal, .modal__block').removeClass('active')
      // $('body').css({'overflow': '', 'padding-right': ''});
    }
  });

  $('.survey-page .first-start-course').on('click', function(event) {
    let link = $(this).attr('href') || '';
    if (link) {
      event.preventDefault();

      let id = $('.survey-page').attr('data-course-id') || '';
      if (id) {
        let data = {
          action: 'saveCourseStartDate',
          id: id,
        };

        $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: data,
          success: function(response) {
            // console.log(response);
            if (response && response.hasOwnProperty('message') && response['message'] === 'ok') {
              document.location.href = link;
            }
          },
          error: function (jqXHR, exception) {
            // console.log('error');
            // console.log(jqXHR);
            // console.log(exception);
          },
        })
      }
    }
  })
});

