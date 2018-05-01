<div class="content-wrapper">
    <div class="container-fluid">
        <div class="col-md-12" style="">
            <div class="row">
    
        <!-- Blog Entries Column -->
        
        
        <div class="col-md-7 col-sm-10 col-xs-7 col-lg-6 ml-auto" style="background-color:#fff; padding-bottom: 8em;">
          <!-- <h1 class="my-4">Posts
            <small>Secondary Text</small>
          </h1> -->

            
            <hr>
          <!-- Blog Post -->
          <?php 
            $posts        = $params[0];
            $count_rows   = $params[1];
            $current_page = $params[2];
            $categories   = $params[3];
            $pagination   = $params[4];
            $recent       = $params[5];
          ?>
         
          
          
          <div class="col-md-9" style="margin-left: 70px;">
              
          <?php if($count_rows == 0) echo "<div class='alert alert-info'><p style='font-weight:bold;'>No posta available</p></div>"; else echo ""; ?>

        <?php if($current_page == 1 || $current_page == 0): ?>
          <ul class="rslides mb-5" style="position:relative">
            <?php foreach ($posts as $post): ?>
                <li><a href="<?php echo ROOT . "users/post/". $post->slug ?>"><img src="<?php echo ROOT . "images/upload_img/". $post->post_image ?>" alt="" srcset=""></a><div id="sliderCaption"><p><?php echo $post->post_title . ": " . truncate($post->post_content) ?></p></div></li>
            <?php endforeach; ?>
         </ul>
         <?php endif; ?>
              
          <?php foreach ($posts as $post): ?>
              <div>
                <!-- <div style="width:70px; float:left;padding:20% 0;"><i style="font-size:30px" class="fa fa-angle-up"></i></div> -->
                <div class="card mt-5 mb-5" style="box-shadow: 0.2px 0.5px">
                    <div class="card-body">
                       <h4 class="card-title"><a href="<?php echo ROOT."users/post/".$post->slug ?>"><?php echo $post->post_title;  ?></h4></a>
                        <p class="lead">
                            by  <?php //  echo $post->get_user_img($post->post_user_id); ?>
                            <img class="img-size img-circle" src="<?php echo $post->get_user_img($post->post_user_id); ?>" alt="">
                            <a href="#"><?php echo ($post->post_user_id== 0) ? $post->post_author  : $post->user->user_name ;  ?></a>
                        </p>
                        <p><span class="glyphicon glyphicon-time"> Posted  <?php echo Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->post_date)->diffForHumans() ; ?></span>
                            <span class="ml-3">Category  <b><a href="<?php echo ROOT."posts/post_cat/".$post->category->slug ?>" style="color:<?php echo $post->category->color; ?>"><?php echo !empty($post->category->cat_title) ? $post->category->cat_title : "Uncategorized" ; ?></a></b></span>
                        </p>
                        <p class="text-justify"><?php echo truncate($post->post_content);?></p>
                        <a href="<?php echo ROOT ?>users/post/<?php echo $post->slug ; ?>" class="btn btn-primary mb-5">Read More &rarr;</a>
                    </div>
                </div>        
          </div>
               
               <!-- <a href="<?php //echo ROOT."users/post/".$post->id ?>">
                    <img class=" img-fluid mx-auto" style="width: 7em; height: 5em;" src="<?php echo ROOT."images/upload_img/" ; ?><?php echo $post->post_image ;   ?>" alt="Card image cap">
               </a> -->
               
               
               
               
          <?php endforeach; ?>
          
        </div>
          
          <nav class="col-md-12" aria-label="Page navigation example">
              
              <?php if($pagination->show_pagination()): ?>
              
              <ul class="pagination">
                  <li class="page-item">
                      <?php if ($pagination->has_previous()): ?>
                      <a class="page-link" href="<?php echo ROOT ?>pages/index/<?php echo $pagination->previous() ?>">Previous</a></li>
                      <?php endif; ?>
                      
                        <?php for($i=1; $i<= ceil($pagination->count) ; $i++): ?>
                             <li class='page-item <?php echo $pagination->current_page == $i ? "active" : "" ?>'><a class='page-link' href='<?php echo ROOT ?>pages/index/<?php echo $i ?>'><?php echo $i ?></a></li>
                                             
                  <?php endfor; ?> 
                  <li class="page-item">
                      <?php if ($pagination->has_next()): ?>
                      <a class="page-link" href="<?php echo ROOT ?>pages/index/<?php echo $pagination->next() ?>">Next</a></li>
                      <?php endif; ?>
              </ul>
              
              <?php endif; ?>
              
          </nav>
         
               
          <!-- Blog Post -->
        </div>


        <!-- Sidebar Widgets Column -->
        <div class="col-md-3 col-sm-2 col-xs-3 col-lg-2 mr-auto" style="background-color: #fff; padding-bottom: 7em;">

          <!-- Search Widget -->
          <?php include "search.php"; ?>
          <!-- Search Widget -->
          
          
        <!--</div>-->
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

                                <li class="list-group-item" style="border-left: 2px solid #bdb4b4; width:100%;">
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
