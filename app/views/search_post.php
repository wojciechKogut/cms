<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="col-md-12" style="padding-bottom: 28%; margin-bottom: 2em;">
            <div class="row">


    
        <!-- Blog Entries Column -->
        
        
        <div class="col-md-7 col-sm-10 col-xs-7 col-lg-6 ml-auto" style="background-color:#fff;">
          <!-- <h1 class="my-4">Page Heading
            <small>Secondary Text</small>
          </h1> -->

          <!-- Blog Post -->
          <?php 
          

          $msg = $params[2];
          $search = $params[0];
          $counts_results = $params[3];
          $keywords = $params[4];
          $recent   = $params[5];
          ?>
          
          
          <?php 
          
          if(!empty($msg)){
              echo "<div class='alert alert-info'>".$msg . "<a href='".ROOT."'> See other posts</a></div>";
          }
          
          ?>
          
          
          <?php if(!empty($search)): ?> 
          <h2> <?php echo "Found" . (!empty($counts_results)) ? $counts_results : "" ; ?> results for <b> <?php echo (!empty($keywords)) ? " '".$keywords."'" : ""  ?></b> </h2>
          <ol>
          <?php foreach ($search as $post): ?>
          
              <li><a href="<?php echo ROOT ?>users/post/<?php echo $post->slug ?>">Post title: <?php echo $post->post_title ?></a>

          <?php endforeach; ?>
          </ol>
          
          <?php endif; ?>
          
          
          <nav aria-label="Page navigation example">
              <ul class="pagination">
                  
              </ul>
          </nav>
         
            

          <!-- Blog Post -->
        </div>


        <!-- Sidebar Widgets Column -->
        <div class="col-md-3 col-sm-2 col-xs-3 col-lg-2 mr-auto" style="background-color:#fff;">

          <!-- Search Widget -->
          <?php include "includes/search.php"; ?>
          <!-- Search Widget -->
          
 
          <!-- Categories Widget -->
          <div class="card my-4">
            <h5 class="card-header">Categories</h5>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12">
                  <ul class="list-unstyled mb-0">
                   
                <?php
                
                    $categories = $params[1];
                   ?>
                        <?php foreach ($categories as $category) : ?>
                      
                              <li class="list-group-item" style="border:none"><b><a style="color:<?php echo $category['color']; ?>" href="<?php echo ROOT ?>posts/post_cat/<?php echo $category['slug']?>"><?php echo $category['cat_title'] ?></a></b></li>

                        <?php endforeach; ?> 
                  </ul>
                </div>
              </div>
            </div>
          </div>
          
          <div class="card my-5">
              <h5 class="card-header mt-0">Recent Activity</h5>
              <div class="card-body" style="padding:0">
                  <div class="row">
                      <div class="col-md-12" style="margin:0; padding:0 1.5rem;">
                          <ul class="list-unstyled mb-0">

                              <?php foreach ($recent as $post) : ?>

                                <li class="list-group-item" style="border:1px solid black; width:100%">
                                    <a style="color: black" href="#"><b>Title: </b> <i>'<?php echo $post->post_title ?>'</i></a> by
                                    <span><?php echo $post->post_user_id === 0 ? $post->post_author : $post->user->user_name ?></span>
                                </li>

                              <?php endforeach; ?>  

                          </ul>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Side Widget -->
         
          <?php // include "includes/widget.php"; ?>

        </div>

      </div>
         </div>
        </div>
    </div>
</div>



<?php include "includes/footer.php"; ?>

