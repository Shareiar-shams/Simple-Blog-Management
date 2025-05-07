<?php

	require_once '../db.php'; 
	require_once '../app/dashboard-controller.php'; 
	$bot = new Dashboard_Controller();

	$conditions = "`title` != ''";
	$limit_blogs = $bot->selectData('blogs','*',$conditions,3);
	$nm_row_limit_blogs = count($limit_blogs);

	$conditions = "`title` != '' ORDER BY `id` ASC";
	$blogs = $bot->selectData('blogs','',$conditions,'');
	$nm_row_blog = count($blogs);
?>

<div class="row">
    <div class="col-lg-7 px-0">
        <div class="owl-carousel main-carousel position-relative">
        	<?php 
        	if($nm_row_limit_blogs > 0)
            {
            	foreach ($limit_blogs as $key => $value) {

	                $id = $value['id'];
	                $title = $value['title'];
	                $slug = $value['slug'];
	                $image = $value['featured_image'];

	                
	                if(isset($value['updated_at']))
		                $date = new DateTime($value['updated_at']);
		            else
		            	$date = new DateTime($value['created_at']);

					$date = $date->format('M d, Y');

	                $conditions = "`id` = ".$value['category_id'];
					$category = $bot->selectData('categories','title',$conditions,1);
					$short_description = limit_words($value['short_description'],30)
            	?>
                    <div class="position-relative overflow-hidden" style="height: 500px;">
                        <img class="img-fluid h-100" src="../<?php echo $image ?>" style="object-fit: cover;">
                        <div class="overlay">
                            <div class="mb-2">
                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                    href=""><?php echo $category['title']; ?></a>
                                <a class="text-white" href=""><?php echo $date ?></a>
                            </div>
                            <a class="h2 m-0 text-white text-uppercase font-weight-bold" href=""><?php echo $short_description ?></a>
                        </div>
                    </div>
                <?php
	            }
            }
            ?>
        </div>
    </div>
    <div class="col-lg-5 px-0">
        <div class="row mx-0">
        	<?php 
        	if($nm_row_blog > 0)
            {
            	foreach ($blogs as $key => $value) {

	                $id = $value['id'];
	                $title = $value['title'];
	                $slug = $value['slug'];
	                $image = $value['featured_image'];

	                
	                if(isset($value['updated_at']))
		                $date = new DateTime($value['updated_at']);
		            else
		            	$date = new DateTime($value['created_at']);

					$date = $date->format('M d, Y');

	                $conditions = "`id` = ".$value['category_id'];
					$category = $bot->selectData('categories','title',$conditions,1);
					$short_description = limit_words($value['short_description'], 10)
            	?>
		            <div class="col-md-6 px-0">
		                <div class="position-relative overflow-hidden" style="height: 250px;">
		                    <img class="img-fluid w-100 h-100" src="../<?php echo $image; ?>" style="object-fit: cover;">
		                    <div class="overlay">
		                        <div class="mb-2">
		                            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
		                                href=""><?php echo $category['title']; ?></a>
		                            <a class="text-white" href=""><small><?php echo $date; ?></small></a>
		                        </div>
		                        <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href=""><?php echo $short_description; ?></a>
		                    </div>
		                </div>
		            </div>
	            <?php
		            }
	        }
        	?>
        </div>
    </div>
</div>