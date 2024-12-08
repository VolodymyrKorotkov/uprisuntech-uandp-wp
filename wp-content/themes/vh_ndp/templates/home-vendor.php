<?php

$vendors = wp_cache_get('allVendorsWithFirst');

if (false === $vendors){
    global $wpdb;

    $sql = "
    SELECT 
        t.term_id, 
        t.name as brand_name, 
        t.slug as brand_slug, 
        tt.taxonomy, 
        tm.meta_key, 
        tm.meta_value,
        i.element_id,
        i.language_code
    FROM 
        `{$wpdb->term_taxonomy}` tt 
    INNER JOIN 
        `{$wpdb->terms}` t 
    ON 
        tt.term_id = t.term_id 
    INNER JOIN 
        `{$wpdb->termmeta}` tm 
    ON 
        tm.term_id = t.term_id 
    LEFT JOIN 
        `{$wpdb->prefix}icl_translations` i 
    ON 
        t.term_id = i.element_id 
    AND 
        i.element_type = CONCAT('tax_', tt.taxonomy)
    WHERE 
        tt.taxonomy = 'sp_smart_brand' 
    AND 
        tm.meta_key = 'sp_smart_brand_taxonomy_meta'
    AND 
        i.language_code = '{$sitepress->get_current_language()}' 
ORDER BY FIELD(t.slug,'buderus','schneider-electric','lg-electronics','bosch-home-comfort') DESC
";


    $vendors = $wpdb->get_results($sql, ARRAY_A);

    foreach ($vendors as $key => $vendor) {
        $img = unserialize($vendor['meta_value']);
        $meta = unserialize($vendor['meta_value']);
        if (!empty($meta['smart_brand_term_logo']) && !empty($meta['smart_brand_term_logo']['url'])) {
            $vendors[$key]['logo'] = $meta['smart_brand_term_logo'];
        }
    }
    wp_cache_set('allVendors', $vendors);
}
 
$outputArray = [];
$inputArray  = [];

foreach ($vendors as $item) {
  $inputArray[] = [
    'name' => $item['brand_name'], 
    'logo' => preg_replace('/^https?:\/\/[^\/]+/','', $item['logo']),
    'link' => get_term_link((int)$item['term_id'], 'sp_smart_brand')
  ];
}


for ($i = 0; $i < count($inputArray ); $i += 2) {
  $chunk = array_slice($inputArray , $i, 2);
  $outputArray[] = $chunk;
}

  $isUA = false;
  $lng_url = '';
  $language_code = '';
  $languages = icl_get_languages('skip_missing=0&orderby=code');
  if(!empty($languages)){
      foreach($languages as $l){
          if($l['active']){
              $lng_url = $l['url'];
              $language_code = $l['language_code'];
          }
      }
  }
  $isUA = $language_code == 'uk';

?>

<div class='home-vendor'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='financing-from-market-leaders'>
          <div class='home-block-header'>
            <div class='home-block-title'><?php _e('Vendors', 'ndp') ?></div>
            <a href='<?= $isUA ? '' : '/en'?>/vendors-list' class='btn_link'><?php _e('See all vendors', 'ndp') ?> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                viewBox="0 0 18 18" fill="none">
                <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD" />
              </svg></a>
          </div>
          <div class='financing-from-market-leaders-items'>
            <div class='owl-carousel' id="vendors">
              <?php foreach ($outputArray as $vendor) {?>

                <div class='financing-from-market-leaders-item'>
                  <?php if(isset($vendor[0])){ ?><a href='<?=$vendor[0]['link']?>' class='financing-from-market-leaders-item-vendor'>
                    <div class='financing-from-market-leaders-item-vendor-block'>
                      <div class='financing-from-market-leaders-item-vendor-block-image'>
                        <img src='<?=$vendor[0]['logo']['url']?>' />
                      </div>
                      <div class='financing-from-market-leaders-item-vendor-text'><?=$vendor[0]['name']?></div>
                    </div>
                  </a>
                  <?php } ?>
                  <?php if(isset($vendor[1])){ ?><a href='<?=$vendor[1]['link']?>' class='financing-from-market-leaders-item-vendor'>
                    <div class='financing-from-market-leaders-item-vendor-block'>
                      <div class='financing-from-market-leaders-item-vendor-block-image'>
                       <?php if (is_array($vendor[1]) && isset($vendor[1]['logo']) && isset($vendor[1]['logo']['url'])) {
                           // Now it's safe to use $vendor[1]['logo']['url']
                           echo "<img src='{$vendor[1]['logo']['url']}' />";
                       }
                       ?>
                      </div>
                      <div class='financing-from-market-leaders-item-vendor-text'><?=$vendor[1]['name']?></div>
                    </div>
                  </a>
                  <?php } ?>
                </div>
              <?php }?>
            </div>
            <div class="vendors__slider__navigation">
              <div class="vendors__slider__navigation__dots"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
