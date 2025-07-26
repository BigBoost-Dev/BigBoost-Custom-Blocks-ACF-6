<?php
$faq_title = get_field('faq_title');
$faq_description = get_field('faq_description');
$faq_items = get_field('faq_items');
?>

        <section class="bb-faq-section">
            <div class="container">
                <span class="d-none d-lg-block"><?php echo esc_html($faq_title); ?></span>
                <span class="d-block d-lg-none text-center"><?php echo esc_html($faq_title); ?></span>
                <div class="bb-faq-title">
					  <?php if ($faq_items): ?>
                <?php foreach ($faq_items as $index => $faq): ?>
                    <div>
                        <div class="d-flex justify-content-between align-items-lg-start align-items-center bb-downarrow">
                           <?php echo wp_kses_post($faq['question']); ?>
                            <div>
                                 <a href="">
                                    <img class="d-none d-lg-block" src="<?php echo plugin_dir_url(__FILE__); ?>../../assets/images/downarrow.png" alt="">
                                    <img class="d-block d-lg-none" src="<?php echo plugin_dir_url(__FILE__); ?>../../assets/images/add.png" alt="">
                                </a>
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