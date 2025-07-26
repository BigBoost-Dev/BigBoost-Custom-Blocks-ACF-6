<?php
/**
 * Banner Section Block template.
 * Outputs optional subheading, heading, description and button.
 */
$subheading   = get_field( 'subheading' );
$heading      = get_field( 'heading' );
$description  = get_field( 'description' );
$button       = get_field( 'button' );
$button_text  = get_field( 'button_text' );
?>
<section class="hero-section position-relative" aria-labelledby="hero-heading">
    <div class="bb-container">
                <?php if ($subheading): ?>
                    <span class="sub-title"><?php echo esc_html($subheading); ?></span>
                <?php endif; ?>
                <?php if ($heading): ?>
                    <h1 id="hero-heading">
                        <?php echo esc_html($heading); ?>
                    </h1>
                <?php endif; ?>
                <?php if ($description): ?>
                    <p class="description-banner">
                       <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
                <?php if ($button && $button_text): ?>
                    <a href="<?php echo esc_url($button['url']); ?>" class="primary-button" role="button"><?php echo esc_html($button_text); ?></a>
                <?php endif; ?>
                  
    </div>
    <div class="curve-bg"></div>
</section>
