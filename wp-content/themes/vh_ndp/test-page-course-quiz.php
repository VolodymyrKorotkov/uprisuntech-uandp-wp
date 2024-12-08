<?php
/*
Template Name: Course quiz
для тестов и проверки вёрстки
*/

get_header('home');
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/material-components-web.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/course-quiz-old.css">

<section class="course">
  <div class="container">
    <div class="course__header">
      <div class="course__title">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M15.7049 7.41L14.2949 6L8.29492 12L14.2949 18L15.7049 16.59L11.1249 12L15.7049 7.41Z" fill="#2A59BD"/>
          </svg>
        </a>
        <h1>Thermal Modeling of Solar Energy Systems</h1>
      </div>
      <div class="course__title-right">
      <div class="course__header-limit">
          <div class="course__header-limit__time">00:09:42:16</div>
          <div class="course__header-limit__text">
            <h4 class="course__header-limit__title">Time left</h4>
            <span class="course__header-limit__subtitle">Progress will be reset</span>
          </div>
        </div>
        <div class="course__progress">
          <div class="course__progress-text">
            <h2 class="course__progress-title">Your progress</h2>
            <span class="course__progress-subtitle">0 of 30 complete</span>
          </div>
          <div class="course__progress-item" data-inner-circle-color="white" data-percentage="20" data-progress-color="#4770c6" data-bg-color="#dce2f9">
            <div class="course__progress-inner__circle"></div>
           </div>
           <span class="course__progress-details">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8C13.1 8 14 7.1 14 6C14 4.9 13.1 4 12 4C10.9 4 10 4.9 10 6C10 7.1 10.9 8 12 8ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM10 18C10 16.9 10.9 16 12 16C13.1 16 14 16.9 14 18C14 19.1 13.1 20 12 20C10.9 20 10 19.1 10 18Z" fill="#45464F"/>
              </svg>
            </span>
        </div>
      </div>
    </div>
    <div class="course__block">
     <div class="course__main col-md-7 col-lg-8">
      <div class="course__quiz">
        <div class="course__quiz-item course__quiz-start">
          <h2 class="course__quiz-start__title">Lesson With Quiz</h2>
          <p class="course__quiz-start__subtitle">Quiz Information</p>
          <div class="course__quiz-start__block">
            <div class="course__quiz-start__block-item">
              <span>Minimum Passing Grade</span>
              <strong>50%</strong>
            </div>
            <div class="course__quiz-start__block-item">
              <span>Remaining Attempts</span>
              <strong>Unlimited</strong>
            </div>
            <div class="course__quiz-start__block-item">
              <span>Questions</span>
              <strong>6</strong>
            </div>
            <div class="course__quiz-start__block-item">
              <span>Time Limit</span>
              <strong>Unlimited</strong>
            </div>
          </div>
          <div class="course__quiz-start__previous">
            <h3 class="course__quiz-start__previous-title">View Previous Attempts</h3>
            <div class="course__quiz-start__previous-wrapper">
              <input type="text" id="attempt" class="course__quiz-start__previous-input">
              <label for="attempt" class="course__quiz-start__previous-label">Select an Attempt</label>
              <div class="course__quiz-start__previous-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-dropdown.svg" alt="arrow">
              </div>
              <ul class="course__quiz-start__previous-list">
                <li class="course__quiz-start__previous-list__item course__quiz-start__previous-list__item-current">Select an Attempt</li>
                <li class="course__quiz-start__previous-list__item">Attempt #3 – 66,67% (Pass)</li>
                <li class="course__quiz-start__previous-list__item">Attempt #2 – 33,33% (Fail)</li>
                <li class="course__quiz-start__previous-list__item">Attempt #1 – 0% (Incomplete)</li>
              </ul>
            </div>
          </div>
          <div class="course__quiz-start__buttons">
            <button class="course__quiz-start__buttons-action">Start quiz</button>
            <button class="course__quiz-start__buttons-skip">Skip quiz</button>
          </div>
        </div>
        <div class="course__quiz-item course__quiz-oneSelect"> <!-- Правильна / неправильна відповідь виводиться в цьому блоці -->
        <div class="course__quiz-limit">
          <div class="course__quiz-limit__time">00:29:16</div>
          <div class="course__quiz-limit__text">
            <h4 class="course__quiz-limit__title">Time left</h4>
            <span class="course__quiz-limit__subtitle">Progress will be reset</span>
          </div>
        </div>
          <div class="course__quiz-progress">
            <span class="course__quiz-progress__current"></span>
          </div>
          <h2 class="course__quiz-oneSelect__title">How many different options are there that can be used in solar energy systems?</h2>
          <div class="course__quiz-oneSelect__block">
            <div class="course__quiz-oneSelect__block-item">
              <div class="mdc-form-field">
              <div class="mdc-radio">
                <input class="mdc-radio__native-control" type="radio" id="radio-1" name="radios">
              <div class="mdc-radio__background">
              <div class="mdc-radio__outer-circle"></div>
              <div class="mdc-radio__inner-circle"></div>
              </div>
              </div>
                <label for="radio-1">Answer 1</label>
              </div>
            </div>
            <div class="course__quiz-oneSelect__block-item">
            <div class="mdc-form-field">
              <div class="mdc-radio">
                <input class="mdc-radio__native-control" type="radio" id="radio-2" name="radios">
              <div class="mdc-radio__background">
              <div class="mdc-radio__outer-circle"></div>
              <div class="mdc-radio__inner-circle"></div>
              </div>
              </div>
                <label for="radio-2">Answer 2</label>
              </div>
            </div>
            <div class="course__quiz-oneSelect__block-item">
            <div class="mdc-form-field">
              <div class="mdc-radio">
                <input class="mdc-radio__native-control" type="radio" id="radio-3" name="radios">
              <div class="mdc-radio__background">
              <div class="mdc-radio__outer-circle"></div>
              <div class="mdc-radio__inner-circle"></div>
              </div>
              </div>
                <label for="radio-3">Answer 3</label>
              </div>
            </div>
            <div class="course__quiz-oneSelect__block-item">
            <div class="mdc-form-field">
              <div class="mdc-radio">
                <input class="mdc-radio__native-control" type="radio" id="radio-4" name="radios">
              <div class="mdc-radio__background">
              <div class="mdc-radio__outer-circle"></div>
              <div class="mdc-radio__inner-circle"></div>
              </div>
              </div>
                <label for="radio-4">Answer 4</label>
              </div>
            </div>
            <div class="course__quiz-oneSelect__true">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM11 17V15H13V17H11ZM11 7V13H13V7H11Z" fill="#008678"/>
              </svg>
              <p>Good job! Keep it up</p>
            </div>
            <div class="course__quiz-oneSelect__error">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM11 17V15H13V17H11ZM11 7V13H13V7H11Z" fill="#BA1A1A"/>
              </svg>
              <p>Incorrect answer. Please try again.</p>
            </div>
          </div>
          <div class="course__quiz-oneSelect__action">
            <span>Question 3 of 6</span>
            <div class="course__quiz-oneSelect__buttons">
              <button class="course__quiz-oneSelect__buttons-skip">Skip question</button>
              <button class="course__quiz-oneSelect__buttons-check course__quiz-oneSelect__buttons-check__disable">Check Answer</button>
              <button class="course__quiz-oneSelect__buttons-next">Next question</button>
            </div>
          </div>
        </div>
        <div class="course__quiz-item course__quiz-finalQuestion">
          <div class="course__quiz-progress">
            <span class="course__quiz-progress__current"></span>
          </div>
          <h2 class="course__quiz-finalQuestion__title">Which of the following panel technologies has the most efficient new generation technology?</h2>
          <div class="course__quiz-finalQuestion__block">
            <div class="course__quiz-finalQuestion__block-item">
              <div class="mdc-form-field">
              <div class="mdc-radio">
                <input class="mdc-radio__native-control" type="radio" id="radio-final-1" name="radios">
              <div class="mdc-radio__background">
              <div class="mdc-radio__outer-circle"></div>
              <div class="mdc-radio__inner-circle"></div>
              </div>
              </div>
                <label for="radio-final-1">Answer 1</label>
              </div>
            </div>
            <div class="course__quiz-finalQuestion__block-item">
            <div class="mdc-form-field">
              <div class="mdc-radio">
                <input class="mdc-radio__native-control" type="radio" id="radio-final-2" name="radios">
              <div class="mdc-radio__background">
              <div class="mdc-radio__outer-circle"></div>
              <div class="mdc-radio__inner-circle"></div>
              </div>
              </div>
                <label for="radio-final-2">Answer 2</label>
              </div>
            </div>
            <div class="course__quiz-finalQuestion__block-item">
            <div class="mdc-form-field">
              <div class="mdc-radio">
                <input class="mdc-radio__native-control" type="radio" id="radio-final-3" name="radios">
              <div class="mdc-radio__background">
              <div class="mdc-radio__outer-circle"></div>
              <div class="mdc-radio__inner-circle"></div>
              </div>
              </div>
                <label for="radio-final-3">Answer 3</label>
              </div>
            </div>
            <div class="course__quiz-finalQuestion__block-item">
            <div class="mdc-form-field">
              <div class="mdc-radio">
                <input class="mdc-radio__native-control" type="radio" id="radio-final-4" name="radios">
              <div class="mdc-radio__background">
              <div class="mdc-radio__outer-circle"></div>
              <div class="mdc-radio__inner-circle"></div>
              </div>
              </div>
                <label for="radio-final-4">Answer 4</label>
              </div>
            </div>
            <div class="course__quiz-finalQuestion__true">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM11 17V15H13V17H11ZM11 7V13H13V7H11Z" fill="#008678"/>
              </svg>
              <p>Good job! Check your result</p>
            </div>
          </div>
          <div class="course__quiz-finalQuestion__action">
            <span>Question 6 of 6</span>
            <div class="course__quiz-finalQuestion__buttons">
              <button class="course__quiz-finalQuestion__buttons-results">See results</button>
            </div>
          </div>
        </div>
        <div class="course__quiz-item course__quiz-multiSelect">
          <div class="course__quiz-progress">
            <span class="course__quiz-progress__current"></span>
          </div>
          <h2 class="course__quiz-multiSelect__title">Which year was a record in terms of installation in Ukraine?</h2>
          <div class="course__quiz-multiSelect__block">
            <div class="course__quiz-multiSelect__block-item">
              <div class="mdc-form-field">
              <div class="mdc-checkbox">
                <input type="checkbox" class="mdc-checkbox__native-control" id="checkbox-1" />
              <div class="mdc-checkbox__background">
                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                </svg>
              <div class="mdc-checkbox__mixedmark"></div>
              </div>
              </div>
              <label for="checkbox-1">Answer 1</label>
              </div>
            </div>
            <div class="course__quiz-multiSelect__block-item">
              <div class="mdc-form-field">
              <div class="mdc-checkbox">
                <input type="checkbox" class="mdc-checkbox__native-control" id="checkbox-2" />
              <div class="mdc-checkbox__background">
                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                </svg>
              <div class="mdc-checkbox__mixedmark"></div>
              </div>
              </div>
              <label for="checkbox-2">Answer 2</label>
              </div>
            </div>
            <div class="course__quiz-multiSelect__block-item">
              <div class="mdc-form-field">
              <div class="mdc-checkbox">
                <input type="checkbox" class="mdc-checkbox__native-control" id="checkbox-3" />
              <div class="mdc-checkbox__background">
                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                </svg>
              <div class="mdc-checkbox__mixedmark"></div>
              </div>
              </div>
              <label for="checkbox-3">Answer 3</label>
              </div>
            </div>
            <div class="course__quiz-multiSelect__block-item">
              <div class="mdc-form-field">
              <div class="mdc-checkbox">
                <input type="checkbox" class="mdc-checkbox__native-control" id="checkbox-4" />
              <div class="mdc-checkbox__background">
                <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                </svg>
              <div class="mdc-checkbox__mixedmark"></div>
              </div>
              </div>
              <label for="checkbox-4">Answer 4</label>
              </div>
            </div>
          </div>
          <div class="course__quiz-multiSelect__action">
            <span>Question 3 of 6</span>
            <div class="course__quiz-multiSelect__buttons">
              <button class="course__quiz-multiSelect__buttons-skip">Skip question</button>
              <button class="course__quiz-multiSelect__buttons-check">Check Answer</button>
            </div>
          </div>
        </div>
        <div class="course__quiz-item course__quiz-result">
          <h2 class="course__quiz-result__title">Attempt #1 Results</h2>
          <div class="course__quiz-result__info">
            <div class="course__quiz-result__circular-progress" data-inner-circle-color="white" data-percentage="66" data-progress-color="#008678" data-bg-color="#DCE2F9">
              <div class="course__quiz-result__inner-circle"></div>
              <p class="percentage">0%</p>
              <p class="course__quiz-result__pass">Pass</p>
              </div>
              <div class="course__quiz-result__info-text">
                <div class="course__quiz-result__info-text__item">
                  <span>Correct Answers</span>
                  <strong>4 / 6</strong>
              </div>
                <div class="course__quiz-result__info-text__item">
                  <span>Completed</span>
                  <strong>09.10.2023, 9:17</strong>
              </div>
                <div class="course__quiz-result__info-text__item">
                  <span>Total time</span>
                  <strong>10 min, 34 sec</strong>
              </div>
              </div>
          </div>
          <div class="course__quiz-result__block">
            <div class="course__quiz-result__block-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.6 7.6L18 9L10 17L6 13L7.4 11.6L10 14.2L16.6 7.6Z" fill="#008678"/>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 1</h3>
                <span class="course__quiz-result__block-item__points">1 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"/>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 2</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"/>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 3</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.6 7.6L18 9L10 17L6 13L7.4 11.6L10 14.2L16.6 7.6Z" fill="#008678"/>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 4</h3>
                <span class="course__quiz-result__block-item__points">1 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.6 7.6L18 9L10 17L6 13L7.4 11.6L10 14.2L16.6 7.6Z" fill="#008678"/>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 5</h3>
                <span class="course__quiz-result__block-item__points">1 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.6 7.6L18 9L10 17L6 13L7.4 11.6L10 14.2L16.6 7.6Z" fill="#008678"/>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 6</h3>
                <span class="course__quiz-result__block-item__points">1 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                </div>
              </div>
            </div>
          </div>
          <div class="course__quiz-result__buttons">
            <button class="course__quiz-result__buttons-retry">Retry quiz</button>
            <button class="course__quiz-result__buttons-continue">Continue</button>
          </div>
        </div>
        <div class="course__quiz-item course__quiz-result">
          <h2 class="course__quiz-result__title">Attempt #1 Results</h2>
          <div class="course__quiz-result__info">
            <div class="course__quiz-result__circular-progress" data-inner-circle-color="white" data-percentage="33" data-progress-color="#BA1A1A" data-bg-color="#DCE2F9">
              <div class="course__quiz-result__inner-circle"></div>
              <p class="percentage">0%</p>
              <p class="course__quiz-result__fail">Fail</p>
              </div>
              <div class="course__quiz-result__info-text">
                <div class="course__quiz-result__info-text__item">
                  <span>Correct Answers</span>
                  <strong>2 / 6</strong>
              </div>
                <div class="course__quiz-result__info-text__item">
                  <span>Completed</span>
                  <strong>09.10.2023, 9:17</strong>
              </div>
                <div class="course__quiz-result__info-text__item">
                  <span>Total time</span>
                  <strong>10 min, 34 sec</strong>
              </div>
              </div>
          </div>
          <div class="course__quiz-result__block">
            <div class="course__quiz-result__block-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.6 7.6L18 9L10 17L6 13L7.4 11.6L10 14.2L16.6 7.6Z" fill="#008678"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 1</h3>
                <span class="course__quiz-result__block-item__points">1 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 2</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 3</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 4</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 5</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.6 7.6L18 9L10 17L6 13L7.4 11.6L10 14.2L16.6 7.6Z" fill="#008678"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 6</h3>
                <span class="course__quiz-result__block-item__points">1 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                </div>
              </div>
            </div>
          </div>
          <div class="course__quiz-result__buttons">
            <button class="course__quiz-result__buttons-retry">Retry quiz</button>
            <button class="course__quiz-result__buttons-continue">Continue</button>
          </div>
        </div>
        <div class="course__quiz-item course__quiz-result">
          <h2 class="course__quiz-result__title">Attempt #1 Results</h2>
          <div class="course__quiz-result__info">
            <div class="course__quiz-result__circular-progress" data-inner-circle-color="white" data-percentage="0" data-progress-color="#919094" data-bg-color="#DCE2F9">
              <div class="course__quiz-result__inner-circle"></div>
              <p class="percentage">0%</p>
              <p class="course__quiz-result__incomplete">Incomplete</p>
              </div>
              <div class="course__quiz-result__info-text">
                <div class="course__quiz-result__info-text__item">
                  <span>Correct Answers</span>
                  <strong>0 / 6</strong>
              </div>
                <div class="course__quiz-result__info-text__item">
                  <span>Completed</span>
                  <strong>09.10.2023, 9:17</strong>
              </div>
                <div class="course__quiz-result__info-text__item">
                  <span>Total time</span>
                  <strong>10 min, 34 sec</strong>
              </div>
              </div>
          </div>
          <div class="course__quiz-result__block">
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 1</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 2</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 3</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 4</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 5</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
            <div class="course__quiz-result__block-item course__quiz-result__block-item__incorrect">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"></path>
              </svg>
              <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title">Question 6</h3>
                <span class="course__quiz-result__block-item__points">0 / 1 points</span>
                <div class="course__quiz-result__block-item__details">
                  <div class="course__quiz-result__block-item__details-selected"><span>Selected answer:</span><strong>Answer 1</strong></div>
                  <div class="course__quiz-result__block-item__details-correct"><span>Correct answer:</span><strong>Answer 2</strong></div>
                </div>
              </div>
            </div>
          </div>
          <div class="course__quiz-result__buttons">
            <button class="course__quiz-result__buttons-retry">Retry quiz</button>
            <button class="course__quiz-result__buttons-continue">Continue</button>
          </div>
        </div>

      </div>
     </div>

     <div class="course__content col-md-4">
      <div class="course__content-title">
        <h2>Course content</h2>
        <button class="btn btn-outline-link">
        Show result
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M16.5 7.305L11.1075 6.84L9 1.875L6.8925 6.8475L1.5 7.305L5.595 10.8525L4.365 16.125L9 13.3275L13.635 16.125L12.4125 10.8525L16.5 7.305ZM9 11.925L6.18 13.6275L6.93 10.4175L4.44 8.2575L7.725 7.9725L9 4.95L10.2825 7.98L13.5675 8.265L11.0775 10.425L11.8275 13.635L9 11.925Z" fill="#2A59BD"/>
          </svg>
        </button>
        </div>
     <div class="course__accordion">
    <div class="course__accordion-item">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
          <span class="course__accordion-info__label">Complete</span>
        </div>
        </div>
      </div>
      <div class="course__accordion-hidden">
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="course__accordion-item">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
        </div>
        </div>
      </div>
      <div class="course__accordion-hidden">
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="course__accordion-item">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
          <span class="course__accordion-info__label">Limit 2 h 45 m</span>
        </div>
      </div>
    </div>
    <div class="course__accordion-hidden">
        <div class="course__accordion-limit">
          <div class="course__accordion-limit__time">00:09:42:16</div>
          <div class="course__accordion-limit__text">
            <h4 class="course__accordion-limit__title">Time left</h4>
            <span class="course__accordion-limit__subtitle">Progress will be reset</span>
          </div>
        </div>
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="course__accordion-item">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
        </div>
        </div>
      </div>
      <div class="course__accordion-hidden">
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="course__accordion-item">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
        </div>
        </div>
      </div>
      <div class="course__accordion-hidden">
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="course__accordion-item course__accordion-item__locked">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
          <span class="course__accordion-info__label course__accordion-info__label-locked">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M12.75 7.5V6C12.75 3.92893 11.0711 2.25 9 2.25C6.92893 2.25 5.25 3.92893 5.25 6V7.5M9 10.875V12.375M6.6 15.75H11.4C12.6601 15.75 13.2902 15.75 13.7715 15.5048C14.1948 15.289 14.539 14.9448 14.7548 14.5215C15 14.0402 15 13.4101 15 12.15V11.1C15 9.83988 15 9.20982 14.7548 8.72852C14.539 8.30516 14.1948 7.96095 13.7715 7.74524C13.2902 7.5 12.6601 7.5 11.4 7.5H6.6C5.33988 7.5 4.70982 7.5 4.22852 7.74524C3.80516 7.96095 3.46095 8.30516 3.24524 8.72852C3 9.20982 3 9.83988 3 11.1V12.15C3 13.4101 3 14.0402 3.24524 14.5215C3.46095 14.9448 3.80516 15.289 4.22852 15.5048C4.70982 15.75 5.33988 15.75 6.6 15.75Z" stroke="#919094" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Locked</span>
        </div>
        </div>
      </div>
      <div class="course__accordion-hidden">
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
     </div>
    </div>
  </div>
