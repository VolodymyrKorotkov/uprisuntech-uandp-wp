<div class="wizard">
    <div class="wizard__inner">
        <?php
        $filters = getCoursesFilter();
        foreach ($filters as $k => $filterArray): ?>
            <div class="wizard-section" data-type="<?php echo $filterArray['type']; ?>">
                <h3 class="wizard__section-title"><?php echo $filterArray['name']; ?></h3>
                <ul class="wizard__section-list">
                    <?php foreach ($filterArray['values'] as $key => $filter): ?>
                        <li class="">
                            <label>
                                <?php if ($filterArray['type'] == 'taxonomy'): ?>
                                    <span class="filter-item" data-input-type="<?php echo $filterArray['taxonomy']; ?>" data-value="<?php echo $filter->slug; ?>"><?php _e($filter->name); ?></span>
                                <?php elseif ($filterArray['type'] == 'meta' && is_string($filter)): ?>
                                    <span class="filter-item" data-input-type="<?php echo $filterArray['meta_key']; ?>" data-value="<?php echo $key; ?>"><?php _e($filter); ?></span>
                                <?php elseif ($filterArray['type'] == 'postType'): ?>
                                    <span class="filter-item" data-input-type="<?php echo $filter['postData']; ?>" data-value="<?php echo $filter['value']; ?>"><?php _e($filter['name']); ?></span>
                                <?php endif; ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>