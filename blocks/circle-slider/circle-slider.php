<?php
$section_title = get_field('field_circle_slider_title');

$section_desc = get_field('field_circle_slider_desc');
$section_tag = get_field('field_circle_slider_tag');
$section_items = get_field('field_circle_slider_items');
?>
<?php if ($section_items) : ?>
    <section class="circle-slider d-none d-lg-block">
        <div class="container">
            <div class="row">
                <!-- Left Content -->
                <div class="col-12 col-lg-5">
                    <div class="slider-content">
                        <?php if ($section_tag) : ?>
                            <span class="border-view"><?php echo esc_html($section_tag); ?></span>
                        <?php endif; ?>

                        <?php if ($section_title) : ?>
                            <h2><?php echo esc_html($section_title); ?></h2>
                        <?php endif; ?>

                        <div class="slider-context">
                            <?php foreach ($section_items as $index => $item) : ?>
                                <div>
                                    <a href="#" class="d-flex align-items-center slider-actions">
                                        <div>
                                            <div class="cirle-outline">
                                                <span><?php echo esc_html($item['step_number']); ?></span>
                                            </div>
                                        </div>
                                        <h3><?php echo esc_html($item['step_title']); ?></h3>
                                    </a>
                                    <div class="description" <?php echo ($index === 0) ? 'style="display: block;"' : ''; ?>>
                                        <p><?php echo esc_html($item['step_description']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Right Images -->
                <div class="col-12 col-lg-7">
                    <div class="slider-images">
                        <?php foreach ($section_items as $index => $item) : ?>
                            <div class="slider-item <?php echo ($index === 0) ? 'active' : 'next'; ?>">
                                <div class="big-img">
                                    <?php if (!empty($item['main_image'])) : ?>
                                        <img src="<?php echo esc_url($item['main_image']['url']); ?>" alt="">
                                    <?php endif; ?>

                                    <?php if (!empty($item['ui_image'])) : ?>
                                        <div class="ui-img">
                                            <img src="<?php echo esc_url($item['ui_image']['url']); ?>" alt="">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php if ($section_items) : ?>
	    <section class="circle-slider d-block d-lg-none">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="slider-content">
                            <!-- <span class="border-view">Best practices</span> -->
                            <h2> <?php echo esc_html($section_title); ?> </h2>
                           <div class="slider-context">
								<?php foreach ($section_items as $index => $item) : ?>
                                <div>
                                    <a href="" class="d-flex align-items-center toggle-slider mb-3">
                                        <div>
                                            <div class="cirle-outline">
                                                <span> <?php echo esc_html($item['step_number']); ?> </span>
                                            </div>
                                        </div>
                                        <h3><?php echo esc_html($item['step_title']); ?></h3>
                                    </a>
                                    <div class="description">
                                        <p>
                                           <?php echo esc_html($item['step_description']); ?>
                                        </p>
                                        <img src="<?php echo esc_url($item['ui_image']['url']); ?>" alt="">
                                    </div>
                                </div>
								<?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
<?php endif; ?>