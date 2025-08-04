<?php
$subtitle    = get_field('giving_funds_subtitle');
$title       = get_field('giving_funds_title');
$description = get_field('giving_funds_description');
$button      = get_field('giving_funds_button');
$image       = get_field('giving_funds_image');
?>
<section class="giving-funds-cta">
    <div class="bb-container">
        <div class="giving-funds-cta__inner">
            <div class="giving-funds-cta__text">
                <?php if ( $subtitle ) : ?>
                    <span class="giving-funds-cta__subtitle"><?php echo esc_html( $subtitle ); ?></span>
                <?php endif; ?>
                <?php if ( $title ) : ?>
                    <h2 class="giving-funds-cta__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>
                <?php if ( $description ) : ?>
                    <p class="giving-funds-cta__description"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>
                <?php if ( $button ) : ?>
                    <a class="giving-funds-cta__button" href="<?php echo esc_url( $button['url'] ); ?>"<?php if ( $button['target'] ) : ?> target="<?php echo esc_attr( $button['target'] ); ?>"<?php endif; ?>><?php echo esc_html( $button['title'] ); ?></a>
                <?php endif; ?>
            </div>
            <?php if ( $image ) : ?>
                <div class="giving-funds-cta__image">
                    <img src="<?php echo esc_url( $image['url'] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
