<?php
/**
 * Upload, edit, view Certificate
 */

$typePage = 'upload';
$certID = '';
if (isset($_GET['edit']) && isset($_GET['id'])) {
    $typePage = 'edit';
    $certID = (int)$_GET['id'];
} elseif (isset($_GET['view']) && isset($_GET['id'])) {
    $typePage = 'view';
    $certID = (int)$_GET['id'];
}
$certData = [];
$cert_name = '';
$organizationName = '';
$dateObtaining = '';
$validityDate = '';
$indefinite = '';
$courseTitle = '';
$courseAuthor = '';
$link_to_course = '';
$pdf_url = '';
if (!empty($certID)) {
    $certData = get_post_meta($certID, 'custom_certificate_data', true);

    if ($certData && !empty($certData) && is_array($certData)) {
        $cert_name = !empty($certData['cert_name'])? $certData['cert_name'] : '';
        $organizationName = !empty($certData['organizationName'])? $certData['organizationName'] : '';
        $dateObtaining = !empty($certData['dateObtaining'])? $certData['dateObtaining'] : '';
        $validityDate = !empty($certData['validityDate'])? $certData['validityDate'] : '';
        $indefinite = !empty($certData['indefinite'])? $certData['indefinite'] : '';
        $courseTitle = !empty($certData['courseTitle'])? $certData['courseTitle'] : '';
        $courseAuthor = !empty($certData['courseAuthor'])? $certData['courseAuthor'] : '';
        $link_to_course = !empty($certData['link_to_course'])? $certData['link_to_course'] : '';
        $pdf_url = !empty($certData['pdf_url'])? $certData['pdf_url'] : '';
    }
}

$errors = [];
if (isset($_SESSION) && isset($_SESSION['cert_errors']) && !empty($_SESSION['cert_errors'])) {
    $errors = $_SESSION['cert_errors'];
    unset($_SESSION['cert_errors']);
}
$current_lang = apply_filters( 'wpml_current_language', 'uk' );

$inputDisabled = false;
if ($typePage == 'view') {
    $inputDisabled = true;
}

$title = 'Upload Certificate';
if (isset($_GET['edit'])) {
    $title = 'Edit Certificate';
} elseif (isset($_GET['view'])) {
    $title = 'View Certificate';
}
?>

<section class="upload-certificate <?php if ($inputDisabled) echo 'view'; ?>" data-lang="<?php echo $current_lang; ?>">
    <div class="container">
        <nav class="breadcrumb">
            <?php yoast_breadcrumb(); ?>
        </nav>
        <div class="upload-certificate__title">
            <a href="<?php echo get_permalink( llms_get_page_id( 'myaccount' ) ); ?>my-certificates">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M15.7049 7.41L14.2949 6L8.29492 12L14.2949 18L15.7049 16.59L11.1249 12L15.7049 7.41Z" fill="#2A59BD"/>
                </svg>
            </a>
            <h1><?php _e($title, 'ndp'); ?></h1>
        </div>
        <form method="post" novalidate class="upload-certificate__form" data-form="<?php echo $typePage; ?>" data-id="<?php echo $certID; ?>" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>"/>
            <div class="upload-certificate__form-wrapper">
                <div class="upload-certificate__form-upload">
                    <h2 class="upload-certificate__form-upload__title"><?php _e('Uploading certificate file', 'ndp'); ?>*</h2>
                    <div class="upload-certificate__form-upload__block">
                        <div class="upload-certificate__form-upload__main">
