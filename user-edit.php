<?php
session_start();

include('config/dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
?>

<!-- ******************************************************************************************************** -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->

        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active">Edit User Details</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- ******************************************************************************************************** -->

  <section class="content">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-md 12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Edit Users</h3>
              <a href="admin.php" class="btn btn-danger btn-sm float-right">Back</a>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <form action="execute.php" method="POST">
                    <div class="modal-body">

                      <?php

                      if (isset($_GET['user_id'])) {
                        $user_id = $_GET['user_id'];
                        $query = "SELECT * FROM users WHERE id='$user_id' LIMIT 1";
                        $query_run = mysqli_query($conn, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                          foreach ($query_run as $row) {
                            ?>
                      <input type="hidden" name="user_id" value="<?php echo $row['id']?>">

                      <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" value="<?php echo $row['name']?>" class="form-control"
                          placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="">Email</label>
                        <input type="email" name="email" value="<?php echo $row['email']?>" class="form-control"
                          placeholder="Email">
                      </div>
                      <div class="form-group">
                        <label for="">Phone No</label>
                        <input type="text" name="phone" value="<?php echo $row['phone']?>" class="form-control"
                          placeholder="Phone number">
                      </div>
                      <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" name="password" value="<?php echo $row['password']?>"
                          class="form-control" placeholder="Password">
                      </div>
                    </div>
                    <?php
                          }
                        }
                        else {
                          echo "<h4>No Record Found.!</h4>";
                        }
                      }
                    ?>
                    <div class="modal-footer float-left">
                      <button type="submit" name="updateUser" class="btn btn-info">Update</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</div><!-- /.content-wrapper -->

<?php include('includes/script.php');?>
<?php include('includes/footer.php');?>