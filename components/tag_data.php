<?php

  require_once 'db.php'; 

  require_once 'app/dashboard-controller.php'; 
  $bot = new Dashboard_Controller();
   // define variables and set to empty values
  $titleErr = $title = $slugErr = $slug = "";


  if ($_SERVER["REQUEST_METHOD"] == "POST") {

      if (empty($_POST["title"])) {
         $titleErr = "Title is required";
      } else {
         $title = $_POST["title"];
      }

      if (empty($_POST["slug"])) {
         $slugErr = "Title is required";
      } else {
         $slug = $_POST["slug"];
      }
      if(empty($titleErr) && !empty($title) && empty($slugErr) && !empty($slug) ){
          $value = array(
            "title" => $title,
            "slug" => $slug,
          );
          $put_data = $bot->insertData('tags',$value);
          if($put_data !== false)

              $_SESSION['success_message'] = "Tag Insert successfully.";
          else
              $_SESSION['error_message'] = "Something want wrong.";
      }
  }

?>


<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">

        <div class="card">
          <div class="card-header">
            <div class="row">
              <div class="col-lg-6">
                <h3 class="card-title">Tag List</h3>
              </div>
              <div class="col-lg-6">
                <h3 class="card-title" style="float: right;">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-success">
                    Add Tag
                  </button>
                </h3>
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <?php
          if (isset($_SESSION['success_message']) && !empty($_SESSION['success_message'])) { ?>
              <div class="success-message" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['success_message']; ?></div>
              <?php
              unset($_SESSION['success_message']);
          }

          if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) { ?>
              <div class="danger-message" style="margin-bottom: 20px;font-size: 20px;color: green;"><?php echo $_SESSION['error_message']; ?></div>
              <?php
              unset($_SESSION['error_message']);
          }
          ?>

          
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Sr.No</th>
                <th>Tag Title</th>
                <th>Tag Slug</th>
                <th>Action</th>                  
              </tr>
              </thead>
              <tbody>
              <?php
                $sr=0;
                $conditons = "`title` != '' ORDER BY `id` DESC";
                $results = $bot->selectData('tags','',$conditons,'');
                $nm_row = count($results);
                if($nm_row > 0)
                {
                  foreach ($results as $key => $value) {
                      $id = $value['id'];
                      $title = $value['title'];
                      $slug = $value['slug'];
                    ?>
                      <tr>
                          <th scope="row"><?php echo ++$sr; ?></th>
                          <td><?php echo $title; ?></td>
                          <td><?php echo $slug; ?></td>
                          <td>
                            <div class="btn-group">
                              <button type="button" class="btn btn-default">Action</button>
                              <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="updatetag.php?id=<?php echo $id; ?>">Edit</a>
                                <a class="dropdown-item" href="tagdelete.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure you want to delete this Tag?');">Delete</a>
                              </div>
                            </div>
                          </td>
                      </tr>
                    <?php
                  }
                }
              ?>
              </tbody>
            </table>
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
<!-- /.content -->
<div class="modal fade" id="modal-success">
  <div class="modal-dialog">
    <div class="modal-content bg-success">
      <div class="modal-header">
        <h4 class="modal-title">Add Tag</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="quickForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <label>Title *</label>
              <input type="text" name="title" onkeyup="listingslug(this.value)" id="title" class="form-control" placeholder="Enter Title" required="required">
              <small><?php echo $titleErr; ?></small>
            </div>

            <div class="form-group">
              <label>Slug *</label>
              <input type="text" name="slug" id="slug" class="form-control" placeholder="Enter Slug" required="required">
              <small><?php echo $slugErr; ?></small>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->