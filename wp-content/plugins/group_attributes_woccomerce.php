<?php
/**
 * Plugin Name: Attribute Group Field for WooCommerce with WPML Support
 * Description: Добавляет текстовое поле "Группа атрибута" в раздел добавления и редактирования атрибутов WooCommerce с поддержкой WPML.
 * Version: 1.0
 * Author: ChatGPT
 */

// Добавление поля на страницу создания/редактирования атрибутов
function custom_attribute_group_field($term) {
    $value = get_term_meta($term->term_id, 'attribute_group', true);

    // Получение переведенной строки с WPML
    if (function_exists('icl_t')) {
        $value = icl_t('woocommerce', 'attribute_group_' . $term->term_id, $value);
    }

    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="attribute_group"><?php _e('Группа атрибута', 'woocommerce'); ?></label></th>
        <td>
            <input type="text" id="attribute_group" name="attribute_group" value="<?php echo esc_attr($value); ?>">
        </td>
    </tr>
    <?php
}
function save_custom_attribute_group_field($term_id) {

    print_r('test');
    if (isset($_POST['attribute_group'])) {
        $value = sanitize_text_field($_POST['attribute_group']);

        // Если значение уже существует, обновляем его. В противном случае добавляем новое значение.
        if (get_term_meta($term_id, 'attribute_group', true)) {
            update_term_meta($term_id, 'attribute_group', $value);
        } else {
            add_term_meta($term_id, 'attribute_group', $value);
        }

        // Регистрация строки для перевода в WPML
        if (function_exists('icl_register_string')) {
            icl_register_string('woocommerce', 'attribute_group_' . $term_id, $value);
        }
    }
}
add_action('woocommerce_after_add_attribute_fields', 'custom_attribute_group_field');
add_action('woocommerce_after_edit_attribute_fields', 'custom_attribute_group_field');
add_action('add_term_meta', 'save_custom_attribute_group_field', 10, 2);
add_action('update_term_meta', 'save_custom_attribute_group_field', 10, 2);
// Сохранение значения поля



?>
