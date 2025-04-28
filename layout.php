<!DOCTYPE html>
<html lang="en">
<?php include 'include/head.php' ?>
<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Blog Management</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <?php include 'include/sidebar.php'; ?>
        
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <?php section();?>
    </div>

  </div>
<!-- ./wrapper -->

<!-- jQuery -->
<?php include 'include/mainJs.php' ?>

</body>
</html>