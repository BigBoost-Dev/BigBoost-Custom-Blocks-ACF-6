<?php
$images = get_field('gallery_images');
?>

<div class="custom-gallery">
    <?php if ($images): ?>
        <?php foreach ($images as $image): ?>
            <div class="gallery-item">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
