<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="col-md-12" style="padding-bottom: 8em;">
            <div class="row">


    
        <!-- Blog Entries Column -->
        
        
        <div class="col-md-7 col-lg-6 ml-auto" style="background-color:#fff;">
          <h1 class="my-4">Page Heading
            <small>Secondary Text</small>
          </h1>

            <hr>
          <!-- Blog Post -->
          <?php 
          
          $posts      = $params[0];
          $categories = $params[1];
          $count_rows = $params[2];
          $id         = $params[3];
          $pagination = $params[4];
          $recent     = $params[5];
          
         
        ?>
          
          
          <?php 
          
          if($count_rows == 0){
              echo "<div class='alert alert-info'><b>No posts available<a href='".ROOT."'> See other posts</a></b></div>";
          }
          
          ?>
          
          <div class="col-md-10">
          <?php foreach ($posts as $post): ?>
          
          <div class="card mt-5 mb-5" style="box-shadow: 0.2px 0.5px">
             <div class="card-body">
             <h4 class="card-title"><a href="<?php echo ROOT."users/post/".$post->slug ?>"><?php echo $post["post_title"];  ?></h4></a>
               <p class="lead">
                  by  
                  <img class="img-size img-circle" src="<?php echo $post->get_user_img($post["post_user_id"]); ?>" alt="">
                  <a href="#"><?php echo ($post->post_user_id== 0) ? $post->post_author  : $post->user->user_name ;  ?></a>
               </p>
               <p><span class="glyphicon glyphicon-time"> Posted on <?php echo $post->created_at->diffForHumans(); ?></span>
                   <span class="ml-3">Category  <b><a href="<?php echo ROOT."posts/post_cat/".$post->category->slug ?>" style="color:<?php echo $post->category->color; ?>"><?php echo $post->category->cat_title ;?></a></b></span>
               </p>
               <p class="text-justify"><?php echo (strlen($post->post_content)>100) ? substr($post->post_content,0,200)." (...)" : $post->post_content ?></p>
               <a href="<?php echo ROOT ?>users/post/<?php echo $post["slug"] ; ?>" class="btn btn-primary mb-5">Read More &rarr;</a>
            </div>
          </div>
            
               <!-- <a href="<?php// echo ROOT."users/post/".$post["id"] ?>">
                    <img class=" img-fluid mx-auto" style="width: 100%; height: 25em;" src="<?php echo ROOT."images/upload_img/" ; ?><?php echo $post["post_image"] ;   ?>" alt="Card image cap">
               </a> -->
               <!-- <hr> -->

          <?php endforeach; ?>
          </div>

          
          <nav aria-label="Page navigation example">
              
              <?php if($pagination->show_pagination()): ?>
              
              <ul class="pagination">
                  
                    <?php if ($pagination->has_previous()): ?>
                      <li class='page-item'>
                          <a class="page-link" href="<?php echo ROOT ?>posts/post_cat/<?php echo $id."/".$pagination->previous() ?>">Previous</a>
                      </li>
                    <?php endif; ?>
                    
                    
                    <?php for($i=1; $i<= $pagination->count ; $i++): ?>

                          <li class='page-item'><a class='page-link' href="<?php echo ROOT."posts/post_cat/$id/$i" ?>"><?php echo $i ?></a></li>

                    <?php endfor; ?> 

                    <?php if ($pagination->has_next()): ?>
                      <li class='page-item'>
                          <a class="page-link" href="<?php echo ROOT ?>posts/post_cat/<?php echo $id."/".$pagination->next() ?>">Next</a>
                          
                      </li>
                    <?php endif; ?>
                          
                          

              </ul>
              
              <?php endif; ?>
              
          </nav>
         

          <!-- Blog Post -->
        </div>


        <!-- Sidebar Widgets Column -->
        <div class="col-md-3 col-lg-2 mr-auto" style="background-color:#fff;">

          <!-- Search Widget -->
          <?php include "includes/search.php"; ?>
          <!-- Search Widget -->
          
                
          <!-- Categories Widget -->
          <div class="card my-4 mb-5">
            <h5 class="card-header mt-0">Categories</h5>
            <div class="card-body" style="padding:0">
              <div class="row">
                <div class="col-md-12" style="margin:0; padding:0 1.5rem;">
                  <ul class="list-unstyled mb-0">
                   
                    <?php foreach ($categories as $category) : ?>
                      
                      <input type="hidden" class="catSlug" style="color:<?php echo $category['color']; ?>" value="<?php echo $category['slug'] ?>">
                      <li class="list-group-item"  id="post-category" style="border:none"><b><a style="color:<?php echo $category['color']; ?>" href="<?php echo ROOT ?>posts/post_cat/<?php echo $category['slug'] ?>"><?php echo $category['cat_title'] ?></a></b></li>

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
         
          <?php // include "includes/widget.php"; ?>

        </div>

      </div>
         </div>
        
    </div>
</div>



<?php include "includes/footer.php"; ?>

