<?php get_header(); ?>

<div class="single-series-container">
    <div class="series-hero">
        <div class="hero-content">
            <h1><?php the_title(); ?></h1>
            <div class="location">
                <span class="icon">📍</span>
                <?php echo get_post_meta(get_the_ID(), 'property_location', true); ?>
            </div>
        </div>
    </div>

    <div class="series-content">
        <div class="main-content">
            <div class="gallery">
                <?php
                $images = get_attached_media('image');
                foreach($images as $image) {
                    echo wp_get_attachment_image($image->ID, 'large');
                }
                ?>
            </div>
            
            <div class="description">
                <h2>About This Opportunity</h2>
                <?php the_content(); ?>
            </div>
        </div>

        <aside class="investment-sidebar">
            <div class="investment-card">
                <div class="investment-details">
                    <div class="detail-item">
                        <span class="label">Total Investment</span>
                        <span class="value">$<?php echo number_format(get_post_meta(get_the_ID(), 'investment_amount', true)); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Minimum Investment</span>
                        <span class="value">$<?php echo number_format(get_post_meta(get_the_ID(), 'minimum_investment', true)); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Expected ROI</span>
                        <span class="value"><?php echo get_post_meta(get_the_ID(), 'expected_roi', true); ?>%</span>
                    </div>
                </div>
                <button class="invest-button">Invest Now</button>
            </div>
        </aside>
    </div>
</div>

<?php get_footer(); ?>