</section>

<!-- МОДАЛКИ -->
<div class="course__quiz__modal" id="modal__attempts">
  <div class="course__quiz__modal-item">
    <button class="course__quiz__modal-close"></button>
    <div class="course__quiz__modal-image">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
        <path d="M21.3327 21.3332C21.3327 21.3332 19.3327 18.6665 15.9993 18.6665C12.666 18.6665 10.666 21.3332 10.666 21.3332M19.9993 11.9998H20.0127M11.9993 11.9998H12.0127M29.3327 15.9998C29.3327 23.3636 23.3631 29.3332 15.9993 29.3332C8.63555 29.3332 2.66602 23.3636 2.66602 15.9998C2.66602 8.63604 8.63555 2.6665 15.9993 2.6665C23.3631 2.6665 29.3327 8.63604 29.3327 15.9998ZM20.666 11.9998C20.666 12.368 20.3675 12.6665 19.9993 12.6665C19.6312 12.6665 19.3327 12.368 19.3327 11.9998C19.3327 11.6316 19.6312 11.3332 19.9993 11.3332C20.3675 11.3332 20.666 11.6316 20.666 11.9998ZM12.666 11.9998C12.666 12.368 12.3675 12.6665 11.9993 12.6665C11.6312 12.6665 11.3327 12.368 11.3327 11.9998C11.3327 11.6316 11.6312 11.3332 11.9993 11.3332C12.3675 11.3332 12.666 11.6316 12.666 11.9998Z" stroke="#BA1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <h2 class="course__quiz__modal-title">The number of attempts is over</h2>
    <span class="course__quiz__modal-subtitle">You failed the QUIZ. QUIZ is blocked.</span>
    <div class="course__quiz__modal-buttons">
      <button class="course__quiz__modal-confirm">Okay</button>
    </div>
  </div>
