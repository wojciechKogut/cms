<div class="content-wrapper">
    <div class="container-fluid">
        <div class="col-md-12" style="">
            <div class="row">
    
        <!-- Blog Entries Column -->
        
        
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-10 ml-auto" style="background-color:#fff; padding-bottom: 8em;">

          <!-- Blog Post -->
          <?php 
            $posts = $params[0];
            $count_rows = $params[1];
            $current_page = $params[2];
            $categories = $params[3];
            $pagination = $params[4];
            $recent = $params[5];


            ?>
         
          
          
          <div class="col-md-12 pt-5 p-0">
              
          <?php if ($count_rows == 0) echo "<div class='alert alert-info'><p style='font-weight:bold;'>No posta available</p></div>";
            else echo ""; ?>
        <div class="col-md-12 col-lg-12 col-md-12">
            <?php if ($current_page == 1 || $current_page == 0) : ?>
            <div class="card mx-auto" style="border:none">
                <div class="col-md-12 p-0">
                    
                        <div class="col-md-12 col-lg-12 col-xl-8">
                            <ul class="rslides card-img-top mx-auto" style="position:relative;">
                                <?php foreach ($posts as $post) : ?>
                                    <li><a href="<?php echo ROOT . "users/post/" . $post->slug ?>"><img class="img-fluid" src="<?php echo ROOT . "images/upload_img/" . $post->post_image ?>" alt="" srcset=""></a><div class="card-body">
                                <div id="sliderCaption"><p><?php echo $post->post_title . ": " . strip_tags(html_entity_decode(truncate($post->post_content))); ?></p></div>
                            </div>  </li>

                                <?php endforeach; ?>
                            </ul>   
                        </div>
                        <div class="col-lg-12 col-xl-4 p-0">
                        <a class="text-light" href="<?php echo ROOT . "users/register" ?>"><div class="col-md-6 col-lg-6 bg-dark mainButtons text-light p-0" style="margin-right: 5px;"><span class="center">Register</span></div></a>
                        <a class="text-light" href="<?php echo ROOT . "users/login" ?>"><div class="col-md-6 col-lg-6 bg-dark mainButtons text-light p-0" style="margin-right:5px"><span class="center">Login</span></div></a>
                        <a href="#" class="text-light"><div class="col-md-6 col-lg-6 bg-dark mainButtons text-light p-0"  style="margin-right:5px;"><span class="center">Contact</span></div></a>
                        <a class="text-light" href="#"><div class="col-md-6 col-lg-6 bg-dark mainButtons text-light p-0"><span class="center">Services</span></div></a>
                        </div>
                </div> 
            </div>
            
            <?php endif; ?>
        </div>
        <?php if ($current_page == 1 || $current_page == 0) : ?>
            <div class="col-md-12 intro"><div class="text-light text-center" style="position:absolute; top:50%; transform:translateY(-50%); left:50%; transform:translateX(-50%); width:70%">Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur nesciunt incidunt blanditiis eos.</div></div>
        <?php endif; ?>
          <?php foreach ($posts as $post) : ?>
          
                <div class="col-md-1 my-5" style="position:relative; height:235px;">
                    <div style="position:absolute; left:50%; transform:translateX(-50%); top:60%; transform:translateY(-50%); font-size:50px;"><i class="fa fa-angle-down" style="opacity:0.6"></i></div>
                    <div style="position:absolute; left:60%; transform:translateX(-50%);top:50%; transform:translateY(-50%); "><?php echo $post->likes->count() ?></div>
                    <div style="position:absolute; left:50%; transform:translateX(-50%);top:40%; transform:translateY(-50%); font-size:50px;"><i class="fa fa-angle-up"></i></div>
                </div>
              <div class="col-md-11">
                <div class="card mt-5 mb-5" style="box-shadow: 0.2px 0.5px">
                    <div class="card-body">
                       <h4 class="card-title"><a href="<?php echo ROOT . "users/post/" . $post->slug ?>"><?php echo $post->post_title; ?></h4></a>
                        <p class="lead">
                            by
                            <img class="img-size img-circle" src="<?php echo $post->get_user_img($post->post_user_id); ?>" alt="">
                            <a href="#"><?php echo ($post->post_user_id == 0) ? $post->post_author : $post->user->user_name; ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"> Posted  <?php echo Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->post_date)->diffForHumans(); ?></span>
                            <span class="ml-3">Category  <b><a href="<?php echo ROOT . "posts/post_cat/" . $post->category->slug ?>" style="color:<?php echo $post->category->color; ?>"><?php echo !empty($post->category->cat_title) ? $post->category->cat_title : "Uncategorized"; ?></a></b></span>
                        </p>
                        <div class="text-justify"><?php echo strip_tags(html_entity_decode(truncate($post->post_content))); ?></div>
                        <span class="mr-3">Comments: <?php echo $post->comments->count() ?></span>
                        <span class="">Views: <?php echo $post->post_views ?></span>
                        <a href="<?php echo ROOT ?>users/post/<?php echo $post->slug; ?>" class="btn btn-primary mb-5 pull-right">Read More &rarr;</a>
                    </div>
                </div>        
          </div>
                 
               
          <?php endforeach; ?>
          
        </div>
          
          <nav class="col-md-12" aria-label="Page navigation example" style="text-align:center">
              
              <?php if ($pagination->show_pagination()) : ?>
              
              <ul class="pagination">
                  <li class="page-item">
                      <?php if ($pagination->has_previous()) : ?>
                      <a class="page-link" href="<?php echo ROOT ?>pages/index/<?php echo $pagination->previous() ?>">Previous</a></li>
                      <?php endif; ?>
                      
                        <?php for ($i = 1; $i <= ceil($pagination->count); $i++) : ?>
                             <li class='page-item <?php echo $pagination->current_page == $i ? "active" : "" ?>'><a class='page-link' href='<?php echo ROOT ?>pages/index/<?php echo $i ?>'><?php echo $i ?></a></li>
                                             
                  <?php endfor; ?> 
                  <li class="page-item">
                      <?php if ($pagination->has_next()) : ?>
                      <a class="page-link" href="<?php echo ROOT ?>pages/index/<?php echo $pagination->next() ?>">Next</a></li>
                      <?php endif; ?>
              </ul>
              
              <?php endif; ?>
              
          </nav>
         
               
          <!-- Blog Post -->
        </div>


        <!-- Sidebar Widgets Column -->
        <div class="col-md-12 col-sm-12 col-xs-12 col-lg-2 mr-auto p-0" style="background-color: #fff; padding-bottom: 7em;">

          <!-- Search Widget -->
          <?php include "search.php"; ?>
          <!-- Search Widget -->
          
          <!-- Categories Widget -->
          <div class="card my-4">
              <h5 class="card-header mt-1">Categories</h5>
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-10 pr-0" >
                          <ul class="list-unstyled ml-1">

                              <?php foreach ($categories as $category) : ?>
                              <!--<input type="hidden" value="<?php //  $categories->slug; ?>" id="catSlug">-->
                              <li class="list-group-item" style="border:none"><b><a style="color:<?php echo $category['color']; ?>" href="<?php echo ROOT ?>posts/post_cat/<?php echo $category['slug'] ?>"><?php echo $category['cat_title'] ?></a></b></li>

                              <?php endforeach; ?>  

                          </ul>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Side Widget -->
          
           <div class="card my-5">
              <h5 class="card-header mt-0">Recent Activity</h5>
              <div class="card-body" style="padding:0">
                  <div class="row">
                      <div class="col-md-12" style="margin:0; padding:0 1.5rem;">
                          <ul class="list-unstyled mb-0">

                              <?php foreach ($recent as $post) : ?>

                                <li class="list-group-item" style="border-left: 3px solid #006699; width:100%;">
                                    <a style="color: black" href="#"><b>Title: </b> <i>'<?php echo $post->post_title ?>'</i></a> by
                                    <span><?php echo $post->post_user_id === 0 ? $post->post_author : $post->user->user_name ?></span>
                                </li>

                              <?php endforeach; ?>  

                          </ul>
                      </div>
                  </div>
              </div>
          </div>
         
          <?php // include "widget.php"; ?>

        </div>

            </div>
        </div>
    </div>
</div>
