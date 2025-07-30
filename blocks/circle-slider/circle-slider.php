<?php
$section_title = get_field('field_circle_slider_title');

$section_desc = get_field('field_circle_slider_desc');
$section_tag = get_field('field_circle_slider_tag');
$section_items = get_field('field_circle_slider_items');
?>
<?php if ($section_items) : ?>
    <section class="bb-circle-slider d-none d-lg-block">
        <div class="bb-container">
            <div class="row">
                <!-- Left Content -->
                <div class="col-12 col-lg-5">
                    <div class="bb-slider-content">
                        <?php if ($section_tag) : ?>
                            <span class="bb-border-view"><?php echo esc_html($section_tag); ?></span>
                        <?php endif; ?>

                        <?php if ($section_title) : ?>
                            <h2><?php echo esc_html($section_title); ?></h2>
                        <?php endif; ?>

                        <div class="bb-slider-context">
                            <?php foreach ($section_items as $index => $item) : ?>
                                <div>

                                    <button type="button" class="d-flex align-items-center bb-slider-actions">

                                        <div>
                                            <div class="bb-circle-outline">
                                                <svg class="progress-ring" viewBox="0 0 50 50">
                                                    <circle class="progress-ring__circle" cx="25" cy="25" r="23"></circle>
                                                </svg>
                                                <span><?php echo esc_html($item['step_number']); ?></span>
                                            </div>
                                        </div>
                                        <h3><?php echo esc_html($item['step_title']); ?></h3>

                                    </button>

                                    <div class="bb-slider-description" <?php echo ($index === 0) ? 'style="display: block;"' : ''; ?>>
                                        <p><?php echo esc_html($item['step_description']); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Right Images -->
                <div class="col-12 col-lg-7">
                    <div class="bb-slider-images">
                        <?php foreach ($section_items as $index => $item) : ?>
                            <div class="bb-slider-item <?php echo ($index === 0) ? 'active' : 'next'; ?>">
                                <div class="bb-big-img">
                                    <?php if (!empty($item['main_image'])) : ?>
                                        <img src="<?php echo esc_url($item['main_image']['url']); ?>" alt="<?php echo esc_attr($item['main_image']['alt'] ?: $item['step_title']); ?>">
                                    <?php endif; ?>

                                    <?php if (!empty($item['ui_image'])) : ?>
                                        <div class="bb-ui-img">

                                            <img src="<?php echo esc_url($item['ui_image']['url']); ?>" alt="<?php echo esc_attr($item['ui_image']['alt'] ?: $item['step_title']); ?>">
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
	    <section class="bb-circle-slider d-block d-lg-none">
            <div class="bb-container">
                <div class="row">
                    <div class="col-12">
                        <div class="bb-slider-content">
                            <!-- <span class="bb-border-view">Best practices</span> -->
                            <h2> <?php echo esc_html($section_title); ?> </h2>
                           <div class="bb-slider-context">
								<?php foreach ($section_items as $index => $item) : ?>
                                <div>

                                    <button type="button" class="d-flex align-items-center bb-toggle-slider mb-3">
                                        <div>
                                            <div class="bb-circle-outline">
                                                <svg class="progress-ring" viewBox="0 0 50 50">
                                                    <circle class="progress-ring__circle" cx="25" cy="25" r="23"></circle>
                                                </svg>
                                                <span> <?php echo esc_html($item['step_number']); ?> </span>
                                            </div>
                                        </div>
                                        <h3><?php echo esc_html($item['step_title']); ?></h3>

                                    </button>

                                    <div class="bb-slider-description">
                                        <p>
                                           <?php echo esc_html($item['step_description']); ?>
                                        </p>
                                        <?php 
                                            $mobileMain = !empty($item['mobile_main_image']) ? $item['mobile_main_image'] : $item['main_image'];
                                            $mobileUI = !empty($item['mobile_ui_image']) ? $item['mobile_ui_image'] : $item['ui_image'];
                                        ?>
                                        <?php if (!empty($mobileMain)) : ?>
                                            <img src="<?php echo esc_url($mobileMain['url']); ?>" alt="<?php echo esc_attr($mobileMain['alt'] ?: $item['step_title']); ?>">
                                        <?php endif; ?>
                                        <?php if (!empty($mobileUI)) : ?>
                                            <img src="<?php echo esc_url($mobileUI['url']); ?>" alt="<?php echo esc_attr($mobileUI['alt'] ?: $item['step_title']); ?>">
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