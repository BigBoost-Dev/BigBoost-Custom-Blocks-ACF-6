<?php
  $quote        = get_field('field_quote');
  $author       = get_field('field_author');
  $banner_image = get_field('banner_image');
?>
<section class="quotes-section">
  <div class="bb-container">
    <div class="row image-quote-block">
      <div class="col-12 col-md-6 image-blocks">
        <div class="hero-quote-img">
          <img 
            src="<?php echo esc_url($banner_image['url']); ?>" 
            alt="<?php echo esc_attr($banner_image['alt']); ?>"
          >
        </div>
      </div>
      <div class="col-12 col-md-6 quotes-blocks">
        <blockquote class="quote-line">
          <p class="quote-desktop"><?php echo esc_html($quote); ?></p>
          <p class="quote-mobile"><?php echo esc_html($quote); ?></p>
        </blockquote>
        <cite class="quote-author">
         <?php echo esc_html($author); ?>
        </cite>
      </div>
    </div>
  </div>
</section>
