<div class="info-block__right col-12 col-md-6">
    <div class="properties">
        <h2 class="properties__title"><?php _e('Properties','ndp') ?></h2>

        <?php
        $groups = getMainProductAttributesList();
        ?>
        <?php foreach ($groups as $key => $value): ?>

            <ul class="properties-list">
                <h4 class="properties-list__title"><?php echo($key); ?></h4>
                <?php foreach ($value as $val): ?>

                    <li class="properties-list__item">
                        <span><?php echo $val[0] ?></span>
                        <strong><?php echo $val[1]; ?></strong>
                    </li>
                <?php endforeach; ?>
            </ul>

        <?php endforeach; ?>
    </div>
</div>






