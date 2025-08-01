<?php
$text = get_field('cta_text');
$url  = get_field('cta_url');
if ( $text && $url ) : ?>
<div class="mobile-cta-container d-lg-none">
    <a href="<?php echo esc_url( $url ); ?>" class="mobile-cta-button" aria-label="<?php echo esc_attr( $text ); ?>">
        <?php echo esc_html( $text ); ?>
    </a>
</div>
<?php endif; ?>
