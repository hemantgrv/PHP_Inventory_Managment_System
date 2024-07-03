<?php
// Check if session is not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <!-- <a href="./" class="brand-link">
    <img src="assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">Admin Services</span>
  </a> -->

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="./" class="d-block"><?php echo htmlspecialchars($_SESSION['name']); ?></a>
        <a href="logout.php" class="d-block">Logout</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">Settings</li>
        <li class="nav-item">
          <a href="admin.php" class="nav-link">
            <i class="nav-icon far fa-user"></i>
            <p>
              Admin Profile
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="registered.php" class="nav-link">
            <i class="nav-icon fa fa-users"></i>
            <p>
              Registered Users
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="login.php" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Login Users
            </p>
          </a>
        </li>
        <!-- Inventory Starts Here  -->
        <li class="nav-item">
          <a href="product.php" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Products
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="daily.php" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>
              Daily Entry Record
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="report.php" class="nav-link">
            <i class="nav-icon fas fa-chart-pie"></i>
            <p>
              Reports
            </p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>