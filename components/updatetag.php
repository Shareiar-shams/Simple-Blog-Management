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

      $id = $_POST["get_id"];

     if(empty($titleErr) && !empty($title) && empty($slugErr) && !empty($slug) ){
        $conditons = "`id` = '$id'";
        $value = array(
            "title" => $title,
            "slug" => $slug,
        );
        $put_data = $bot->updateData('tags',$value,$conditons);
        if($put_data !== false)
        {
            $_SESSION['success_message'] = "Tag Update successfully.";
            header("Location:tag.php");
        }
        else{
            $_SESSION['error_message'] = "Some problem found.";
            header("Location:tag.php");
        }
        exit();
     }
  }

  $id = $_GET['id'];

  $conditons = "`id` = '".$id."'";
  $check_data = $bot->selectData('tags','',$conditons,'');

  $get_id = $check_data[0]['id'];
  $title = $check_data[0]['title'];
  $slug = $check_data[0]['slug'];

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Update Tag</h1>
      </div>
      
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- jquery validation -->
        <div class="card card-primary">
          
          <!-- form start -->
          <form id="quickForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="card-body">
              <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" onkeyup="listingslug(this.value)" id="title" class="form-control" placeholder="Enter Title" value="<?php echo $title; ?>">
                <small><?php echo $titleErr; ?></small>
              </div>
              <div class="form-group">
                <label>Slug *</label>
                <input type="text" name="slug" id="slug" class="form-control" placeholder="Enter Slug" value="<?php echo $slug; ?>">
                <small><?php echo $slugErr; ?></small>                  
              </div>

              <input type="hidden" name="get_id" value="<?php echo $get_id ?>">

            </div>
            <!-- /.card-body -->
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.card -->
        </div>
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-6">

      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->