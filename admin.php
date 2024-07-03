<?php
session_start();

include('config/dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
include('includes/sidebar.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <!-- Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
        </div>
        <form action="execute.php" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="">Name</label>
              <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
            <div class="form-group">
              <label for="">Email</label>
              <input type="email" name="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
              <label for="">Phone No</label>
              <input type="text" name="phone" class="form-control" placeholder="Phone number">
            </div>
            <div class="form-group">
              <label for="">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Password">
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="addUser" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Delete User Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete User</h1>
        </div>
        <form action="execute.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="delete_id" class="delete_user_id">
            <p>Are you sure you want to delete this user?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="deleteBtn" class="btn btn-primary">Yes, Delete!</button>
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
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active">Admin</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <?php
          if (isset($_SESSION['status'])) {
            echo "<h4>" . $_SESSION['status'] . "</h4>";
            unset($_SESSION['status']);
          }
          ?>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Admin Portal</h3>
              <a href="#" data-toggle="modal" data-target="#addUserModal" class="btn btn-primary btn-sm float-right">Add User</a>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $query = "SELECT * FROM users WHERE del_flag = 0";
                  $query_run = mysqli_query($conn, $query);

                  if (mysqli_num_rows($query_run) > 0) {
                    foreach ($query_run as $row) {
                      ?>
                      <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td>
                          <a href="user-edit.php?user_id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Edit</a>
                          <button type="button" value="<?php echo $row['id']; ?>" class="btn btn-danger btn-sm deleteBtn">Delete</button>
                        </td>
                      </tr>
                      <?php
                    }
                  } else {
                    ?>
                    <tr>
                      <td colspan="5">No Record Found!</td>
                    </tr>
                    <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
include('includes/script.php');
?>

<script>
  $(document).ready(function () {
    $('.deleteBtn').click(function (e) {
      e.preventDefault();

      var user_id = $(this).val();
      $('.delete_user_id').val(user_id);
      $('#deleteModal').modal('show');
    });
  });
</script>

<?php
include('includes/footer.php');
?>
