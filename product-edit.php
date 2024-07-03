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
            <li class="breadcrumb-item active">Product Edit Page</li>
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
              <h3 class="card-title">Edit Products</h3>
              <a href="product.php" class="btn btn-danger btn-sm float-right">Back</a>
            </div>
            <!-- /.card-header -->

            <div class="card-body">
              <div class="row">
                <div class="col-md-6">
                  <form action="execute.php" method="POST">
                    <div class="modal-body">

                      <?php

                      if (isset($_GET['product_id'])) {
                        $user_id = $_GET['product_id'];
                        $query = "SELECT * FROM products WHERE id='$user_id' LIMIT 1";
                        $query_run = mysqli_query($conn, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                          foreach ($query_run as $row) {
                            ?>
                      <input type="hidden" name="product_id" value="<?php echo $row['id']?>">

                      <div class="form-group">
                        <label for="">Product Name</label>
                        <input type="text" name="product_name" value="<?php echo $row['product_name']?>" class="form-control"
                          placeholder="Product Name">
                      </div>
                      <div class="form-group">
                        <label for="">Quantity</label>
                        <input type="number" name="qty" value="<?php echo $row['qty']?>" class="form-control"
                          placeholder="Quantity">
                      </div>
                      <div class="form-group">
                        <label for="">Quantity Type</label>
                        <input type="text" name="qty_type" value="<?php echo $row['qty_type']?>" class="form-control"
                          placeholder="Quantity Type">
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
                      <button type="submit" name="updateProduct" class="btn btn-info">Update</button>
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