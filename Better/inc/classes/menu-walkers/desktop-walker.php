<?php
class Desktop_Menu_Walker extends Walker_Nav_Menu {
    private $current_parent = 0;
    private $column_headers = array();

    public function start_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth === 0) {
            // First level - Start mega menu container
            $output .= '<div class="mega-menu"><div class="mega-menu-content">';
            
            // Featured Section
            $output .= '<div class="featured-section">';
            $output .= '<div class="featured-image">';
            $output .= '<img src="' . get_theme_file_uri('assets/images/featured-image.jpg') . '" alt="Featured Property">';
            $output .= '</div>';
            $output .= '<div class="featured-text">';
            $output .= 'Discover your dream property with our expert guidance and comprehensive listings.';
            $output .= '</div>';
            $output .= '<a href="/properties" class="cta-button">Explore Properties</a>';
            $output .= '</div>';
            
            // Menu Columns
            $output .= '<div class="menu-columns">';
        } elseif ($depth === 1) {
            // Second level - Start column items container
            $output .= '<div class="column-items">';
        }
    }

    public function end_lvl(&$output, $depth = 0, $args = array()) {
        if ($depth === 0) {
            // Close mega menu containers
            $output .= '</div></div></div>';
        } elseif ($depth === 1) {
            // Close column items container
            $output .= '</div>';
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        if ($depth === 0) {
            // Top level menu items
            $output .= '<div class="menu-item">';
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
        } elseif ($depth === 1) {
            // Column headers
            $output .= '<div class="column">';
            $output .= '<h4>' . esc_html($item->title) . '</h4>';
        } else {
            // Menu links within columns
            $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = array()) {
        if ($depth === 0 || $depth === 1) {
            $output .= '</div>';
        }
    }
}
