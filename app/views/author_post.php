<?php
            $post           = $params[0];
            $id             = $params[1];
            $the_comment    = $params[2];
            $categories     = $params[3];
            $category       = $params[4];
            $user           = $params[5];
            $reply_comment  = $params[6];
            $recent         = $params[7];
            $like           = $params[8];       
            $numlikesToPost = $params[9];
            $likesToPost    = $params[10];

?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<div class="content-wrapper" style="padding-bottom:80px">
    <div class="container-fluid">
        <div class="col-md-12" style="">
            <div class="row">
    <!-- Blog Entries Column -->
    <div class="col-md-7 col-lg-6 ml-auto" style="background-color:#fff; padding-bottom: 7em; margin-bottom: 1em;">
          <div class="col-md-10">      
               <h2 class="card-title"><?php echo $post->post_title; ?></h2>
               <p class="lead">by   
                  <img class="img-size img-circle" src="<?php echo $post->get_user_img($post["post_user_id"]); ?>" alt="">
                  <a href="#"><?php echo ($post->post_user_id== 0) ? $post->post_author  : $post->user->user_name ;  ?></a>
               </p>
               <p><span class="glyphicon glyphicon-time"> Posted on <?php echo $post->created_at->diffForHumans(); ?></span>
                   <span class="ml-3">Category</span>  <b><a href="<?php echo ROOT."posts/post_cat/".$post['post_category_id'] ?>" style="color:<?php echo $post->category->color ?>"><?php echo !empty($post->category->cat_title) ? $post->category->cat_title : "Uncategorized" ; ?></a></b>
               </p>
               <hr>
               <a href="#"><img class="mb-5 img-fluid mx-auto" style="width: 100%; height: 25em;" src="<?php echo ROOT."images/upload_img/" ; ?><?php echo $post->post_image ;   ?>" alt="Card image cap"> </a> 
               <div class="col-md-10">
                  <input type="hidden" id="likesToPost" value="<?php echo $numlikesToPost ?>">
                  <a href="javascript:void(0)"  style="cursor:<?php echo !isset($_SESSION['id']) ? "default" : "pointer" ?>; float:left" onclick="like();"><i  class="fa fa-thumbs-o-up mr-3 <?php echo ($like->user_id != 0 && $like->user_id == $_SESSION['id']) ? "like" : "" ?>"></i></a>
                  <div class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)">(<?php echo $numlikesToPost ?>)</a>
                      <ul class="dropdown-menu">
                        <?php if($numlikesToPost > 0): ?>
                            <?php foreach($likesToPost as $like): ?>
                                <li class="dropdown-item"><?php echo $like->user->user_name ?></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                      </ul>
                </div>
                  <a href="javascript:void(0)"  style="cursor:<?php echo !isset($_SESSION['id']) ? "default" : "pointer" ?>" onclick="dislike();"><i  class="fa fa-thumbs-o-down"></i></a>
                </div>
               <hr>
               <div class="text-justify mb-4 "><?php echo html_entity_decode($post->post_content); ?></div>
          </div>          
          <div class="col-md-10" id="warning"></div>          
          <?php if(!isset($_SESSION['id'])): ?>    
           <?php else: ?>
          <div class="col-md-10">
                  <div class="form-group">
                      <form action="" method="post" id="myForm">
                          <div class="well">
                              <h4>Leave a Comment:</h4>
                              <div class="form-group">
                                  <textarea  class="form-control" name="comment_content" id="comment_content" rows="3"></textarea>
                              </div>
                              <button type="button" onclick="ajax()" name="create_comment" id="create_comment" class="btn btn-primary">Submit</button>
                          </div>
                      </form>
                  </div>
              </div>
           <?php endif; ?>
          <input type="hidden"  value="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 0  ?>" id="user_id">
          <input type="hidden"  value="<?php echo $id; ?>" id="post_id">
   <ul id="update">
  <?php foreach($the_comment as $comment): ?>    
  <input type="hidden" id="user-id" value="<?php echo isset($_SESSION['id'])? $_SESSION['id'] : 0  ?>">
       <input type="hidden" id="post-id" value="<?php echo $comment->comment_post_id ?>">
       <input type="hidden" id="username" value="<?php echo isset($_SESSION['user_name'])? $_SESSION['user_name'] : "" ?>">
       <li id="" class="" style="list-style-type: none">          
              <div class="col-md-12 well" id="showComment">
                 <img class="img-size img-circle pull-left"  src="<?php echo $comment->get_user_comm_img($comment->comment_user_id); ?>" alt=""> <!--$id - id postu -->
                      <div class="col-md-10">
                          <h4 class=""> <?php echo $comment->comment_author; ?>
                              <small><?php echo $comment->created_at->diffForHumans(); ?> 
                                  <i style="cursor: pointer"  class="fa fa-reply reply-icon" onclick="reply(<?php echo $comment->id ?>)"></i>
                              </small>
                          </h4>                       
                          <ul style="display:block">
                                  <li class='mt-4'  style="overflow:hidden; background-color: #fff;border-radius: 25px"><?php echo $comment['comment_content']; ?></li>
                                    <ul id="reply-list-<?php echo $comment->id ?>">
                                        <?php foreach ($reply_comment as $reply): ?> 
                                            <?php if ($reply->comment_reply_id == $comment->id): ?>

                                                <li class='mt-4'  style=" min-height:3rem; word-wrap: break-word; list-style-type: none; background-color: #fff;border-radius: 25px">
                                                    <img class="img-size img-circle pull-left"  src="<?php echo $comment->get_user_comm_img($reply->comment_user_id); ?>" alt=""> <!--$id - id postu -->
                                                    <strong><?php echo $reply->user->user_name ?></strong> : <?php echo $reply['comment_content']; ?>
                                                </li>
                                                <span><?php echo $reply->created_at->diffForHumans() ?></span>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>   
                           </ul>            
                      </div>
         <?php if(isset($_SESSION['id'])): ?>    
                 <form style="height:3rem;" id="reply_form-<?php echo $comment->id ?>" method="post" action="">
                     <input onclick="reply_content(<?php echo $comment->id ?>)" type="text" class="form-control mt-3 col-md-10 ml-5" id="answer-<?php echo $comment->id ?>" placeholder="Enter reply" style="overflow:hidden; display:none; background-color: #fff;">
                 </form>
<?php endif; ?>
              </div>
            </li> 
 <?php endforeach; ?> 
    </ul>     
        <!-- Blog Post -->
     </div>
        <!-- Sidebar Widgets Column -->
        <div class="col-md-3 col-lg-2 mr-auto" style="background-color: #fff; padding-bottom: 7em; margin-bottom: 1em;">
            <!-- Search Widget -->
            <?php include "includes/search.php"; ?>
          <!-- Categories Widget -->
          <div class="card my-4">
              <h5 class="card-header mt-0">Categories</h5>
              <div class="card-body">
                  <div class="row">
                      <div class="col-lg-12">
                          <ul class="list-unstyled mb-0">
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
        </div>
    </div>
   </div>
</div>
<?php require_once "includes/footer.php"; ?>




