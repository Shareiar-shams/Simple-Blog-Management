<?php

	$id = $_GET['id'];

	require_once '../db.php'; 
	require_once '../app/dashboard-controller.php'; 
	$bot = new Dashboard_Controller();

	$blog = $bot->selectData('blogs', '*', "`id` = '$id'",1);

	if(isset($blog['updated_at']))
        $date = new DateTime($blog['updated_at']);
    else
        $date = new DateTime($blog['created_at']);

    $date = $date->format('M d, Y');

	$conditions = "`id` = ".$blog['category_id'];
    $category = $bot->selectData('categories','title',$conditions,1);
?>

<!-- News Detail Start -->
<div class="position-relative mb-3">
    <img class="img-fluid w-100" src="../<?php echo $blog['featured_image'] ?>" style="object-fit: cover;">
    <div class="bg-white border border-top-0 p-4">
        <div class="mb-3">
            <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                href=""><?php echo $category['title']; ?></a>
            <a class="text-body" href=""><?php echo $date; ?></a>
        </div>
        <h1 class="mb-3 text-secondary text-uppercase font-weight-bold"><?php echo $blog['title']; ?></h1>
        <p><?php echo $blog['description']; ?></p>
    </div>
    
</div>
<!-- News Detail End -->