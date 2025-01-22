<?php
/*
Template Name: Create Series
*/

// Ensure only administrators can access this page
if (!current_user_can('administrator')) {
    wp_redirect(home_url());
    exit;
}

get_header();
?>
<div class="series-creation-container">
    <form class="series-form" method="post" action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data">
        <!-- Add hidden input for action -->
        <input type="hidden" name="action" value="create_series">
        <?php wp_nonce_field('create_series_nonce', 'series_nonce'); ?>

        <div class="form-section">
            <h2>Basic Information</h2>
            <div class="form-group">
                <label for="series_title">Series Title</label>
                <input type="text" id="series_title" name="series_title" required>
            </div>
            <div class="form-group">
                <label for="series_description">Description</label>
                <textarea id="series_description" name="series_description" required></textarea>
            </div>
        </div>

        <div class="form-section">
            <h2>Investment Details</h2>
            <div class="form-group">
                <label for="investment_amount">Total Investment Amount ($)</label>
                <input type="number" id="investment_amount" name="investment_amount" min="0" step="1000" required>
            </div>
            <div class="form-group">
                <label for="minimum_investment">Minimum Investment ($)</label>
                <input type="number" id="minimum_investment" name="minimum_investment" min="0" step="100" required>
            </div>
            <div class="form-group">
                <label for="expected_roi">Expected ROI (%)</label>
                <input type="number" id="expected_roi" name="expected_roi" step="0.01" min="0" max="100" required>
            </div>
        </div>

        <div class="form-section">
            <h2>Property Details</h2>
            <div class="form-group">
                <label for="property_images">Property Images</label>
                <input type="file" id="property_images" name="property_images[]" multiple accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="property_location">Location</label>
                <input type="text" id="property_location" name="property_location" required>
            </div>
        </div>

        <button type="submit" class="submit-button">Create Series</button>
    </form>
</div>
<?php get_footer(); ?>