</div>
<div class="course__quiz__modal" id="modal__time">
  <div class="course__quiz__modal-item">
    <button class="course__quiz__modal-close"></button>
    <div class="course__quiz__modal-image">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
        <path d="M21.3327 21.3332C21.3327 21.3332 19.3327 18.6665 15.9993 18.6665C12.666 18.6665 10.666 21.3332 10.666 21.3332M19.9993 11.9998H20.0127M11.9993 11.9998H12.0127M29.3327 15.9998C29.3327 23.3636 23.3631 29.3332 15.9993 29.3332C8.63555 29.3332 2.66602 23.3636 2.66602 15.9998C2.66602 8.63604 8.63555 2.6665 15.9993 2.6665C23.3631 2.6665 29.3327 8.63604 29.3327 15.9998ZM20.666 11.9998C20.666 12.368 20.3675 12.6665 19.9993 12.6665C19.6312 12.6665 19.3327 12.368 19.3327 11.9998C19.3327 11.6316 19.6312 11.3332 19.9993 11.3332C20.3675 11.3332 20.666 11.6316 20.666 11.9998ZM12.666 11.9998C12.666 12.368 12.3675 12.6665 11.9993 12.6665C11.6312 12.6665 11.3327 12.368 11.3327 11.9998C11.3327 11.6316 11.6312 11.3332 11.9993 11.3332C12.3675 11.3332 12.666 11.6316 12.666 11.9998Z" stroke="#BA1A1A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>
    <h2 class="course__quiz__modal-title">Time to pass is over</h2>
    <span class="course__quiz__modal-subtitle">You failed the QUIZ. QUIZ is blocked.</span>
    <div class="course__quiz__modal-buttons">
      <button class="course__quiz__modal-confirm">Okay</button>
    </div>
  </div>
</div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/material-components-web.min.js?ver=1.0.0"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/course-quiz.js"></script>


<?php

get_footer();