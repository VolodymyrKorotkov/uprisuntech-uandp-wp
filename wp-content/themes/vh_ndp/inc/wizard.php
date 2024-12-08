<?php
/**
 * Wizard template
 */

if (!current_user_can('install_plugins') ) return;
?>

<div class="wizard-container">
    <h2><?= get_admin_page_title() ?></h2>

    <div class="buttons-wrapper">
        <button class="js-add-filter btn"><?php _e('Add', 'ndp'); ?></button>
    </div>

    <div class="wizard-wrapper">
        <?php
        global $wpdb;
        $tableName = $wpdb->prefix . 'wizard_filter';
        $questions = $wpdb->get_results("SELECT * FROM {$tableName}", ARRAY_A);
        $my_current_lang = apply_filters( 'wpml_current_language', 'uk' );
        ?>
        <table class="wizard-table" data-lang="<?php echo $my_current_lang; ?>">
            <thead>
            <tr>
                <th><?php _e('Wizard filter', 'ndp'); ?></th>
                <th><?php _e('Wizard matches ' .$my_current_lang, 'ndp'); ?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $i = 0;
            do { ?>
                <?php
                $id = '';
                $question = '';
                $category = '';
                $filters = [];
                $question_uk = '';
                $question_en = '';
                $question_de = '';
                if (!empty($questions[$i])) {
                    $id = $questions[$i]['id'] ?? '';
                    $question_uk = $questions[$i]['question_uk'] ?? '';
                    $question_en = $questions[$i]['question_en'] ?? '';
                    $question_de = $questions[$i]['question_de'] ?? '';
                    $category = (int)$questions[$i]['category'] ?? 1;
                    $filters = unserialize($questions[$i]['filters_'.$my_current_lang]) ?? [];
                    $filters = $filters? $filters : [];
                }
                ?>
                <tr class="tr-wizard" data-id="<?php echo $id; ?>">
                    <td class="td-question">
                        <div class="table-section">
                            <p <?php if ($my_current_lang == 'uk') echo 'style="font-weight: bold"'; ?>><?php _e('Question uk', 'ndp'); ?></p>
                            <input type="text" class="question question_uk" value="<?php echo $question_uk; ?>">
                        </div>
                        <div class="table-section">
                            <p <?php if ($my_current_lang == 'en') echo 'style="font-weight: bold"'; ?>><?php _e('Question en', 'ndp'); ?></p>
                            <input type="text" class="question question_en" value="<?php echo $question_en; ?>">
                        </div>
                        <div class="table-section">
                            <p <?php if ($my_current_lang == 'de') echo 'style="font-weight: bold"'; ?>><?php _e('Question de', 'ndp'); ?></p>
                            <input type="text" class="question question_de" value="<?php echo $question_de; ?>" title="Не обязательное поле">
                        </div>
                        <div class="table-section">
                            <p><?php _e('Column (category)', 'ndp'); ?></p>
                            <select class="category">
                                <option value="1" <?php if ($category==1) echo 'selected'; ?>><?php _e('What are you doing?', 'ndp') ?></option>
                                <option value="2" <?php if ($category==2) echo 'selected'; ?>><?php _e('What do you want to do?', 'ndp') ?></option>
                                <option value="3" <?php if ($category==3) echo 'selected'; ?>><?php _e('In what field?', 'ndp') ?></option>
                            </select>
                        </div>
                    </td>
                    <td class="js-match-block">
                    <?php
                    foreach ((array)$filters as $type => $filtersArray) { ?>
                        <?php foreach ($filtersArray as $filter) { ?>
                        <span class="filter-item filter-item-match" data-input-type="<?php echo $type; ?>" data-value="<?php echo $filter['value']; ?>"><?php _e($filter['name']); ?></span>
                        <?php } ?>
                    <?php } ?>
                    </td>
                    <td class="td-buttons">
                        <button class="js-remove-question btn"><?php _e('Remove row', 'ndp'); ?></button>
                        <button class="js-remove-matches btn"><?php _e('Remove matches', 'ndp'); ?></button>
                    </td>
                </tr>
            <?php
                $i++;
            } while ($i < count($questions));
            ?>
            </tbody>
        </table>

        <div class="buttons-wrapper">
            <button class="js-save-wizard btn"><?php _e('Save', 'ndp'); ?></button>
        </div>

        <?php
        get_template_part( 'template-parts/wizard');
        ?>
    </div>
</div>
<!--<div style="height: 1000px">footer</div>-->




