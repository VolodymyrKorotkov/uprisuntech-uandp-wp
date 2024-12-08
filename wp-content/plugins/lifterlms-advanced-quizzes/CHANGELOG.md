LifterLMS Advanced Quizzes Changelog
====================================

v3.2.0 - 2023-10-09
-------------------

##### Updates and Enhancements

+ Raised the minimum LifterLMS required version to 7.4.1-alpha.

##### Bug Fixes

+ Fixed issue when limiting the number of questions using the question bank.

##### Developer Notes

+ Added `LLMS_AQ_Question_Bank::modify_attempt_questions_array()`.
+ Deprecated `LLMS_AQ_Question_Bank::set_quiz_questions()`.


v3.1.0 - 2023-10-05
-------------------

##### New Features

+ Added Questions Bank Feature.

##### Updates and Enhancements

+ Raised the minimum LifterLMS required version to 7.4.0-alpha.


v3.0.0 - 2022-08-23
-------------------

##### Updates and Enhancements

+ **[BREAKING]** Raised the minimum supported PHP version to 7.4.
+ **[BREAKING]** Raised the minimum supported WordPress core version to 5.6.

##### Bug Fixes

+ Fixed PHP 8.1 deprecation warning resulting from usage of `FILTER_SANITIZE_STRING`.
+ Fixed an issue with the code question type answer rendering.

##### Developer Notes

+ Fix issue encountered when passing an extension string with a leading dot to the `llms_aq_mime_ensure_dot()`.

##### Security Fixes

+ Fixed issue allowing upload question types to associate an upload answer with an invalid or non-existent quiz attempt.


v2.0.1 - 2022-02-21
-------------------

##### Bug Fixes

+ Added flexbox support to picture reorder questions to fix layout issues when images of different sizes are used.

##### Updated Templates

+ templates/quiz/questions/content-picture_reorder.php


v2.0.0 - 2022-02-02
-------------------

##### Updates and Enhancements

+ The minimum supported LifterLMS Core version has been raised to 4.9.0.
+ Use `@wordpress/i18n` functions in favor of `LLMS.l10n` for client-side translation of strings found in the quiz interface.

##### Bug Fixes

+ Fixed word count validation issues found on long answer questions when using non Latin-scripts such as Chinese or Japanese.
+ Fixed an issue preventing themes and child-themes from overriding template files using default LifterLMS template override functionality.

##### Breaking Changes

+ Removed `Countable` Javascript library in favor of `words-count`.
+ Removed the public class method `LLMS_Assets::init()`.
+ Removed class `LLMS_AQ_l10n`.
+ Removed deprecated function `LLMS_Advanced_Quizzes()`.
+ Sourcemaps for static assets (.js and .css) are no longer included in the distributed codebase.
+ Unminified static assets (.js and .css) are no longer included in the distributed codebase.


v1.1.1 - 2020-11-06
-------------------

##### Bug fixes

+ Added `'notranslate'` class to the field's wrapper to fix conflicts with the gTranslate plugin.

##### Templates Updated

+ `templates/quiz/questions/content-long_answer.php`


v1.1.0 - 2020-08-28
-------------------

##### Dependency Requirement Changes

+ The minimum required LifterLMS Core Version has been raised to 3.29.0. Please ensure the LifterLMS core meets this requirement in order to continue using this add-on!

##### Updates

+ Added the ability to choose the case-sensitivity of answers for automatically graded Fill in the Blank questions
+ Refactored various classes and methods.
+ Removed inline sourcemaps for static assets.

##### Deprecations

+ Deprecated function `LLMS_Advanced_Quizzes()` in favor of `llms_aq()`.


v1.0.10 - 2019-07-15
-------------------

+ Fixed an issue preventing reorder and reorder picture question types from properly functioning on mobile Chrome browsers.
+ Reorder Picture questions will now show a number based on their shuffled order instead of their created (correct) order.


v1.0.9 - 2018-11-07
-------------------

+ Fixed ID of the "Quiz: Awaiting Review" notification to ensure customizations to the notification don't get saved to the "Quiz: Passed" notification


v1.0.8 - 2018-10-23
-------------------

+ Added admin email notification triggered when a quiz is submitted that requires manual grading
+ Quizzes main reporting screen now shows the number of attempts pending review in the "Awaiting Review" column
+ Quizzes main reporting screen will now embolden any quiz which has at least 1 quiz attempt pending review
+ Quizz attempts reporting screens will now embolden any attempt which is pending review
+ Fixed a few areas where the incorrect textdomain was being used


v1.0.7 - 2018-10-04
-------------------

+ Fixed issue with 1.0.6 database migration which wasn't doing it's job to fix reorder questions


v1.0.6 - 2018-09-18
-------------------

+ Fixed issue causing reorder and picture reorder questions from always being graded as incorrect


v1.0.5 - 2018-07-24
-------------------

+ Fixed issue causing question type defaults to be applied to existing questions. Fixes issue preventing settings like "Correct Answer" for Fill in the Blank questions from remaining enabled after being initially enabled.
+ Added RTL stylesheets


v1.0.4 - 2018-04-18
-------------------

+ Update asset dependencies for essays
+ Fix Javascript l10n issue preventing certain strings from being translated properly


v1.0.3 - 2018-04-02
-------------------

+ Added translation on strings output by Javascript


v1.0.2 - 2018-03-13
-------------------

+ Improved shuffling methods so reorder question choices will never be presented in their original order.
+ Improved the display of fill in the blank question results


v1.0.1 - 2018-02-13
-------------------

+ Added UI for Upload question on quiz review tables.
+ Fixed width of Fill in the Blank tooltip long blank button
+ Fixed spelling on tooltip for fill in the blank settings
+ Fixed typo on scale question type settings. Both min & max scale label settings said "minimum"
+ Only enqueue builder-related scripts on the builder screen


v1.0.0 - 2018-02-01
-------------------

+ Initial Public Release
