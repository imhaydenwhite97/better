<?php
/*
Template Name: Login Page
*/

get_header();
?>

<div class="auth-container">
    <h1>Log In</h1>
    <?php wp_login_form(); ?>
</div>

<?php get_footer(); ?>
