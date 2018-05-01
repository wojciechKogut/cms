
<?php include "admin/includes/header.php"; ?>
<?php include "admin/includes/navigation.php"; ?>


 <?php

$post          = $params[0];
$users         = $params[1];
$categories    = $params[2];
$the_category  = $params[3];
$form          = $params[4];
$author_post   = $params[5];

?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <h1>Welcome to administrator panel</h1>
            </div>
        </div>
        <hr>
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Posts</a>
        </li>
        <li class="breadcrumb-item active">Update</li>
      </ol>
    </div> 
<!--    <div class="container">-->
    <div class="row">
        <div class="col-md-3 ml-5">
            
            <div class="form-group clearfix">
                
                <figure style="float:left" class="figure-img img-thumbnail">
                    <img class="img-responsive img-fluid" src="<?php echo (empty($form->tmp_file)) ? ROOT . "public/images/upload_img/" . $post->post_image : ROOT . "public/tmp/" . $form->tmp_file ?>">
                </figure>

            </div>
            
        </div>
        <div class="col-md-8 mr-5">
            <hr>
            
           
            


            <form action="" method="post" enctype="multipart/form-data">
          
          <?php if (!empty($form)) : ?>   
                

                
                <div class="form-group">
                    <label for="title">Post title</label><i class="required-star">*</i>
                    <input class="<?php echo !empty($form->style["post_title"]) ? $form->style["post_title"] : "" ?> form-control" type="text" id="title" name="post_title" class="form-control" value="<?php echo $form->form_values["post_title"] ?>">
                    <div style="color:#FF3366"><?php echo !empty($form->error["post_title"]) ? $form->error["post_title"] : "" ?></div>
                </div>
                
                
                <div class="form-group">
                    <label for="post_category_id">Post category</label><i class="required-star">*</i>
                    <div class="col-md-2 p-0 mb-3">
                        <select class="form-control" name="post_category_id" id="category">
                            
                            <?php 

                            foreach ($categories as $category) {
                                if ($form->form_values["post_category_id"] == $category->id) {
                                    echo "<option value='$category->id'>$category->cat_title</option>";
                                }
                            }

                            foreach ($categories as $category) {
                                if ($form->form_values["post_category_id"] != $category->id) {
                                    echo "<option value='$category->id'>$category->cat_title</option>";
                                }

                            }

                            ?>
                      
                        </select>
                    </div>
                    <div style="color:#FF3366"><?php echo (!empty($form->error["post_category_id"])) ? $form->error["post_category_id"] : "" ?></div>
                </div>    
                
               
                
                
                <div class="form-group">
                    <label>Post status</label>
                    <div class="col-md-2 p-0 mb-3">
                        <select class="form-control" name="post_status" id="">
                            <option value="<?php echo $form->form_values["post_status"] ?>"><?php echo $form->form_values["post_status"] ?></option>
                            <?php echo ($form->form_values["post_status"] == 'draft') ? "<option value='publish'>publish</option>" : "<option value='draft'>draft</option>" ?>
                        </select>   
                    </div>
                </div>
                
                  
                    <div class="form-group clearfix">
                        <label for="image" class="btn btn-default btn-file mr-3" style="float:left;">Choose Image
                            <input type="file" name="post_image" id="image" style="display:none" onchange="$('#uploaded_file').html(this.files[0].name)">
                        </label>
                        <p id="uploaded_file" style="float:left;"></p>

                    </div>

                    <div class="form-group">
                        <label for="tags">Post tags</label>
                        <input type="text" name="post_tags" id="tags" class="form-control" value="<?php echo $form->form_values["post_tags"] ?>">
                    </div>

                
                    <label>Post Content</label><i class="required-star">*</i>
                    <div class="<?php echo $form->style["post_content"] ?>">
                        <textarea class="form-control" name="post_content" id="content" cols="30" rows="10">
                            <?php echo $form->form_values["post_content"] ?>
                        </textarea>
                    </div>
                    <div style="color:#FF3366">
                        <?php echo (!empty($form->error["post_content"])) ? $form->error["post_content"] : "" ?>
                    </div>
                 
                    
                <?php else : ?>
                   
                
                 <div class="form-group">
                    <label for="title">Post title</label><i class="required-star">*</i>
                    <input type="text" id="title" name="post_title" class="form-control" value="<?php echo $post->post_title; ?>">
                </div>
                    
                <div class="form-group">
                    <label for="post_category_id">Post category</label><i class="required-star">*</i>
                    <div class="col-md-2 p-0 mb-3">
                        <select class="form-control" name="post_category_id" id="category">
                        <?php echo "<option value='$the_category->id'>$the_category->cat_title</option>" ?>
                        <?php
                        foreach ($categories as $category) {
                            echo "<option value='$category->id'>$category->cat_title</option>";
                        }
                        ?>

                        </select>
                    </div>
                </div>    

                <div class="form-group">
                    <label>Post status</label>
                    <div class="col-md-2 p-0 mb-5">
                        <select class="form-control" name="post_status" id="">
                        <?php echo "<option value='$post->post_status'>$post->post_status</option>" ?>
                        <?php echo ($post->post_status == 'draft') ? "<option value='publish'>publish</option>" : "<option value='draft'>draft</option>" ?>
                        </select>
                    </div>
                </div>
                
 
                <div class="form-group clearfix">
                    <label for="image" class="btn btn-default btn-file mr-4" style="float:left;">Choose Image
                        <input type="file" name="post_image" id="image" style="display:none;" onchange="$('#uploaded_file').html(files[0].name)">
                    </label>
                    <p id="uploaded_file" style="float:left"></p> 
                </div>

                    <div class="form-group">
                        <label for="tags">Post tags</label>
                        <input type="text" name="post_tags" id="tags" class="form-control"
                        value="<?php echo $post->post_tags ?>">
                    </div>
                
                <label>Post Content</label><i class="required-star">*</i>
                <textarea class="form-control" name="post_content" id="content" cols="30" rows="10"><?php echo $post->post_content; ?></textarea>
                

                <?php endif; ?>

                <button class="btn btn-primary" type="submit" name="update">Update</button>
            </form>  
            <hr>
            <i class="required-star">*-->Field required</i>        
        </div>


    </div>
    <script>
        CKEDITOR.replace('post_content');
    </script>

<?php require_once "admin/includes/footer.php"; ?>