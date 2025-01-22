<?php
/*
Template Name: User Dashboard
*/

get_header();
?>
<div class="dashboard-container">
    <aside class="dashboard-sidebar">
        <nav class="dashboard-nav">
            <a href="/dashboard" class="nav-item active">
                <span class="icon">📊</span>
                Overview
            </a>
            <a href="/dashboard/properties" class="nav-item">
                <span class="icon">🏠</span>
                Properties
            </a>
            <a href="/dashboard/investments" class="nav-item">
                <span class="icon">💰</span>
                Investments
            </a>
            <a href="/dashboard/documents" class="nav-item">
                <span class="icon">📄</span>
                Documents
            </a>
            <a href="/dashboard/settings" class="nav-item">
                <span class="icon">⚙️</span>
                Settings
            </a>
        </nav>
    </aside>

    <main class="dashboard-main">
        <div class="bento-grid">
            <!-- Large card spanning two columns -->
            <div class="bento-card wide">
                <h3>Investment Overview</h3>
                <div class="card-content">
                    <!-- Placeholder for chart or data -->
                </div>
            </div>

            <!-- Regular cards -->
            <div class="bento-card">
                <h3>Active Properties</h3>
                <div class="card-content">
                    <!-- Property count and quick stats -->
                </div>
            </div>

            <div class="bento-card">
                <h3>Total Investment</h3>
                <div class="card-content">
                    <!-- Investment amount -->
                </div>
            </div>

            <!-- Tall card spanning two rows -->
            <div class="bento-card tall">
                <h3>Recent Activity</h3>
                <div class="card-content">
                    <!-- Activity feed -->
                </div>
            </div>

            <div class="bento-card">
                <h3>ROI Overview</h3>
                <div class="card-content">
                    <!-- ROI stats -->
                </div>
            </div>
        </div>
    </main>
</div>
<?php get_footer(); ?>
