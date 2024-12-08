jQuery(document).ready(function ($) {
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
  let startValue = 0,
    endValue = Number(progressBar.getAttribute("data-percentage")),
    speed = 50,
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

  $(document).click(function(event) {
    if ($(window).width() <= 767) {
      var element = $(".course__progress-text");
      if (!$(event.target).closest(".course__progress-text").length && !$(event.target).is(".course__progress-details")) {
        element.hide();
      }
    }
  });
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

  $('.course__title a').click(function(){
    $('#modal__attempts').addClass('active-modal');
    $('body').css({'overflow': 'hidden'});
  });
  $('.course__title a').click(function(){
    $('#modal__goout-timer').addClass('active-modal');
    $('body').css({'overflow': 'hidden'});
  });
  $('.course-training-page__modal-close').click(function(){
    $('#modal__goout').removeClass('active-modal');
    $('#modal__goout-timer').removeClass('active-modal');
    $('body').css({'overflow': ''});
  });
  $('.course-training-page__modal-cancel').click(function(){
    $('#modal__goout').removeClass('active-modal');
    $('#modal__goout-timer').removeClass('active-modal');
    $('body').css({'overflow': ''});
  });

  // змінює колір поля при виборі відповіді
  $(document).on('change', '.mdc-radio__native-control', function (e) {
    var isChecked = $(this).is(':checked');
    console.log('isChecked', isChecked);
    $('.mdc-form-field').each(function() {
      if ($(this).has($(this).find('.mdc-radio__native-control:checked')).length > 0) {
        $(this).css('background-color', isChecked ? '#EEF0FF' : 'white');
      } else {
        $(this).css('background-color', 'white');
      }
    });
    if (isChecked) {
      $('.quiz__buttons-check').removeClass('course__quiz--check__disable');
    }
  });

  // змінює колір поля при виборі відповіді
  $(document).on('change', '.mdc-checkbox__native-control', function (e) {
    var isChecked = $(this).is(':checked');
    var parentField = $(this).closest('.mdc-form-field');
    if ($(this).is(':checked')) {
      parentField.css('background-color', '#EEF0FF');
    } else {
      var isAnyChecked = false;
      parentField.siblings('.mdc-form-field').each(function() {
        if ($(this).find('.mdc-checkbox__native-control').is(':checked')) {
          isAnyChecked = true;
          return false;
        }
      });
      if (!isAnyChecked) {
        parentField.css('background-color', 'white');
      }
    }

    if (isChecked) {
      $('.quiz__buttons-check').removeClass('course__quiz--check__disable');
    }
  });

  // змінює колір поля, текста, обводки на червоний і виводить повідомлення про помилку
  $(document).on('click', '.quiz__buttons-check', function (e) {
    let $quizItem = $(e.target).closest('.course__quiz-item');
    let id = '', values = [];
    if ($quizItem.length) {
      id = $quizItem.attr('data-id') || '';
      $quizItem.find('input:checked').each(function(i, el) {
        values.push($(el).val())
      });
      if (!id || !values.length) return;
    }

    addSpinner($(e.target));

    let data = {
      action: 'checkQuizAnswer',
      questionID: id,
      values: values,
    };

    $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: data,
      success: function(response) {
        if (response && response.hasOwnProperty('result') && response['result']) {
          removeSpinner($(e.target));

          $('.course__quiz-message').css('display', 'none');
          $('.course__quiz-message__true').css('display', 'flex');
          $('.course__quiz-oneSelect__buttons-next').show();
          $('.course__quiz-oneSelect__buttons-skip').hide();
          $('.quiz__buttons-check').hide();
        } else {

          $('.course__quiz-message').css('display', 'none');
          $('.course__quiz-message__error').css('display', 'flex');

          $quizItem.find('input:checked').each(function(i, el) {
            let selectedField = $(el);
            selectedField.addClass('mdc-form-field-incorrect');
            selectedField.find('.mdc-radio__outer-circle').addClass('mdc-radio__outer-circle-incorrect');
            selectedField.find('.mdc-radio__inner-circle').addClass('mdc-radio__inner-circle-incorrect');
          });


        }
      },
      error: function (jqXHR, exception) {
        // console.log('error');
        // console.log(jqXHR);
        // console.log(exception);
      },
    });
  });

  const circularProgres = document.querySelectorAll(".course__quiz-result__circular-progress");

  Array.from(circularProgres).forEach((progressBar) => {
    const progressValue = progressBar.querySelector(".percentage");
    const innerCircle = progressBar.querySelector(".course__quiz-result__inner-circle");
    let startValue = 0,
      endValue = Number(progressBar.getAttribute("data-percentage")),
      speed = 20,
      progressColor = progressBar.getAttribute("data-progress-color");

    const progress = setInterval(() => {
      startValue++;
      if (endValue !== 0) {
        progressValue.textContent = `${startValue}%`;
      }
      progressValue.style.color = `${progressColor}`;

      innerCircle.style.backgroundColor = `${progressBar.getAttribute(
        "data-inner-circle-color"
      )}`;

      if (startValue <= endValue) {
        progressBar.style.background = `conic-gradient(${progressColor} ${startValue * 3.6}deg, ${progressBar.getAttribute("data-bg-color")} 0deg)`;
      }
      if (startValue === endValue) {
        clearInterval(progress);
      }
    }, speed);
  });

  $('.course__quiz-result__block-item').click(function () {
    var accordionItem = $(this).find('.course__quiz-result__block-item__details');
    $('.course__quiz-result__block-item__details').not(accordionItem).slideUp(200);
    accordionItem.slideToggle(200);
  });

  $('.course__quiz-start__previous-wrapper').click(function (event) {
    event.stopPropagation();
    $('.course__quiz-start__previous-list').toggle();
  });
  $(document).click(function () {
    $('.course__quiz-start__previous-list').hide();
  });

  $(function() {
    var inputs = function(element) {
      if (element.val() !== "" || element.is(":focus")) {
        element.parent().addClass("focus-label");
      } else {
        element.parent().removeClass("focus-label");
      }
    };
  
    $(".course__quiz-start__previous-input").on("input change focus blur", function() {
      inputs($(this));
    });
  
    $('.course__quiz-start__previous-list__item').click(function() {
      var text = $(this).text().trim();
      $('#attempt').val(text);

      var value = $(this).attr('data-value').trim();
      if ( value ) {
        window.location.href = value;
      }
      $('.course__quiz-start__previous-list__item').removeClass('course__quiz-start__previous-list__item-current');
      $(this).addClass('course__quiz-start__previous-list__item-current');
      $('.course__quiz-start__previous-wrapper').addClass('focus-label');
    });
  });

  $('.course__quiz__modal-close').click(function(){
    $('#modal__attempts').removeClass('active-modal');
    $('#modal__time').removeClass('active-modal');
    $('body').css({'overflow': ''});
  });
  $('.course__quiz__modal-confirm').click(function(){
    $('#modal__attempts').removeClass('active-modal');
    $('#modal__time').removeClass('active-modal');
    $('body').css({'overflow': ''});
  });


  function addSpinner($target, parent='div') {
    if (!$target.length) return;

    $target.closest(parent)
        .addClass('position-relative')
        .append('<span class="spinner"></span>');
    setTimeout(function() {
      $target.closest(parent).find('.spinner').remove();
    },5000);
  }

  function removeSpinner($target, parent='div') {
    if (!$target.length) return;

    $target.closest(parent)
        .removeClass('position-relative')
        .find('.spinner').remove();
  }
});

