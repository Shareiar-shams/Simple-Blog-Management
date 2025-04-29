<?php
  require_once 'db.php'; 

  require_once 'app/dashboard-controller.php'; 
  $bot = new Dashboard_Controller();

  $packErr = $priceErr = $paramErr = $keywordErr = $reply_enErr = $reply_bnErr = "";
  $update_pack = $update_price = $update_param = $update_keyword = $update_reply_en = $update_reply_bn = "";

  $id = $_GET['id'];
  $conditons = "`id` = '".$id."'";
  $check_data = $bot->selectData('blogs','',$conditons,'');

  $get_id = $check_data[0]['id'];
  $pack = $check_data[0]['pack_name'];
  $price = $check_data[0]['pack_price'];
  $param = $check_data[0]['param_en'];
  $keyword = $check_data[0]['keywords'];
  $reply_en = $check_data[0]['reply_text_en'];
  $reply_bn = $check_data[0]['reply_text_ban'];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

     if (empty($_POST["update_pack_name"])) {
       $packErr = "Name is required";
     } else {
       $update_pack = $_POST["update_pack_name"];
     }

     if (empty($_POST["update_pack_price"])) {
       $priceErr = "Price is required";
     } else {
       $update_price = $_POST["update_pack_price"];
       
     }

     if (empty($_POST["update_param_en"])) {
       $paramErr = "Param is required";
     } else {
       $update_param = $_POST["update_param_en"];
       
     }

     if (empty($_POST["update_keyword"])) {
       $keywordErr = "Keyword is required";
     } else {
       $update_keyword = $_POST["update_keyword"];
       
     }

     if (empty($_POST["update_reply_text_en"])) {
       $reply_enErr = "reply text is required";
     } else {
       $update_reply_en = $_POST["update_reply_text_en"];
       
     }

     if (empty($_POST["update_reply_text_ban"])) {
       $reply_bnErr = "reply text is required";
     } else {
       $update_reply_bn = $_POST["update_reply_text_ban"];
       
     }

     $update_category = $_POST["update_category"];

     $id = $_POST["get_id"];

     if(!empty($_POST['update_pack_name']) && !empty($_POST['update_pack_price']) && !empty($_POST['update_param_en']) && !empty($_POST['update_keyword']) && !empty($_POST['update_reply_text_en']) && !empty($_POST['update_reply_text_ban'])){
        $conditons = "`id` = '$id'";
        $value = array(
            "param_en" => $update_param,
            "keywords" => $update_keyword,
            "reply_text_en" => $update_reply_en,
            "reply_text_ban" => $update_reply_bn,
            "pack_name" => $update_pack,
            "pack_price" => $update_price,
        );
        $put_data = $bot->updateData('blogs',$value,$conditons);
        if($put_data !== false)
        {
            $_SESSION['success_message'] = "Pack Update successfully.";
            header("Location: index.php");
        }
        else{
            $_SESSION['success_message'] = "Some problem found.";
            header("Location: index.php");
        }
        exit();
     }
  }

?>


	<!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Update Blog</h1>
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
              <div class="card-header">
                <h3 class="card-title">Blog Update <small>here</small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">
                <div class="form-group">
                  <label>Pack Name/CBS</label>
                  <input type="text" name="update_pack_name" class="form-control" value="<?php echo $pack; ?>">
                  <small><?php echo $packErr; ?></small>
                </div>
                <div class="form-group">
                  <label>Pack Price</label>
                  <input type="number" name="update_pack_price" class="form-control" value="<?php echo $price; ?>">
                  <small><?php echo $priceErr; ?></small>                  
                </div>
                <div class="form-group">
                  <label>English Param</label>
                  <input type="text" name="update_param_en" class="form-control" value="<?php echo $param; ?>">
                  <small><?php echo $paramErr; ?></small>                  
                </div>
                <input type="hidden" name="update_category" value="pack">
                <input type="hidden" name="get_id" value="<?php echo $get_id ?>">
                <div class="form-group">
                  <label>Keyword</label>
                  <textarea name="update_keyword" class="form-control" ><?php echo $keyword; ?></textarea>
                  <small><?php echo $keywordErr; ?></small>                  
                </div>
                <div class="form-group">
                  <label>Reply Text(EN)</label>
                  <textarea name="update_reply_text_en" class="form-control"><?php echo $reply_en; ?></textarea>
                  <small><?php echo $reply_enErr; ?></small> 
                </div>
                <div class="form-group">
                  <label>Reply Text(BN)</label>
                  <textarea name="update_reply_text_ban" class="form-control"><?php echo $reply_bn; ?></textarea>
                  <small><?php echo $reply_bnErr; ?></small> 
                </div>
              </div>
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