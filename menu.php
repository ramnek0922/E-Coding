<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link" style="background-color: green; color: white;">
        <span class="brand-text font-weight-bold">E-Coding</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" style="background-color: #fffbe6;">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Home -->
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="nav-icon fas fa-home" style="color: #33cc4f;"></i>
                        <p style="color: #33cc4f;">Home</p>
                    </a>
                </li>
                <!-- View Toys -->
                <li class="nav-item">
                    <a href="index.php?page=view_toys" class="nav-link">
                        <i class="nav-icon fas fa-cube" style="color: #33cc4f;"></i>
                        <p style="color: #33cc4f;">View All Toys</p>
                    </a>
                </li>
                <!-- Orders -->
                <li class="nav-item">
                    <a href="index.php?page=orders" class="nav-link">
                        <i class="nav-icon fas fa-shopping-cart" style="color: #33cc4f;"></i>
                        <p style="color: #33cc4f;">My Orders</p>
                    </a>
                </li>
                <!-- Shipping -->
                <li class="nav-item">
                    <a href="index.php?page=shipping" class="nav-link">
                        <i class="nav-icon fas fa-shipping-fast" style="color: #33cc4f;"></i>
                        <p style="color: #33cc4f;">Shipping</p>
                    </a>
                </li>
                <!-- Profile -->
                <li class="nav-item">
                    <a href="index.php?page=profile" class="nav-link">
                        <i class="nav-icon fas fa-user" style="color: #33cc4f;"></i>
                        <p style="color: #33cc4f;">Profile</p>
                    </a>
                </li>
                <!-- Contact -->
                <li class="nav-item">
                    <a href="index.php?page=contact" class="nav-link">
                        <i class="nav-icon fas fa-envelope" style="color: #33cc4f;"></i>
                        <p style="color: #33cc4f;">Contact Us</p>
                    </a>
                </li>
                <!-- Logout -->
                <li class="nav-item">
                    <a href="javascript:void(0);" onclick="confirmLogout();" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt" style="color: #33cc4f;"></i>
                        <p style="color: #33cc4f;">Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<!-- Logout Confirmation -->
<script>
    function confirmLogout() {
        if (confirm('Are you sure you want to logout?')) {
            window.location.href = 'logout.php';
        }
    }
</script>