<?php
include('config/dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Product</h1>
                </div>
                <form action="execute.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="delete_id" class="delete_product_id">
                        <p>Are you sure, you want to delete this data?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="deleteProduct" class="btn btn-primary">Yes, Delete!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                        <li class="breadcrumb-item active">Products Page</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12">

                    <!-- Card for Adding Products -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add New Products</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <form action="execute.php" method="POST">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="productName">Product Name</label>
                                                <input type="text" name="product_name" class="form-control"
                                                    placeholder="Product Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="qty">Quantity</label>
                                                <input type="number" name="qty" class="form-control"
                                                    placeholder="Quantity">
                                            </div>
                                            <div class="form-group">
                                                <label for="qtyType">Quantity Type</label>
                                                <input type="text" name="qty_type" class="form-control"
                                                    placeholder="Quantity Type">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="addProduct" class="btn btn-info">Add Product</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- Card for Displaying Products -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Products</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Quantity Type</th>
                                        <th>Created At</th>
                                        <th>Modified At</th>
                                        <th>Added by User</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM products WHERE del_flag = 0";
                                    $query_run = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($query_run) > 0) {
                                        foreach ($query_run as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['product_name']; ?></td>
                                        <td><?php echo $row['qty']; ?></td>
                                        <td><?php echo $row['qty_type']; ?></td>
                                        <td><?php echo $row['created_at']; ?></td>
                                        <td><?php echo $row['modified_at']; ?></td>
                                        <td><?php echo $row['added_by_user']; ?></td>
                                        <td>
                                            <a href="product-edit.php?product_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                                            <button type="button" value="<?php echo $row['id']; ?>"
                                                class="btn btn-danger btn-sm deleteProduct">Delete</button>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                    <tr>
                                        <td colspan="8">No Record Found!</td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include('includes/script.php'); ?>

<script>
$(document).ready(function () {
    $('.deleteProduct').click(function (e) {
        e.preventDefault();

        var product_id = $(this).val();
        $('.delete_product_id').val(product_id);
        $('#deleteModal').modal('show');
    });
});
</script>

<?php include('includes/footer.php'); ?>
