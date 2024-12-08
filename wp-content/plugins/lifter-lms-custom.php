<?php
/**
 * Plugin Name: Добавление Survey
 * Description: Добавляет Survey в функционал Lifter
 * Version: 1.0
 */

// Функция для добавления новых настроек
function add_custom_lifterlms_settings( $settings ) {
    // Новый раздел настроек для Catalog Survey
    $catalog_survey_settings = array(
        array(
            'class' => 'top',
            'id'    => 'catalog_survey_options',
            'type'  => 'sectionstart',
        ),
        array(
            'id'    => 'catalog_survey_options_title',
            'title' => __( 'Catalog Survey Settings', 'lifterlms' ),
            'type'  => 'title',
        ),
        // Параметр для Catalog Survey (можете настроить в соответствии с вашими нуждами)
        array(
            'class'             => 'llms-select2-post',
            'custom_attributes' => array(
                'data-allow-clear' => true,
                'data-post-type'   => 'page',
                'data-placeholder' => __( 'Select a page', 'lifterlms' ),
            ),
            'desc'              => __( 'Choose a page for the Catalog Survey.', 'lifterlms' ),
            'id'                => 'lifterlms_catalog_survey_page_id',
            'options'           => llms_make_select2_post_array( get_option( 'lifterlms_catalog_survey_page_id', '' ) ),
            'title'             => __( 'Catalog Survey Page', 'lifterlms' ),
            'type'              => 'select',
        ),
        array(
            'type' => 'sectionend',
            'id'   => 'catalog_survey_options',
        ),
    );

    // Объединяем новые настройки с существующими
    return array_merge( $settings, $catalog_survey_settings );
}



// Добавляем наши настройки к фильтру LifterLMS
add_filter( 'lifterlms_course_settings', 'add_custom_lifterlms_settings', 10, 1 );
