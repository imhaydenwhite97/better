<?php get_header(); ?>

<div class="series-archive-container">
    <header class="archive-header">
        <h1>Investment Opportunities</h1>
    </header>

    <div class="series-grid">
        <?php
        $args = array(
            'post_type' => 'investment_series',
            'posts_per_page' => -1
        );
        
        $series_query = new WP_Query($args);
        
        if ($series_query->have_posts()) :
            while ($series_query->have_posts()) : $series_query->the_post();
                ?>
                <div class="series-card">
                    <div class="series-image">
                        <?php 
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('large');
                        }
                        ?>
                    </div>
                    <div class="series-content">
                        <h2><?php the_title(); ?></h2>
                        <div class="series-meta">
                            <div class="meta-item">
                                <span class="label">Investment</span>
                                <span class="value">$<?php echo number_format(get_post_meta(get_the_ID(), 'investment_amount', true)); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="label">Minimum</span>
                                <span class="value">$<?php echo number_format(get_post_meta(get_the_ID(), 'minimum_investment', true)); ?></span>
                            </div>
                            <div class="meta-item">
                                <span class="label">ROI</span>
                                <span class="value"><?php echo get_post_meta(get_the_ID(), 'expected_roi', true); ?>%</span>
                            </div>
                        </div>
                        <div class="series-location">
                            <span class="icon">📍</span>
                            <?php echo get_post_meta(get_the_ID(), 'property_location', true); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="view-opportunity">View Opportunity</a>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </div>
</div>

<?php get_footer(); ?>
