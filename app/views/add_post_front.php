<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>


<?php 

$categories  = $params[0];
$users       = $params[1];
$form        = $params[2];
$msg         = $params[3];
$user_logged = $params[4];
$recent      = $params[5];


?>

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
            
            <?php  echo !empty($msg) ? "<div class='alert alert-success'>". $msg . "<a href=\"". ROOT ."\"/posts>See other posts</a></div>" : ""; ?>

            <form action="" method="post" id="add_post" enctype="multipart/form-data" style="min-height:60rem;">

                <!--jezeli cos przyslo z formualrza-->
                <?php if (!empty($form->form_values)): ?>


                    <div class="form-group">

                        <label for="title">Post title</label><i class="required-star">*</i>

                        <input class="form-control <?php echo !empty($form->style["post_title"]) ? $form->style["post_title"] : ""  ?>" type="text" id="title" name="post_title" value="<?php echo $form->form_values['post_title'] ?>">
                        <div style="color:#FF3366"><?php echo !empty($form->error['post_title']) ? $form->error['post_title'] : "" ?></div>

                    </div>



                    <div class="form-group">
                        <label style="" for="category">Post category<i class="required-star">*</i></label>

                        <select style="width:11rem;" class="form-control p-0 <?php echo !empty($form->style["post_category_id"]) ? $form->style["post_category_id"] : "" ?>" name="post_category_id" class="selectpicker" id="category">

                            <?php
                            foreach ($categories as $category) {
                                if ($form->form_values["post_category_id"] == $category->id) {
                                    echo "<option value='$category->id'>$category->cat_title</option>";
                                }
                            }
                            echo "<option value=''>Select status</option> ";
                            foreach ($categories as $category) {
                                if ($form->form_values["post_category_id"] != $category->id) {
                                    echo "<option value='$category->id'>$category->cat_title</option>";
                                }
                            }
                            ?>

                        </select>
                        <div style="color:#FF3366"><?php echo !empty($form->error['post_category_id']) ? $form->error['post_category_id'] : "" ?></div>


                    </div>

                    <div class="form-group">
                        <label style="" for="post_author">Author <i class="required-star">*</i></label>
                        <input type="text" name="post_author" class="form-control <?php echo !empty($form->style["post_author"]) ? $form->style["post_author"] : "" ?>" value="<?php echo $form->form_values['post_author'] ?>">    
                        <div style="color:#FF3366"><?php echo !empty($form->error['post_author']) ? $form->error['post_author']  : "" ?></div>
                        <input type="hidden" name="post_user_id" value="<?php echo !empty($user_logged->id) ? $user_logged->id : null ?>">
                    </div>

                    <div class="form-group">
                         <label for="email">Email <i class="required-star">*</i></label>
                         <input type="email" name="user_email" class="form-control <?php echo !empty($form->style["user_email"]) ? $form->style["user_email"]  : "" ?>" value="<?php echo $form->form_values["user_email"] ?>">
                         <div style="color:#FF3366"><?php echo !empty($form->error['user_email']) ? $form->error['user_email']  : "" ?></div>
                    </div>

                    <div class="form-group">
                        <div class="clearfix"> 
                            <label for="image" class="btn btn-default btn-file mr-3 mb-4" style="float:left; cursor:pointer;">Choose Image
                                <input type="file" name=post_image id="image" style="display:none;" onchange="$('#uploaded_file').html(this.files[0].name)" value="Change">
                            </label>
                            <p id="uploaded_file" style="float:left;"></p>

                            <figure style="float:left" class="figure-img">
                                <img class="mx-auto img-responsive" style="display:block; margin: auto;width: 8em;" src="<?php echo ROOT . "public/tmp/" . $form->tmp_file ?>" alt="<?php echo $form->tmp_file; ?>">
                                <!--<figcaption class="text-center figure-caption"><?php // echo preg_replace('/\d+/u', '', $form->tmp_file) ?></figcaption>-->
                            </figure>
                        </div>

                        <?php if (!empty($form->upl_err)): ?>
                            <div style="color:#0066FF"><b>Notice: </b><?php echo $form->upl_err ?></div>
                        <?php endif; ?>

                    </div>   


                    <div class="form-group">
                        <label for="tags">Post tags</label>
                        <input type="text" name="post_tags" id="tags" class="form-control" value="<?php echo $form->form_values["post_tags"] ?>">
                    </div>


                    <label>Post Content</label><i class="required-star">*</i>



                    <div class="<?php echo !empty($form->style["post_content"]) ? $form->style["post_content"]  : "" ?>"><textarea class="form-control" name="post_content" id="content" cols="30" rows="10"><?php echo $form->form_values["post_content"] ?></textarea></div>
                    <div style="color:#FF3366"><?php echo !empty($form->error['post_content']) ? $form->error['post_content']  : "" ?></div>


                <?php else: ?>
                    
                    

                    <div class="form-group">
                        <label for="title">Post title</label><i class="required-star">*</i>
                        <input class="form-control" type="text" id="title" name="post_title" value="">
                    </div>

                    <div class="form-group">
                        <label style="" for="category">Post category<i class="required-star">*</i></label>

                        <select style="width:11rem;" class="form-control p-0" name="post_category_id" class="selectpicker" id="category">
                            <?php
                            echo "<option value=''>Select</option>";

                            foreach ($categories as $category) {

                                echo "<option value='$category->id'>$category->cat_title</option>";
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                            <label for="author">Author <i class="required-star">*</i></label>
                            <input type="text" name="post_author"class="form-control" value="<?php echo !empty($user_logged->user_name) ? $user_logged->user_name : "" ?>">
                            <input type="hidden" name="post_user_id" value="<?php echo !empty($user_logged->id) ? $user_logged->id : null ?>">
                    </div>


                    <div class="form-group">
                         <label for="email">Email <i class="required-star">*</i></label>
                         <input type="email" name="user_email" class="form-control" value="<?php echo !empty($user_logged->user_email) ? $user_logged->user_email : "" ?>">
                    </div>

                    <div class="clearfix">

                        <label for="image" class="btn btn-default btn-file mr-3 mb-4" style="float:left;cursor:pointer;">Choose Image
                            <input type="file" name=post_image id="image" style="display:none" onchange="$('#uploaded_file').html(this.files[0].name)">
                        </label>
                        <p id="uploaded_file" style="float:left;"></p>

                    </div>

                    <div class="form-group">
                        <label for="tags">Post tags</label>
                        <input type="text" name="post_tags" id="tags" class="form-control">
                    </div>
                    <div>
                        <label for="post_content">Post content <i class="required-star">*</i></label>
                        <textarea class="form-control" name="post_content" id="content" cols="30" rows="10"></textarea>
                    </div>
        
<?php endif;  ?>
        
    <button class="btn btn-primary"  type="submit" name="submit">Publish</button>
    
</form>  

         
 </div>
            
 <div class="col-md-3 col-lg-2 mr-auto" style="background-color: #fff; padding-bottom: 7em;">
     
     <?php include "includes/search.php"; ?>
     
          <!-- Categories Widget -->
          <div class="card my-4">
              <h5 class="card-header">Categories</h5>
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-6 pr-0" >
                          <ul class="list-unstyled ml-1">

                              <?php foreach ($categories as $category) : ?>
                              
                              <li class="list-group-item" style="border:none"><b><a style="color:<?php echo $category['color']; ?>" href="<?php echo ROOT ?>posts/post_cat/<?php echo $category['id'] ?>"><?php echo $category['cat_title'] ?></a></b></li>

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
        

        </div>
            
             </div>
        </div>
    </div>
</div>


<?php include "includes/footer.php" ?>