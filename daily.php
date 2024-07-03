
<?php
include('config/dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');


// Get the current date for the heading
$current_date = date('j F Y');


// Handle POST request to update products
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Loop through selected products
    if (isset($_POST['selected_products']) && !empty($_POST['selected_products'])) {
        foreach ($_POST['selected_products'] as $product_id) {
            // Assuming qty inputs are named as 'qty_<product_id>'
            $qty = $_POST['qty_' . $product_id];


            // Check if the product entry already exists in dailyproducts
            $check_query = "SELECT * FROM dailyproducts WHERE daily_id = $product_id";
            $check_result = mysqli_query($conn, $check_query);


            if (mysqli_num_rows($check_result) > 0) {
                // Update existing record
                $update_query = "UPDATE dailyproducts SET qty = $qty WHERE daily_id = $product_id";
                mysqli_query($conn, $update_query);
            } else {
                // Insert new record
                $insert_query = "INSERT INTO dailyproducts (daily_id, product_name, qty, qty_type, added_by_user)
                                SELECT id, product_name, $qty, qty_type, added_by_user FROM products WHERE id = $product_id";
                mysqli_query($conn, $insert_query);
            }
        }


        echo "<script>alert('Product Updated successfully'); window.location.href='daily.php';</script>";
    } else {
        echo "<script>alert('No products selected!'); window.location.href='daily.php';</script>";
    }
}
?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Daily Product</h1>
                </div>
                <form action="execute.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="delete_id" class="delete_product_id">
                        <p>Are you sure, you want to delete this data?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="DelDailyProduct" class="btn btn-primary">Yes, Delete!</button>
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
                    <h4 class="m-0">Today's Date: <strong><?php echo $current_date; ?></strong> </h4>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="./">Home</a></li>
                        <li class="breadcrumb-item active">Daily Entry Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daily New Products</h3>
                        </div>


                        <div class="card-body">
                            <form id="dailyProductsForm"  method="POST">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Select</th>
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
                                            while ($row = mysqli_fetch_assoc($query_run)) {
                                                ?>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="selected_products[]" value="<?php echo $row['id']; ?>">
                                                    </td>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['product_name']; ?></td>
                                                    <td>
                                                        <input type="number" name="qty_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['qty']; ?>">
                                                    </td>
                                                    <td><?php echo $row['qty_type']; ?></td>
                                                    <td><?php echo $row['created_at']; ?></td>
                                                    <td><?php echo $row['modified_at']; ?></td>
                                                    <td><?php echo $row['added_by_user']; ?></td>
                                                    <td>
                                                        <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger btn-sm DelDailyProduct">Delete</button>
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
                                <button type="submit" class="btn btn-primary mt-3 float-right">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>


<?php include('includes/script.php'); ?>

<script>

$(document).ready(function () {
    $('.DelDailyProduct').click(function (e) {
        e.preventDefault();

        var product_id = $(this).val();
        $('.delete_product_id').val(product_id);
        $('#deleteModal').modal('show');
    });
});


$(document).ready(function () {
    $('#dailyProductsForm').submit(function (e) {
        e.preventDefault();


        var formData = $(this).serialize();


        $.ajax({
            url: 'daily.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                alert('Products updated successfully!');
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error('An error occurred while updating products.');
                console.error(error);
            }
        });
    });
});
</script>


<?php include('includes/footer.php'); ?>