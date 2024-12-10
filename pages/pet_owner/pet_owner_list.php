<?php
// Include the authentication check file
include_once('../includes/auth_check.php');
?>
<!DOCTYPE html>
<html lang="en">

<?php include '../includes/header.php'; ?>
<style>
  .hidden-column {
    display: none;
  }
</style>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include '../includes/navbar.php'; ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include '../includes/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Pet Owner Info</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
      <?php include '../includes/success_message.php'; ?>
      <?php include '../includes/error_message.php'; ?>
      <?php include 'add_modal.php'; ?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <a href="#addnew" data-toggle="modal" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add New</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example3" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Action</th>
                        <th class='hidden-column'>Pet Owner ID</th>
                        <th>Pet Owner Name</th>
                        <th>Email Address</th>
                        <th>Contact Number</th>
                        <th>Address</th>
                        <th>Profile Image</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        require_once('../includes/dbcon.php');
                        
                        // Define the SQL query
                        $sql = "SELECT pet_owner_id, pet_owner_name, pet_owner_contact, pet_owner_email, pet_owner_address, pet_owner_profile
                                FROM tbl_pet_owner";
                        
                        // Execute the query
                        $query = $conn->query($sql);
                        
                        // Check for errors in query execution
                        if (!$query) {
                            echo "Error executing query: " . $conn->error;
                        } else {
                            // Process result set
                            while($row = $query->fetch_assoc()) {
                                echo "<tr>
                                        <td>
                                          <a href='#edit_" . $row['pet_owner_id'] . "' class='btn btn-success btn-sm' data-toggle='modal'>Edit</a>
                                          <a href='#delete_" . $row['pet_owner_id'] . "' class='btn btn-danger btn-sm' data-toggle='modal'>Delete</a>
                                        </td>
                                        <td class='hidden-column'>" . $row['pet_owner_id'] . "</td>
                                        <td>" . $row['pet_owner_name'] . "</td>
                                        <td>" . $row['pet_owner_email'] . "</td>
                                        <td>" . $row['pet_owner_contact'] . "</td>
                                        <td>" . $row['pet_owner_address'] . "</td>
                                        <td class='text-center'>
                                            <img src='pet_owner_upload/" . $row['pet_owner_profile'] . "' class='img-thumbnail' style='width:100px;' alt='Profile Image'><br>
                                            <button class='btn btn-flat btn-warning btn-xs' data-toggle='modal' data-target='#edit_image_" . $row['pet_owner_id'] . "'><i class='nav-icon fas fa-pen'></i> Edit Image</button>
                                        </td>
                                      </tr>";
                                // Include modal files
                                include('edit_delete_modal.php');
                                include('update_image_modal.php');
                            }
                        }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
 
  </div>
  <!-- /.content-wrapper -->

   <!-- Main Footer -->
  <?php include '../includes/dashboard_footer.php'; ?>

</div>
<!-- ./wrapper -->

<?php include '../includes/footer.php'; ?>
</body>
</html>