<?php
  require_once 'db.php'; 

  require_once 'app/dashboard-controller.php'; 
  $bot = new Dashboard_Controller();

  $titleErr = $subTitleErr = $slugErr = $imageErr = $short_descriptionErr = $descriptionErr = $categoryErr = $tagsErr = "";
  $title = $subtitle = $slug = $image = $short_description = $description = $descriptionErr = $category = $tags = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

     if (empty($_POST["title"])) {
       $titleErr = "Title is required";
     } else {
       $title = $_POST["title"];
     }

     if (empty($_POST["subtitle"])) {
       $subTitleErr = "SubTitle is required";
     } else {
       $subtitle = $_POST["subtitle"];
       
     }

     if (empty($_POST["slug"])) {
       $slugErr = "Slug is required";
     } else {
       $slug = $_POST["slug"];
       
     }

     if (empty($_POST["short_description"])) {
       $short_descriptionErr = "Short Description is required";
     } else {
       $short_description = $_POST["short_description"];
       
     }

     if (empty($_POST["description"])) {
       $descriptionErr = "Description is required";
     } else {
       $description = $_POST["description"];
       
     }

     if (empty($_POST["category_id"])) {
       $categoryErr = "Category is required";
     } else {
       $category = $_POST["category_id"];
       
     }

     if (empty($_POST["tags"])) {
       $tagsErr = "Tag is required";
     } else {
       $tags = $_POST["tags"];
       
     }

     $id = $_POST["get_id"];

      $request_image = $_FILES['image'];
      if($request_image){
          $imageName = $request_image['name'];
          $imageTmpName = $request_image['tmp_name'];
          $imageSize = $request_image['size'];
          $imageError = $request_image['error'];
          $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
          $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

          if (!in_array($imageExt, $allowedExt)) {
              $imageErr = "Only JPG, PNG, JPEG & GIF allowed.";
          } elseif ($imageError !== 0) {
              $imageErr = "Image upload error.";
          } elseif ($imageSize > 5 * 1024 * 1024) { // 5MB limit
              $imageErr = "Image size too large.";
          } else {
              $newImageName = time() . "_" . basename($imageName);
              $image = "uploads/" . $newImageName;
              move_uploaded_file($imageTmpName, $image);
          }
      }
      


     if(!empty($title) && !empty($subtitle) && !empty($slug) && !empty($short_description) && !empty($description) && !empty($category) && !empty($tags)){
        $conditons = "`id` = '$id'";
        $value = array(
          "title" => $title,
          "subTitle" => $subtitle,
          "slug" => $slug,
          "short_description" => $short_description,
          "description" => $description,
          "category_id" => $category,
          "updated_at" => date('Y-m-d H:i:s') 
        );

        if (!empty($image))
          $value["featured_image"] = $image;

        $put_data = $bot->updateData('blogs',$value,$conditons);


        if($put_data !== false)
        {
            $condition = "`blog_id` = $id";
            $sessionData = $bot->delete('blog_tag',$condition);

            foreach ($tags as $tag) {
                $tagValue = array(
                  "blog_id" => $id,
                  "tag_id" => $tag
                );
                $pivotSql = $bot->insertData('blog_tag',$tagValue);
                
            }
            $_SESSION['success_message'] = "Blog Update successfully.";
            header("Location: index.php");
        }
        else{
            $_SESSION['error_message'] = "Some problem found.";
            header("Location: index.php");
        }
        exit();
     }
  }

  $slug = $_GET['slug'];
  $conditons = "`slug` = '".$slug."'";
  $check_data = $bot->selectData('blogs','',$conditons,'');

  $get_id = $check_data[0]['id'];
  $title = $check_data[0]['title'];
  $subtitle = $check_data[0]['subTitle'];
  $slug = $check_data[0]['slug'];
  $image = $check_data[0]['featured_image'];
  $short_description = $check_data[0]['short_description'];
  $description = $check_data[0]['description'];
  $category_id = $check_data[0]['category_id'];

  $conditions = "`title` != '' ORDER BY `id` DESC";
  $categories = $bot->selectData('categories','',$conditions,'');
  $nm_row_category = count($categories);

  $conditions = "`title` != '' ORDER BY `id` ASC";
  $tags = $bot->selectData('tags','',$conditions,'');
  $nm_row_tag = count($tags);


  $tagLinks = $bot->selectData('blog_tag', 'tag_id', "`blog_id` = '{$get_id}'");

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
                    <label>Title *</label>
                    <input type="text" name="title" onkeyup="listingslug(this.value)" id="title" class="form-control" placeholder="Enter Title" value="<?php echo $title ?>" required="required">
                    <small><?php echo $titleErr; ?></small>
                  </div>
                  <input type="hidden" name="get_id" value="<?php echo $get_id ?>">
                  <div class="form-group">
                    <label>Slug *</label>
                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Enter Slug" value="<?php echo $slug ?>" required="required">
                    <small><?php echo $slugErr; ?></small>
                  </div>

                  <div class="form-group">
                    <label>SubTitle *</label>
                    <input type="text" name="subtitle" class="form-control" value="<?php echo $subtitle ?>" placeholder="Enter Sub Title" required="required">
                    <small><?php echo $subTitleErr; ?></small>                  
                  </div>
                  <div class="card-body">
                    <img src="<?php echo $image; ?>"  class="profile-user-img img-responsive" alt="Selected Featured Image" id="output">
                    <div class="form-group">
                        <label for="exampleInputFile">Featured Image *</label>
                        <div class="input-group">
                          <div class="custom-file">
                              <input type="file" accept="image/*" onchange="loadFile(event)" name="image" class="custom-file-input" id="FeaturedImageInputFile">
                              <label class="custom-file-label" for="exampleInputFile">Upload Image</label>
                          </div>
                        </div>
                    </div>
                      <small style="color: blue;">Image Size Should Be 800 x 800. or square size</small>
                  </div>
                  <div class="form-group">
                    <label>Tags *</label>
                    <select class="select2bs4" multiple="multiple" name="tags[]" data-placeholder="Select Tags" style="width: 100%;" required>
                      <?php
                      if($nm_row_tag > 0)
                      {
                        $selectedTagIds = array_column($tagLinks, 'tag_id');
                        foreach ($tags as $tag) {
                          $selected = in_array($tag['id'], $selectedTagIds) ? 'selected' : '';
                          ?>
                            <option value="<?php echo $tag['id']; ?>" <?php echo $selected; ?>>
                                <?php echo $tag['title']; ?>
                            </option>
                          <?php
                        }
                      }
                    ?>
                    </select>
                    <small><?php echo $tagsErr; ?></small>
                  </div>
                  <!-- /.form-group -->

                  <div class="from-group">
                    <label for="exampleInputEmail1">Short Description *</label>
                      <textarea class="form-control" name="short_description" placeholder="Short Description"><?php echo $short_description ?></textarea>
                  </div>
                  <div class="from-group mt-3">
                    <label for="exampleInputEmail1">Description *</label>
                      <textarea id="summernote" name="description" placeholder="Description" required><?php echo $description ?></textarea>
                  </div>

                  <div class="form-group">
                      <label>Select Category *</label>
                      <select class="form-control" name="category_id" id="category" style="width: 100%;" required>
                          <option >Select One</option>
                          <?php
                          if($nm_row_category > 0)
                          {
                            foreach ($categories as $key => $category) {
                          ?>
                          <option value="<?php echo $category['id'] ?>" selected="<?php $category['id'] === $category_id ? 'selected' : '' ?>"><?php echo $category['title']  ?></option>
                          <?php
                            }
                          }
                        ?>
                          
                      </select>
                      <small><?php echo $categoryErr; ?></small>
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

<script type="text/javascript">
  var loadFile = function(event) {
    var image = document.getElementById('output');
    image.src = URL.createObjectURL(event.target.files[0]);
  };
</script>