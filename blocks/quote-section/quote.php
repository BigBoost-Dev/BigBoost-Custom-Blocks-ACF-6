<?php
$quote = get_field('field_quote');
$author = get_field('field_author');
$banner_image = get_field('banner_image');
?>
<section class="quotes-section">
    <div class="bb-container">
		<div class="row image-quote-block">
			<div class="col-12 col-md-6 image-blocks">
				<div class="hero-quote-img">
                        <img src="<?php echo esc_url($banner_image['url']); ?>" alt="<?php echo esc_attr($banner_image['alt']); ?>">
                    </div>
			</div>
			<div class="col-12 col-md-6 quotes-blocks">
				<div>
                                         <p class="quote-line">
                                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../../assets/images/start.png" alt="start-quotes">
                                                <?php echo esc_html($quote); ?>
                                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../../assets/images/end.png" alt="end-quotes">
                                         </p>
					<span><?php echo esc_html($author); ?></span>
				</div>
			</div>
		</div>
       
    </div>
</section>