<?php
/**
 * Template part for displaying custom posts (news,casts)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NDP
 */


	if (empty($args)) return;

	$post_type = $args['post_type'] ?? '';
	$counterPost = $args['counterPost'] ?? '';
	$category_slug = $args['category_slug'] ?? '';
	$tag_slug = $args['tag_slug'] ?? '';
	$custom_sticky = $args['custom_sticky'] ?? '';
	$hide_col = $args['hide_col'] ?? false;
	$isFull = $post_type === 'news' && $counterPost < 2;
?>
<?php if(!$hide_col){?><div class="col-12 <?= $isFull ? '' : 'col-sm-6 col-lg-4'?> " style='margin-bottom: 24px;'><?php } ?>
	<div class='block-post-item <?= $isFull ? 'full' : ''?>'>
		<?php if((isset($custom_sticky) && !empty($custom_sticky) && $custom_sticky !== 'off')) {?>
        <div class='block-post-item-icon'>
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
				<path d="M8.3767 15.6162L2.71985 21.273M11.6944 6.64169L10.1335 8.20258C10.0062 8.3299 9.94252 8.39357 9.86999 8.44415C9.80561 8.48905 9.73616 8.52622 9.66309 8.55488C9.58077 8.58717 9.49249 8.60482 9.31592 8.64014L5.65145 9.37303C4.69915 9.56349 4.223 9.65872 4.00024 9.90977C3.80617 10.1285 3.71755 10.4212 3.75771 10.7108C3.8038 11.0433 4.14715 11.3866 4.83387 12.0733L11.9196 19.1591C12.6063 19.8458 12.9497 20.1891 13.2821 20.2352C13.5718 20.2754 13.8645 20.1868 14.0832 19.9927C14.3342 19.7699 14.4294 19.2938 14.6199 18.3415L15.3528 14.677C15.3881 14.5005 15.4058 14.4122 15.4381 14.3298C15.4667 14.2568 15.5039 14.1873 15.5488 14.123C15.5994 14.0504 15.663 13.9868 15.7904 13.8594L17.3512 12.2985C17.4326 12.2171 17.4734 12.1764 17.5181 12.1409C17.5578 12.1093 17.5999 12.0808 17.644 12.0557C17.6936 12.0273 17.7465 12.0046 17.8523 11.9593L20.3467 10.8903C21.0744 10.5784 21.4383 10.4225 21.6035 10.1705C21.7481 9.95013 21.7998 9.68163 21.7474 9.42335C21.6875 9.12801 21.4076 8.8481 20.8478 8.28827L15.7047 3.14514C15.1448 2.58531 14.8649 2.3054 14.5696 2.24552C14.3113 2.19317 14.0428 2.24488 13.8225 2.38941C13.5705 2.55469 13.4145 2.91854 13.1027 3.64624L12.0337 6.14059C11.9883 6.24641 11.9656 6.29932 11.9373 6.34893C11.9121 6.393 11.8836 6.4351 11.852 6.47484C11.8165 6.51958 11.7758 6.56029 11.6944 6.64169Z" stroke="white" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
			</svg>
		</div> <?php } ?>
		<a href="<?php the_permalink(); ?>" class='block-post-item-img'>
			<div class='block-post-item-img-bg'></div>
			<?php
				$thumbnail_url = get_the_post_thumbnail_url();
				if ($thumbnail_url) {
				?><img src='<?= esc_url($thumbnail_url);?>' /><?php
				} else {
				?><img src='<?php bloginfo('template_url');?>/assets/img/home/no-image.jpg' /><?php
				}
			?>
		</a>
		<div class='block-post-item-content'>
			<a href='<?php the_permalink(); ?>' class='block-post-item-title'><?php the_title(); ?></a>
			<div class='block-post-item-labels'>
				<?php
						$categories = get_the_terms(get_the_ID(), $category_slug);
						if ($categories && !is_wp_error($categories) && isset($categories[0])) {
                            $category = $categories[0];
                            $link = get_category_link($category->term_id);
                            echo '<a href="'. $link .'" class="block-post-item-label active">'. $category->name .'</a>';
						}
						$tags = get_the_terms(get_the_ID(), $tag_slug);
						if ($tags && !is_wp_error($tags)) {
                            foreach ($tags as $tag) {
                                echo '<a href="'. get_post_type_archive_link($post_type) .'?' .$tag_slug . '[0]='. $tag->slug .'" class="block-post-item-label">'. $tag->name .'</a>';
                            }
						}
				?>
			</div>
			<div class="block-post-item-desc">
					<?= custom_get_the_excerpt(get_post()); ?>
			</div>
			<div class="block-post-item-h"></div>
			<div class='block-post-item-time'>
					<?php
                        $post_time = get_the_time('U');
//                        $post_time = get_the_modified_time('U');
                        // echo custom_time_ago($post_time);
                        echo date('d.m.y, H:i', $post_time)
					?>
					<!-- <?php
							$post_content = get_the_content();
							$reading_time = approximate_reading_time($post_content);
							echo $reading_time . get_minute_ending_uk($reading_time); //  5 min read
					?> -->
			</div>
		</div>
	</div>
<?php if(!$hide_col){?></div><?php } ?>
