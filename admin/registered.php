<?php
  include('authentication.php');
  include('includes/header.php');
  include('includes/topbar.php');
  include('includes/sidebar.php');
  include('config/dbcon.php');
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Modal -->
    <div class="modal fade" id="AddUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <form action="code.php" method="post">
          <div class="modal-body">
          <div class="form-group">
            <label for="">Name</label>
               <input type="text" name="name" class="form-control"  placeholder="Name">
              </div>

              <div class="form-group">
              <label for="">Phone Number</label>
               <input type="text"name="phone" class="form-control" placeholder="Phone Number">
              </div>
              <div class="form-group">
              <label for="">Email Id</label>
              <span class="email_error text-danger ml-2"></span>
               <input type="email" name="email" class="form-control email_id" placeholder="Email">
              </div>
              <div class="row">
                <div class="col-md-6">
                <div class="form-group">
            <label for="">Password</label>
               <input type="password" name="password" class="form-control" placeholder="Password">
              </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
            <label for="">Confirm Password</label>
               <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">
              </div>
            </div>
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

    <!--Delete User -->
    <div class="modal fade" id="DeleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="code.php" method="POST">
          <div class="modal-body">
            <input type="hidden" name="delete_id" class="delete_user_id">
            <p>
              Are you sure, Do you wnat to delete this data?
            </p>   
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="DeleteUserbtn" class="btn btn-primary">Yes, Delete!</button>
        </div>
      </form>  
    
    </div>
  </div>
</div>
<!-- Delete User -->

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Registered Users</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <!-- /.content-header -->
<section class="content">
  <div class="container">
    <div class="row">
      <div class=col-md-12>
        <?php
          if(isset($_SESSION['status']))
          {
              echo "<h4>".$_SESSION['status']."</h4";
              unset($_SESSION['status']);
          }
        ?>
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Registered User</h3>
              <a href="#" data-toggle="modal" data-target="#AddUserModal" class="btn btn-primary float-right">Add User</a>
          </div>
              <!-- /.card-header -->
                <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>E-Mail</th>
                    <th>Phone No</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      $query = "SELECT * FROM users";
                      $query_run = mysqli_query($con, $query);

                      if(mysqli_num_rows($query_run) > 0)
                      {
                        foreach($query_run as $row)
                        {
                          //echo $row['name'];
                    ?>             
                    <tr>
                      <td> <?php echo $row['id']; ?> </td>
                      <td> <?php echo $row['name']; ?> </td>
                      <td> <?php echo $row['email']; ?> </td>
                      <td> <?php echo $row['phone']; ?> </td>               
                      
                      <td>
                         <?php
                            if($row['role_as'] == "0")
                            {
                              echo "User";
                            }
                            elseif($row['role_as'] == "1")
                            {
                              echo "Admin";
                            }
                            else
                            {
                              echo "Invalid User";
                            }
                          ?>
                      </td>               
                      
                      <td>
                        <a href="registered-edit.php?user_id=<?php echo $row['id']; ?> " class="btn btn-info btn-sm">Edit</a>
                        <button type="button" value="<?php echo $row['id']; ?> " class="btn btn-danger btn-sm deletebtn">Delete</a>
                      </td>
                    </tr>
                    
                    <?php
                  }
                }
                else
                {
                  ?>
                    <tr>
                      <td>No Record Found</td>
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
  </div>
</section>

<?php include('includes/scripts.php'); ?>

<script>
  $(document).ready(function () {   

    $('.email_id').keyup(function (e) { 
      var email = $('.email_id').val(); 
      // console.log(email); 

      $.ajax({
        type: "POST",
        url: "code.php",
        data: {  
          'check_Emailbtn':1,
          'email':email,
        },
        success: function (response) {
         // console.log(response);
         $.('.email_error').text(response);
        }
      });
    });  
  });
</script>

<script>
  $(document).ready(function () {
    $(".deletebtn").click(function (e) { 
      e.preventDefault();
      
      var user_id = $(this).val();
      // console.log(user_id);
      $('.delete_user_id').val(user_id);
      $('#DeleteModal').modal('show');
    });
  });
</script>

<?php include('includes/footer.php'); ?>