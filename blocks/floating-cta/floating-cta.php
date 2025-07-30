<?php
$text = get_field('cta_text');
$url  = get_field('cta_url');
if ( $text && $url ) : ?>
<a href="<?php echo esc_url( $url ); ?>" class="mobile-cta-button d-lg-none" aria-label="<?php echo esc_attr( $text ); ?>">
    <?php echo esc_html( $text ); ?>
</a>
<?php endif; ?>
