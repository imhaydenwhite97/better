<?php 
$menu_content = better_get_mega_menu_content($current_menu_item);
?>
<div class="featured-section">
    <div class="featured-image">
        <img src="<?php echo esc_url($menu_content['image']); ?>" alt="Featured">
    </div>
    <div class="featured-text">
        <?php echo wp_kses_post($menu_content['text']); ?>
    </div>
    <a href="<?php echo esc_url($menu_content['cta_url']); ?>" class="cta-button">
        <?php echo esc_html($menu_content['cta_text']); ?>
    </a>
</div>
