<?php
$faq_title = get_field('faq_title');
$faq_description = get_field('faq_description');
$faq_items = get_field('faq_items');
?>

        <section class="bb-faq-section">
            <div class="bb-container">
                <span class="d-none d-lg-block"><?php echo esc_html($faq_title); ?></span>
                <span class="d-block d-lg-none text-center"><?php echo esc_html($faq_title); ?></span>
                <div class="bb-faq-title">
					  <?php if ($faq_items): ?>
                <?php foreach ($faq_items as $index => $faq): ?>
                    <div>
                        <div class="d-flex justify-content-between align-items-lg-start align-items-center bb-downarrow">
                           <?php echo wp_kses_post($faq['question']); ?>
                            <div>
                                <button type="button" class="bb-faq-toggle">
                                    <img class="bb-faq-icon" src="<?php echo plugin_dir_url(__FILE__); ?>../../assets/images/add.png" data-add="<?php echo plugin_dir_url(__FILE__); ?>../../assets/images/add.png" data-subtract="<?php echo plugin_dir_url(__FILE__); ?>../../assets/images/subtract.png" alt="Toggle answer">
                                </button>
                            </div>
                        </div>
                        <div class="bb-faq-description">
                            <p>
                               <?php echo wp_kses_post($faq['answer']); ?>
                            </p>
                        </div>
                    </div>
					<?php endforeach; ?>
            <?php endif; ?>
                </div>
            </div>
        </section>