    <footer class="site-footer">
        <div class="footer-content">
            <?php
            if (is_active_sidebar('footer-widgets')) {
                dynamic_sidebar('footer-widgets');
            }
            ?>
        </div>
    </footer>

    <?php wp_footer(); ?>
</body>
</html>
