<?php
  require_once 'db.php'; 

  require_once 'app/dashboard-controller.php'; 
  $bot = new Dashboard_Controller();
  // define variables and set to empty values
  $packErr = $priceErr = $paramErr = $keywordErr = $reply_enErr = $reply_bnErr = "";
  $pack = $price = $param = $keyword = $reply_en = $reply_bn = "";


  if ($_SERVER["REQUEST_METHOD"] == "POST") {

     if (empty($_POST["pack_name"])) {
       $packErr = "Name is required";
     } else {
       $pack = $_POST["pack_name"];
     }

     if (empty($_POST["pack_price"])) {
       $priceErr = "Price is required";
     } else {
       $price = $_POST["pack_price"];
       
     }

     if (empty($_POST["param_en"])) {
       $paramErr = "Param is required";
     } else {
       $param = $_POST["param_en"];
       
     }

     if (empty($_POST["keyword"])) {
       $keywordErr = "Keyword is required";
     } else {
       $keyword = $_POST["keyword"];
       
     }

     if (empty($_POST["reply_text_en"])) {
       $reply_enErr = "reply text is required";
     } else {
       $reply_en = $_POST["reply_text_en"];
       
     }

     if (empty($_POST["reply_text_ban"])) {
       $reply_bnErr = "reply text is required";
     } else {
       $reply_bn = $_POST["reply_text_ban"];
       
     }

     $category = $_POST["category"];

     if(!empty($_POST['pack_name']) && !empty($_POST['pack_price']) && !empty($_POST['param_en']) && !empty($_POST['keyword']) && !empty($_POST['reply_text_en']) && !empty($_POST['reply_text_ban'])){

        // Handle Image Upload
        $targetDir = "uploads/"; // Folder to store images
        $fileName = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . time() . "_" . $fileName; // Unique name for image
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        // Allowed file types
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
                  $conditons = "`pack_name` = '$pack'";
                  $chack_data = $bot->selectData('whatsapp_robi_query_response','id',$conditons,1);

                  if ($chack_data > 0) {
                      $_SESSION['success_message'] = "Pack already Exists.";
                  }
                  else{
                      $value = array(
                        "category" => $category,
                        "param_en" => $param,
                        "keywords" => $keyword,
                        "reply_text_en" => $reply_en,
                        "reply_text_ban" => $reply_bn,
                        "pack_name" => $pack,
                        "pack_price" => $price,
                        "image_path" => $targetFilePath // Save image path in database
                      );

                      $put_data = $bot->insertData('whatsapp_robi_query_response',$value);
                      if($put_data !== false)
                          $_SESSION['success_message'] = "Pack Upload successfully.";
                      else
                          $_SESSION['success_message'] = "Something want wrong.";
                  }
              }
        }
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
                <h3 class="card-title">Pack List</h3>
              </div>
              <div class="col-lg-6">
                <h3 class="card-title" style="float: right;">
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-danger">
                    Add Plan
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
                <th>Param Name</th>
                <th>Pack Name</th>
                <th>Pack Price</th>
                <th>Reply English Text</th>
                <th>Reply Bangla Text</th>
                <th>Edit</th>
                <th>Delete</th>                   
              </tr>
              </thead>
              <tbody>
              <?php
                $sr=0;
                $conditons = "`category`='pack' ORDER BY `id` DESC";
                $results = $bot->selectData('whatsapp_robi_query_response','',$conditons,'');
                $nm_row = count($results);
                if($nm_row > 0){
                  foreach ($results as $key => $value) {
                      $id = $value['id'];
                      $panam = $value['param_en'];
                      $pack = $value['pack_name'];
                      $price = $value['pack_price'];
                      $reply_en = $value['reply_text_en'];
                      $reply_bn = $value['reply_text_ban'];
                    ?>
                      <tr>
                          <th scope="row"><?php echo ++$sr; ?></th>
                          <td><?php echo $panam; ?></td>
                          <td><?php echo $pack; ?></td>
                          <td><?php echo $price; ?></td>
                          <td><?php echo $reply_en; ?></td>
                          <td><?php echo $reply_bn; ?></td>
                          <td><a class="btn btn-warning" href="updateplan.php?id=<?php echo $id; ?>">Edit</a></td>
                          <td><a class="btn btn-danger" href="delete.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure you want to delete this pack?');">Remove</a></td>
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
<div class="modal fade" id="modal-danger">
  <div class="modal-dialog">
    <div class="modal-content bg-danger">
      <div class="modal-header">
        <h4 class="modal-title">Add Pack</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="quickForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
          <div class="card-body">
            <div class="form-group">
              <label>Pack Name/CBS</label>
              <input type="text" name="pack_name" class="form-control" placeholder="Enter Pack Name" required="required">
              <small><?php echo $packErr; ?></small>
            </div>
            <div class="form-group">
              <label>Pack Price</label>
              <input type="number" name="pack_price" class="form-control" placeholder="Enter Price" required="required">
              <small><?php echo $priceErr; ?></small>                  
            </div>
            <div class="form-group">
              <label>English Param</label>
              <input type="text" name="param_en" class="form-control" placeholder="Enter Param" required="required">
              <small><?php echo $paramErr; ?></small>                  
            </div>
            <input type="hidden" name="category" value="pack">
            <div class="form-group">
              <label>Keyword</label>
              <textarea name="keyword" class="form-control" placeholder="Enter keyword and must using space" required="required"></textarea>
              <small><?php echo $keywordErr; ?></small>                  
            </div>
            <div class="form-group">
              <label>Reply Text(EN)</label>
              <textarea name="reply_text_en" class="form-control" placeholder="Reply Text in English" required="required"></textarea>
              <small><?php echo $reply_enErr; ?></small> 
            </div>
            <div class="form-group">
              <label>Reply Text(BN)</label>
              <textarea name="reply_text_ban" class="form-control" placeholder="Reply Text in Bangla" required="required"></textarea>
              <small><?php echo $reply_bnErr; ?></small> 
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