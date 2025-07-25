<?php
$title = get_field('cta_title');
$description = get_field('field_cta_description');
$button = get_field('cta_button');
?>
<section class="survey">
            <div class="container">
                <h2><?php echo esc_html($title); ?></h2>
                <p><?php echo esc_html($description); ?></p>
                <a href="<?php echo esc_url($button['url']); ?>"><?php echo esc_html($button['title']); ?></a>
            </div>
</section>