<!--                            <input type="file" name="fileToUpload" id="fileToUpload" class="hidden">-->
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/upload-icon.png" alt="upload-icon">
                            <p class="upload-certificate__form-upload__text"><?php _e('<strong>Click to upload</strong>or drag and drop', 'ndp'); ?></p>
                            <p class="upload-certificate__form-upload__condition"><?php _e('PDF only (max. 25Mb)', 'ndp'); ?></p>
                        </div>
                    </div>
                    <span class="upload-certificate__form-upload__error"><?php _e('Upload failed, please try again', 'ndp'); ?></span>
                </div>
                <div class="mdc-text-field mdc-text-field--outlined custom-input__field ">
                    <input type="text" id="certificateName" name="cert_name" value="<?php echo $cert_name; ?>" class="mdc-text-field__input required__field" aria-controls="certificateName" <?php if ($inputDisabled) echo 'disabled'; ?> required>
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="certificateName" class="mdc-floating-label"><?php _e('Certificate name', 'ndp'); ?></label>
                        </div>
                        <div class="mdc-notched-outline__trailing">
                            <i class="material-icons error-icon" aria-hidden="true">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/error.svg" alt="upload-icon">
                            </i>
                        </div>
                    </div>
                </div>
                <span class="error-message"><?php _e('Required field', 'ndp'); ?></span>
                <div class="mdc-text-field mdc-text-field--outlined custom-input__field">
                    <input type="text" id="organizationName" name="organizationName" value="<?php echo $organizationName; ?>" class="mdc-text-field__input required__field" aria-controls="organizationName" <?php if ($inputDisabled) echo 'disabled'; ?> required>
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="organizationName" class="mdc-floating-label"><?php _e('Organization granted certificate', 'ndp'); ?></label>
                        </div>
                        <div class="mdc-notched-outline__trailing">
                            <i class="material-icons error-icon" aria-hidden="true">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/error.svg" alt="upload-icon">
                            </i>
                        </div>
                    </div>
                </div>
                <span class="error-message"><?php _e('Required field', 'ndp'); ?></span>
                <div class="upload-certificate__form-date">
                    <div class="form-date__wrapper">
                        <div class="mdc-text-field mdc-text-field--outlined custom-input__field" id="upload-certificate__form-dateObtaining">
                            <input type="text" id="dateObtaining" name="dateObtaining" value="<?php echo $dateObtaining; ?>" class="mdc-text-field__input required__field" aria-controls="dateObtaining" <?php if ($inputDisabled) echo 'disabled'; ?> required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19 4H18V2H16V4H8V2H6V4H5C3.89 4 3 4.9 3 6V20C3 21.1 3.89 22 5 22H19C20.1 22 21 21.1 21 20V6C21 4.9 20.1 4 19 4ZM19 20H5V9H19V20ZM6.5 13C6.5 11.62 7.62 10.5 9 10.5C10.38 10.5 11.5 11.62 11.5 13C11.5 14.38 10.38 15.5 9 15.5C7.62 15.5 6.5 14.38 6.5 13Z" fill="#919094"/>
                            </svg>
                            <div class="mdc-notched-outline">
                                <div class="mdc-notched-outline__leading"></div>
                                <div class="mdc-notched-outline__notch">
                                    <label for="dateObtaining" class="mdc-floating-label"><?php _e('Date of obtaining', 'ndp'); ?></label>
                                </div>
                                <div class="mdc-notched-outline__trailing">
                                    <i class="material-icons error-icon" aria-hidden="true">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/error.svg" alt="upload-icon">
                                    </i>
                                </div>
                            </div>
                        </div>
                        <span class="error-message error-message-date"><?php _e('Required field', 'ndp'); ?></span>
                    </div>
                    <div class="form-date__wrapper">
                        <div class="mdc-text-field mdc-text-field--outlined custom-input__field" id="upload-certificate__form-validityDate">
                            <input type="text" id="validityDate" name="validityDate" value="<?php echo $validityDate; ?>" class="mdc-text-field__input required__field" aria-controls="validityDate" <?php if ($inputDisabled) echo 'disabled'; ?> required>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19 4H18V2H16V4H8V2H6V4H5C3.89 4 3 4.9 3 6V20C3 21.1 3.89 22 5 22H19C20.1 22 21 21.1 21 20V6C21 4.9 20.1 4 19 4ZM19 20H5V9H19V20ZM6.5 13C6.5 11.62 7.62 10.5 9 10.5C10.38 10.5 11.5 11.62 11.5 13C11.5 14.38 10.38 15.5 9 15.5C7.62 15.5 6.5 14.38 6.5 13Z" fill="#919094"/>
                            </svg>
                            <div class="mdc-notched-outline">
                                <div class="mdc-notched-outline__leading"></div>
                                <div class="mdc-notched-outline__notch">
                                    <label for="validityDate" class="mdc-floating-label"><?php _e('Validity date', 'ndp'); ?></label>
                                </div>
                                <div class="mdc-notched-outline__trailing">
                                    <i class="material-icons error-icon" aria-hidden="true">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/error.svg" alt="upload-icon">
                                    </i>
                                </div>
                            </div>
                        </div>
                        <span class="error-message error-message-date"><?php _e('Required field', 'ndp'); ?></span>
                    </div>
                    <div class="upload-certificate__form-date__checkbox">
                        <div class="mdc-form-field">
                            <div class="mdc-checkbox">
                                <input type="checkbox" class="mdc-checkbox__native-control" id="indefinite" name="indefinite" <?php if ($inputDisabled) echo 'disabled'; ?> <?php if (!empty($indefinite)) echo 'checked'; ?> />
                                <?php
                                if (!empty($indefinite)): ?>
                                    <script>
                                        $('#upload-certificate__form-dateObtaining').addClass('mdc-text-field--disabled').removeClass('custom-input__field');
                                        $('#upload-certificate__form-dateObtaining svg').css('opacity', '0.5');
                                        $('#upload-certificate__form-validityDate').addClass('mdc-text-field--disabled').removeClass('custom-input__field');
                                        $('#upload-certificate__form-validityDate svg').css('opacity', '0.5');
                                        $('#dateObtaining').removeClass('required__field')
                                            .prop('disabled', true).prop('required', false);
                                        $('#validityDate').removeClass('required__field')
                                            .prop('disabled', true).prop('required', false);
                                    </script>
                                <?php endif; ?>
                                <div class="mdc-checkbox__background">
                                    <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                                        <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                                    </svg>
                                    <div class="mdc-checkbox__mixedmark"></div>
                                </div>
                            </div>
                            <label for="indefinite"><?php _e('Indefinite', 'ndp'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="mdc-text-field mdc-text-field--outlined custom-input__field">
                    <input type="text" id="linkCourse" name="link_to_course" value="<?php echo $link_to_course; ?>" class="mdc-text-field__input required__field" aria-controls="linkCourse" <?php if ($inputDisabled) echo 'disabled'; ?> required>
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="linkCourse" class="mdc-floating-label"><?php _e('Link to course', 'ndp'); ?></label>
                        </div>
                        <div class="mdc-notched-outline__trailing">
                            <i class="material-icons error-icon" aria-hidden="true">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/error.svg" alt="upload-icon">
                            </i>
                        </div>
                    </div>
                </div>
                <span class="error-message"><?php _e('Required field', 'ndp'); ?></span>
                <div class="upload-certificate__form-info">
                    <div class="mdc-text-field mdc-text-field--outlined">
                        <input type="text" id="courseTitle" name="courseTitle" value="<?php echo $courseTitle; ?>" class="mdc-text-field__input" aria-controls="courseTitle" <?php if ($inputDisabled) echo 'disabled'; ?>>
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch">
                                <label for="courseTitle" class="mdc-floating-label"><?php _e('Course title', 'ndp'); ?></label>
                            </div>
                            <div class="mdc-notched-outline__trailing"></div>
                        </div>
                    </div>
                    <div class="mdc-text-field mdc-text-field--outlined">
                        <input type="text" id="courseAuthor" name="courseAuthor" value="<?php echo $courseAuthor; ?>" class="mdc-text-field__input" aria-controls="courseAuthor" <?php if ($inputDisabled) echo 'disabled'; ?>>
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch">
                                <label for="courseAuthor" class="mdc-floating-label"><?php _e('Course author', 'ndp'); ?></label>
                            </div>
                            <div class="mdc-notched-outline__trailing"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="upload-certificate__buttons">
                <a href="<?php echo get_permalink( llms_get_page_id( 'myaccount' ) ); ?>my-certificates" type="button" class="upload-certificate__buttons-cancel"><?php _e('Cancel', 'ndp'); ?></a>
                <?php
                $buttonText = 'Upload';
                if ($typePage == 'edit') {
                    $buttonText = 'Save';
                }
                $disabled = false;
                if (!$cert_name || !$organizationName || !$dateObtaining || !$validityDate || !$link_to_course) {
                    $disabled = true;
                }
                ?>
                <?php if ($typePage != 'view'): ?>
                <button type="submit" name="submit_certificate" class="upload-certificate__buttons-add <?php if ($disabled) echo 'upload-certificate__buttons-disabled'; ?>"><?php _e($buttonText, 'ndp'); ?></button><!-- upload-certificate__buttons-disabled при неправильному заповнені -->
                <?php endif; ?>
            </div>
            <?php wp_nonce_field( 'upload_certificate', 'upload_certificate_nonce' ); ?>
        </form>
    </div>
</section>

<?php
$translates = [
    'Replace' => __('Replace', 'ndp'),
    'file_is_too_big' => __('This file is too big', 'ndp'),
    'incorrect_format' => __('Incorrect file format', 'ndp'),
];

?>
<script>
    var translatesArray = <?php echo json_encode($translates); ?>;
    var certData = <?php echo json_encode($certData); ?>;
</script>
