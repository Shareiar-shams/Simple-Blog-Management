<?php
  require_once 'db.php'; 
  require_once 'app/dashboard-controller.php'; 
  $bot = new Dashboard_Controller();
  // define variables and set to empty values
  $titleErr = $subTitleErr = $imageErr = $short_descriptionErr = $descriptionErr = "";
  $title = $subtitle = $image = $short_description = $description = "";

  
	// if ($_SERVER["REQUEST_METHOD"] == "POST") {

	//      if (empty($_POST["pack_name"])) {
	//        $packErr = "Name is required";
	//      } else {
	//        $pack = $_POST["pack_name"];
	//      }

	//      if (empty($_POST["pack_price"])) {
	//        $priceErr = "Price is required";
	//      } else {
	//        $price = $_POST["pack_price"];
	       
	//      }

	//      if (empty($_POST["param_en"])) {
	//        $paramErr = "Param is required";
	//      } else {
	//        $param = $_POST["param_en"];
	       
	//      }

	//      if (empty($_POST["keyword"])) {
	//        $keywordErr = "Keyword is required";
	//      } else {
	//        $keyword = $_POST["keyword"];
	       
	//      }

	//      if (empty($_POST["reply_text_en"])) {
	//        $reply_enErr = "reply text is required";
	//      } else {
	//        $reply_en = $_POST["reply_text_en"];
	       
	//      }

	//      if (empty($_POST["reply_text_ban"])) {
	//        $reply_bnErr = "reply text is required";
	//      } else {
	//        $reply_bn = $_POST["reply_text_ban"];
	       
	//      }

	//      $category = $_POST["category"];

	//      if(!empty($_POST['pack_name']) && !empty($_POST['pack_price']) && !empty($_POST['param_en']) && !empty($_POST['keyword']) && !empty($_POST['reply_text_en']) && !empty($_POST['reply_text_ban'])){

	//         // Handle Image Upload
	//         $targetDir = "uploads/"; // Folder to store images
	//         $fileName = basename($_FILES["image"]["name"]);
	//         $targetFilePath = $targetDir . time() . "_" . $fileName; // Unique name for image
	//         $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

	//         // Allowed file types
	//         $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
	//         if (in_array($imageFileType, $allowedTypes)) {
	//             if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
	//                   $conditons = "`pack_name` = '$pack'";
	//                   $chack_data = $bot->selectData('whatsapp_robi_query_response','id',$conditons,1);

	//                   if ($chack_data > 0) {
	//                       $_SESSION['success_message'] = "Pack already Exists.";
	//                   }
	//                   else{
	//                       $value = array(
	//                         "category" => $category,
	//                         "param_en" => $param,
	//                         "keywords" => $keyword,
	//                         "reply_text_en" => $reply_en,
	//                         "reply_text_ban" => $reply_bn,
	//                         "pack_name" => $pack,
	//                         "pack_price" => $price,
	//                         "image_path" => $targetFilePath // Save image path in database
	//                       );

	//                       $put_data = $bot->insertData('whatsapp_robi_query_response',$value);
	//                       if($put_data !== false)
	//                           $_SESSION['success_message'] = "Pack Upload successfully.";
	//                       else
	//                           $_SESSION['success_message'] = "Something want wrong.";
	//                   }
	//               }
	//         }
	//      }
	// }

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
                <h3 class="card-title">Pack List</h3>
              </div>
              <div class="col-lg-6">
                <h3 class="card-title" style="float: right;">
                  <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-info">
                    Add Blog
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
          ?>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Sr.No</th>
                <th>Title</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Category</th>
                <th>Action</th>                   
              </tr>
              </thead>
              <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Test Title</td>
                    <td><img src="dist/img/photo1.png" height="50" width="50" alt=""></td>
                    <td><a href="">Politics</a> <a href="">Business</a></td>
                    <td>Politics</td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-default">Action</button>
                        <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                          <a class="dropdown-item" href="#">Edit</a>
                          <a class="dropdown-item" href="#">Delete</a>
                        </div>
                      </div>
                    </td>
                    
                </tr>
              
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
<div class="modal fade" id="modal-info">
  <div class="modal-dialog">
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h4 class="modal-title">Add Blog</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="quickForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <label>Title</label>
              <input type="text" name="title" class="form-control" placeholder="Enter Title" required="required">
              <small><?php echo $titleErr; ?></small>
            </div>
            <div class="form-group">
              <label>SubTitle</label>
              <input type="number" name="SubTitle" class="form-control" placeholder="Enter Sub Title" required="required">
              <small><?php echo $subTitleErr; ?></small>                  
            </div>
            <div class="card-body">
              <img src="" class="profile-user-img img-responsive" alt="Selected Featured Image" id="output">
              <div class="form-group">
                  <label for="exampleInputFile">Featured Image *</label>
                  <div class="input-group">
                    <div class="custom-file">
                        <input type="file" accept="image/*" onchange="loadFile(event)" name="featured_image" class="custom-file-input" id="FeaturedImageInputFile" required>
                        <label class="custom-file-label" for="exampleInputFile">Upload Image</label>
                    </div>
                  </div>
              </div>
                <small style="color: blue;">Image Size Should Be 800 x 800. or square size</small>
            </div>


            <div class="from-group">
              <label for="exampleInputEmail1">Short Description *</label>
                <textarea class="form-control" name="short_description" placeholder="Short Description"></textarea>
            </div>
            <div class="from-group mt-3">
              <label for="exampleInputEmail1">Description *</label>
                <textarea id="summernote" name="description" placeholder="Description" required></textarea>
            </div>

            <div class="form-group">
                <label>Select Category *</label>
                <select class="form-control select2bs4" name="category_id" id="category" style="width: 100%;" required>
                    <option value="" selected="selected">Select One</option>
                    <option value="" selected="selected">First</option>
                    <option value="" selected="selected">Second</option>
                    
                </select>
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