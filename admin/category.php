<?php
include('authentication.php');
include('config/dbcon.php');
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
?>

<!-- Modal -->
<div class="modal fade" id="CategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Gift Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form action="code.php" method="POST">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Category Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="">Description</label>
            <textarea name="description" class="form-control" required rows="3"></textarea>
          </div>

          <div class="form-group">
            <label for="">Trending</label>
            <input type="checkbox" name="trending"> Trending
          </div>

          <div class="form-group">
            <label for="">Status</label>
            <input type="checkbox" name="status"> Status
          </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="category_save" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

  <section class="content mt-4">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
            <?php
                include('message.php');
            ?>
          <div class="card">
            <div class="card-header"> 
              <h4>
                  Gift Category
                  <a href="#" data-toggle="modal" data-target="#CategoryModal" class="btn btn-primary float-right">Add</a>
              </h4>
            </div>
            <div class="card-body">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Trending</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                  <tbody>
                    <?php
                      $query = "SELECT * FROM categories";
                      $query_run = mysqli_query($con, $query);

                      if(mysqli_num_rows($query_run) > 0)
                      {
                          foreach($query_run as $cateitem)
                          {
                            //echo $cateitem ['id'];
                            ?>
                            <tr>
                              <td> <?= $cateitem['id']; ?> </td>
                              <td> <?= $cateitem['name']; ?>  </td>                
                              <td>
                                 <input type="checkbox" <?= $cateitem['trending'] == '1' ? 'checked':'' ?> readonly />
                              </td>
                              <td>
                                 <input type="checkbox" <?= $cateitem['status'] == '1' ? 'checked':'' ?> readonly />
                              <td> <?= $cateitem['created_at']; ?> </td>
                              <td>
                                <a href="category-edit.php?id=<?= $cateitem['id']; ?>" class="btn btn-success">Edit</a>
                                </td>
                                <td>
                                <form action="code.php" method="POST">
                                        <input type="hidden" name="cate_delete_id" value=" <?= $cateitem['id']; ?>">
                                        <button type="submit" name="cate_delete_btn" class="btn btn-danger">Delete</button>
                                </form>
                              </td>
                            </tr>
                            <?php
                            }
                        }
                        else
                        {
                          ?>
                            <tr>
                              <td colspan="7"> No Record Found. </td>
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

<?php include('includes/scripts.php'); ?>
<?php include('includes/footer.php'); ?>