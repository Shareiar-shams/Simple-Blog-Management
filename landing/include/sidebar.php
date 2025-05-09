<?php
    require_once '../db.php'; 
    require_once '../app/dashboard-controller.php'; 
    $bot = new Dashboard_Controller();

    $conditions = "`title` != ''";
    $tags = $bot->selectData('tags','',$conditions,'');
    $nm_row_tags = count($tags);

    $conditions = "`title` != ''";
    $t_blogs = $bot->selectData('blogs','*',$conditions,4);
    $nm_row_blog = count($t_blogs);

    $conditions = "`title` != '' ORDER BY `id` DESC";
    $all_blog = $bot->selectData('blogs','',$conditions,'');
    $nm_row_all_blog = count($all_blog);

?>


<!-- News With Sidebar Start -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title">
                            <h4 class="m-0 text-uppercase font-weight-bold">Latest News</h4>
                            <a class="text-secondary font-weight-medium text-decoration-none" href="">View All</a>
                        </div>
                    </div>
                    <?php 
                        if($nm_row_all_blog > 0):

                            foreach($all_blog as $index => $value): 
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
                                $short_description = limit_words($value['short_description'],30);
                                ?>
                                    <div class="col-lg-6">
                                        <div class="position-relative mb-3">
                                            <img class="img-fluid w-100" src="../<?php echo $image ?>" style="object-fit: cover;">
                                            <div class="bg-white border border-top-0 p-4">
                                                <div class="mb-2">
                                                    <a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2"
                                                        href=""><?php echo $category['title']; ?></a>
                                                    <a class="text-body" href=""><small><?php echo $date ?></small></a>
                                                </div>
                                                <a class="h4 d-block mb-3 text-secondary text-uppercase font-weight-bold" href="details.php?id=<?php echo $id ?>"><?php echo $title ?></a>
                                                <p class="m-0"><?php echo $short_description ?></p>
                                            </div>
                                        </div>
                                    </div>

                                <?php if ($index == 2 || $index == 7): ?>
                                    <div class="col-lg-12 mb-3">
                                        <a href=""><img class="img-fluid w-100" src="img/ads-728x90.png" alt=""></a>
                                    </div>
                                <?php endif;
                            endforeach;
                        endif; ?>
                    ?>
                    
                    
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Social Follow Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Follow Us</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #39569E;">
                            <i class="fab fa-facebook-f text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Fans</span>
                        </a>
                        <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #52AAF4;">
                            <i class="fab fa-twitter text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Followers</span>
                        </a>
                        <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #0185AE;">
                            <i class="fab fa-linkedin-in text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Connects</span>
                        </a>
                        <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #C8359D;">
                            <i class="fab fa-instagram text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Followers</span>
                        </a>
                        <a href="" class="d-block w-100 text-white text-decoration-none mb-3" style="background: #DC472E;">
                            <i class="fab fa-youtube text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Subscribers</span>
                        </a>
                        <a href="" class="d-block w-100 text-white text-decoration-none" style="background: #055570;">
                            <i class="fab fa-vimeo-v text-center py-4 mr-3" style="width: 65px; background: rgba(0, 0, 0, .2);"></i>
                            <span class="font-weight-medium">12,345 Followers</span>
                        </a>
                    </div>
                </div>
                <!-- Social Follow End -->

                <!-- Ads Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Advertisement</h4>
                    </div>
                    <div class="bg-white text-center border border-top-0 p-3">
                        <a href=""><img class="img-fluid" src="img/news-800x500-2.jpg" alt=""></a>
                    </div>
                </div>
                <!-- Ads End -->

                <!-- Popular News Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Tranding News</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        <?php 
                            if($nm_row_tags > 0)
                            {
                                foreach ($t_blogs as $key => $value) {

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
                                    
                                ?>
                                    <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                        <img class="img-fluid" height="100" width="100" src="../<?php echo $image ?>">
                                        <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                            <div class="mb-2">
                                                <a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href=""><?php echo $category['title']; ?></a>
                                                <a class="text-body" href=""><small><?php echo $date; ?></small></a>
                                            </div>
                                            <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="details.php?id=<?php echo $id ?>"><?php echo $title ?></a>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                        ?>
                    </div>
                </div>
                <!-- Popular News End -->

                <!-- Newsletter Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Newsletter</h4>
                    </div>
                    <div class="bg-white text-center border border-top-0 p-3">
                        <p>Aliqu justo et labore at eirmod justo sea erat diam dolor diam vero kasd</p>
                        <div class="input-group mb-2" style="width: 100%;">
                            <input type="text" class="form-control form-control-lg" placeholder="Your Email">
                            <div class="input-group-append">
                                <button class="btn btn-primary font-weight-bold px-3">Sign Up</button>
                            </div>
                        </div>
                        <small>Lorem ipsum dolor sit amet elit</small>
                    </div>
                </div>
                <!-- Newsletter End -->

                <!-- Tags Start -->
                <div class="mb-3">
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold">Tags</h4>
                    </div>
                    <div class="bg-white border border-top-0 p-3">
                        <div class="d-flex flex-wrap m-n1">
                            <?php 
                            if($nm_row_tags > 0)
                            {
                                foreach ($tags as $key => $value) {

                                    $id = $value['id'];
                                    $title = $value['title'];
                                    $slug = $value['slug'];
                                ?>
                                    <a href="" class="btn btn-sm btn-outline-secondary m-1"><?php echo $title; ?></a>

                                <?php
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>
                <!-- Tags End -->
            </div>
        </div>
    </div>
</div>
<!-- News With Sidebar End -->