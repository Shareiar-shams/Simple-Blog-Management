<?php
  require_once 'db.php'; 
  require_once 'app/dashboard-controller.php'; 
  $bot = new Dashboard_Controller();
  // define variables and set to empty values
  $titleErr = $subTitleErr = $slugErr = $imageErr = $short_descriptionErr = $descriptionErr = $categoryErr = $tagsErr = "";
  $title = $subtitle = $slug = $image = $short_description = $description = $descriptionErr = $category = $tags = "";

  $conditions = "`title` != '' ORDER BY `id` DESC";
  $categories = $bot->selectData('categories','',$conditions,'');
  $nm_row_category = count($categories);

  $conditions = "`title` != '' ORDER BY `id` ASC";
  $tags = $bot->selectData('tags','',$conditions,'');
  $nm_row_tag = count($tags);

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

        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageSize = $image['size'];
        $imageError = $image['error'];
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

	     if(!empty($title) && !empty($subtitle) && !empty($slug) && !empty($short_description) && !empty($description) && !empty($category) && !empty($tags) && !empty($image)){

	       
          $conditons = "`slug` = '$slug'";
          $chack_data = $bot->selectData('blogs','id',$conditons,1);

          if ($chack_data > 0) {
              $_SESSION['success_message'] = "This Blog already Exists.";
          }
          else{
              $value = array(
                "title" => $title,
                "subTitle" => $subtitle,
                "slug" => $slug,
                "short_description" => $short_description,
                "description" => $description,
                "category_id" => $category,
                "featured_image" => $image,
                "created_at" => date('Y-m-d H:i:s') 
              );
              $put_data = $bot->insertData('blogs',$value,true);
              
              if ($put_data['status'] === true) {
                  $insertedId = $put_data['id'];

                  foreach ($tags as $tag) {
                      $tagValue = array(
                        "blog_id" => $insertedId,
                        "tag_id" => $tag
                      );
                      $pivotSql = $bot->insertData('blog_tag',$tagValue);
                      
                  }
                  $_SESSION['success_message'] = "Blog Upload successfully.";
              }else{
                  $_SESSION['error_message'] = "Something want wrong.";
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
                <h3 class="card-title">Blog List</h3>
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

          if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) { ?>
              <div class="error-message" style="margin-bottom: 20px;font-size: 20px;color: red;"><?php echo $_SESSION['error_message']; ?></div>
              <?php
              unset($_SESSION['error_message']);
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
                <?php
                  $sr=0;
                  $conditons = "`id` != '' ORDER BY `id` DESC";
                  $results = $bot->selectData('blogs','',$conditons,'');
                  $nm_row = count($results);
                if($nm_row > 0)
                {
                  foreach ($results as $key => $value) {
                    $id = $value['id'];
                    $title = $value['title'];
                    $slug = $value['slug'];
                    $image = $value['featured_image'];
                  ?>
                    <tr>
                        <th scope="row"><?php echo ++$sr; ?></th>
                        <td><?php echo $title; ?></td>
                        <td><img src="<?php echo $image; ?>" height="50" width="50" alt=""></td>
                        <?php 
                          // Tags
                          $tagLinks = $bot->selectData('blog_tag', 'tag_id', "`blog_id` = '{$value['id']}'",'');
                          $tag_titles = [];
                          foreach ($tagLinks as $link) {
                              $tag = $bot->selectData('tags', 'title', "`id` = '{$link['tag_id']}'", 1);
                              if (!empty($tag)) {
                                  $tag_titles[] = "<span class='tag-box'>{$tag['title']}</span>";
                              }
                          }
                          echo "<td>" . implode(' ', $tag_titles) . "</td>";

                          // Category title
                          $category = $bot->selectData('categories', 'title', "`id` = '{$value['category_id']}'", 1);
                          echo "<td>" . ($category['title'] ?? 'N/A') . "</td>";

                        ?>
                        <td>
                          <div class="btn-group">
                            <button type="button" class="btn btn-default">Action</button>
                            <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                              <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                              <a class="dropdown-item" href="updateblog.php?slug=<?php echo $slug; ?>">Edit</a>
                              <a class="dropdown-item" href="updateblog.php?slug=<?php echo $slug; ?>">View</a>
                              <a class="dropdown-item" href="delete.php?id=<?php echo $id; ?>" onclick="return confirm('Are you sure you want to delete this Blog?');">Delete</a>
                            </div>
                          </div>
                        </td>
                        
                    </tr>
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
              <label>Title *</label>
              <input type="text" name="title" onkeyup="listingslug(this.value)" id="title" class="form-control" placeholder="Enter Title" required="required">
              <small><?php echo $titleErr; ?></small>
            </div>

            <div class="form-group">
              <label>Slug *</label>
              <input type="text" name="slug" id="slug" class="form-control" placeholder="Enter Slug" required="required">
              <small><?php echo $slugErr; ?></small>
            </div>

            <div class="form-group">
              <label>SubTitle *</label>
              <input type="text" name="subtitle" class="form-control" placeholder="Enter Sub Title" required="required">
              <small><?php echo $subTitleErr; ?></small>                  
            </div>
            <div class="card-body">
              <img src="" class="profile-user-img img-responsive" alt="Selected Featured Image" id="output">
              <div class="form-group">
                  <label for="exampleInputFile">Featured Image *</label>
                  <div class="input-group">
                    <div class="custom-file">
                        <input type="file" accept="image/*" onchange="loadFile(event)" name="image" class="custom-file-input" id="FeaturedImageInputFile" required>
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
                  foreach ($tags as $key => $tag) {
                ?>
                    <option value="<?php echo $tag['id'] ?>"><?php echo $tag['title'] ?></option>
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
                <textarea class="form-control" name="short_description" placeholder="Short Description"></textarea>
            </div>
            <div class="from-group mt-3">
              <label for="exampleInputEmail1">Description *</label>
                <textarea id="summernote" name="description" placeholder="Description" required></textarea>
            </div>

            <div class="form-group">
                <label>Select Category *</label>
                <select class="form-control" name="category_id" id="category" style="width: 100%;" required>
                    <option selected="selected">Select One</option>
                    <?php
                    if($nm_row_category > 0)
                    {
                      foreach ($categories as $key => $category) {
                    ?>
                    <option value="<?php echo $category['id']  ?>" ><?php echo $category['title']  ?></option>
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
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

