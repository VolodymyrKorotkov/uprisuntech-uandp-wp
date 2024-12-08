jQuery(document).ready(function ($) {

  $('.course__title a').on('click', function(e) {
    e.preventDefault();  // Отменяет действие по умолчанию для элемента <a>
    window.history.back();
  });

  if($('.course__accordion-list li:first').hasClass('course__accordion-list__item-current')){
    $('.course__title a').remove();
  }
  $('.course__accordion-header').click(function () {
    var accordionItem = $(this).closest('.course__accordion-item');
    $('.course__accordion-item').not(accordionItem).find('.course__accordion-hidden').slideUp(200);
    $('.course__accordion-item').not(accordionItem).find('.accordion-plus').removeClass('accordion-plus-active');
    accordionItem.find('.course__accordion-hidden').slideToggle(200); 
    accordionItem.find('.accordion-plus').toggleClass('accordion-plus-active');
  });
  const circularProgress = document.querySelectorAll(".course__progress-item");

  Array.from(circularProgress).forEach((progressBar) => {
  const innerCircle = progressBar.querySelector(".course__progress-inner__circle");
  let startValue = -1,
    endValue = Number(progressBar.getAttribute("data-percentage")),
    speed = 20,
    progressColor = progressBar.getAttribute("data-progress-color");

  const progress = setInterval(() => {
    startValue++;

    innerCircle.style.backgroundColor = `${progressBar.getAttribute(
      "data-inner-circle-color"
    )}`;

    progressBar.style.background = `conic-gradient(${progressColor} ${
      startValue * 3.6
    }deg,${progressBar.getAttribute("data-bg-color")} 0deg)`;
    if (startValue === endValue) {
      clearInterval(progress);
    }
  }, speed);
  });

  var isOpen = true;
  var contentBlock = $('.course-training-page-left-box-article-content');
  var initialHeight = contentBlock.height();

  $('.course-training-page-left-box-article-button').click(function() {
    let text = '';
      if (isOpen) {
        if ($(this).attr('data-expand')) {
          text = $(this).attr('data-expand');
        } else {
          text = 'Expand'
        }
          contentBlock.animate({ height: '550px' }, 500);
          $('.course-training-page-left-box-article-button span').show();
          $('.course-training-page-left-box-article-button svg').css('transform', 'rotate(180deg)');
          $('.course-training-page-left-box-article-button strong').text(text);
      } else {
        if ($(this).attr('data-collapse')) {
          text = $(this).attr('data-collapse');
        } else {
          text = 'Collapse'
        }
          contentBlock.animate({ height: initialHeight }, 500); 
          $('.course-training-page-left-box-article-button span').hide();
          $('.course-training-page-left-box-article-button svg').css('transform', 'rotate(0deg)');
          $('.course-training-page-left-box-article-button strong').text(text);
      }
      isOpen = !isOpen;
  });
  $(".course__progress-details").click(function(target) {
    var progressText = $(".course__progress-text");
    target.stopPropagation();
    if (progressText.is(":visible")) {
      progressText.hide();
    } else {
      progressText.show();
    }
  });

  function adjustCourseProgressText() {
    if ($(window).width() > 767) {
      $(".course__progress-text").show();
    }  else {
      $(".course__progress-text").hide();
    }
  }
  
  adjustCourseProgressText();
  
  $(window).resize(function() {
    adjustCourseProgressText();
  });

  // $(document).click(function(event) {
  //   var element = $(".course__progress-text");
  //   if (!$(event.target).closest(".course__progress-text").length && !$(event.target).is(".course__progress-details")) {
  //     element.hide();
  //   }
  // });
  function adjustHeaderLimit() {
    if ($(window).width() <= 767) {
      $(".course__header-limit").appendTo(".course__header");
    } else {
      $(".course__header-limit").prependTo(".course__title-right");
    }
  }

  adjustHeaderLimit();
  
  $(window).resize(function() {
    adjustHeaderLimit();
  });

  $('.btn-outline-link-circle').on('click', function(event) {
    $(event.target).closest('.btn-outline-link-circle').toggleClass('active');
    $('.course-training-page-description-accordion').slideToggle(200);
  })

  $('.course-training-page-left-box-description-text-actions .btn.btn-next a').click(function(e){
    e.preventDefault();

    let $markComplete = $('#llms_mark_complete');
    if ($markComplete.length) {
      $markComplete.click()
    } else {
      let href = $(this).attr('href') || '';
      if (href) {
        document.location.href = href
      }
    }
  })
});

