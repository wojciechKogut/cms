<?php include "admin/includes/header.php"; ?>
<?php include "admin/includes/navigation.php"; ?>



<?php
$categories = $params[0];
$users      = $params[1];
$form       = $params[2];



?>


<div class="content-wrapper">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <h1> <?php ?><?php ?><small> Welcome to administrator panel</small> </h1>
            </div>
        </div>
        <hr>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Posts</a>
            </li>
            <li class="breadcrumb-item active">Add post</li>
        </ol>
    </div> 
    <div class="container mystyle">
        <div class="row">
            <div class="col-md-12">
                <hr>

                <form action="" method="post" id="add_post" enctype="multipart/form-data">
                     
                    <div class="form-group">
                        <label for="title">Post title</label><i class="required-star">*</i>
                        
                        <?php if(!empty($form->error['post_title'])): ?>
                        
                        <input class="form-control <?php echo $form->style["post_title"]; ?>" type="text" id="title" name="post_title">
                        <div style="color:#FF3366"><?php echo $form->error['post_title'] ?></div>
                        
                        <?php else : ?>
                        <input class="form-control" type="text" id="title" name="post_title" value="<?php echo (!empty($form->form_values["post_title"]))? $form->form_values["post_title"] : "" ?>">
                        <?php endif;  ?>
                    </div>
                    
                    

                    <div class="form-group">
                        <label for="category">Post category</label><i class="required-star">*</i>
                        <div class="col-md-2 p-0 mb-3">
                            <select class="form-control" name="post_category_id" class="selectpicker" id="category">
                                
         
                        <?php if(!empty($form->form_values["post_category_id"])) : ?>        
                          
                        <?php
                        
                                foreach ($categories as $category)
                                {
                                    if($form->form_values["post_category_id"] == $category->id)
                                    {
                                       echo "<option value='$category->id'>$category->cat_title</option>"; 
                                    }
                                }    
                                echo "<option value=''>Select status</option> ";
                                foreach ($categories as $category)
                                {
                                    if($form->form_values["post_category_id"] != $category->id)
                                    {
                                       echo "<option value='$category->id'>$category->cat_title</option>"; 
                                    }
                                } 
                        ?>
                                
                       
                        <?php else: ?>  
                                
                                    <?php
                                    
                                        echo "<option value=''>Select</option>";
                                    
                                    
                                        foreach ($categories as $category)
                                        {

                                            echo "<option value='$category->id'>$category->cat_title</option>"; 

                                        }
                                
                                     ?>

                       <?php endif; ?>
                           
                            </select>
                             <div style="color:#FF3366"><?php echo (!empty($form->error['post_category_id'])) ? $form->error['post_category_id'] : "" ?></div>
                        </div>           
                    </div>  
                
                    
                    <div class="form-group">
                        <label for="status">Status</label>
                        <div class="col-md-2 p-0 mb-3">
                            <select class="form-control" name="post_status" class="selectpicker" id="">
                            
                            <?php if(!empty($form->form_values["post_status"])) : ?> 
                            
                            
                            <option value="<?php echo $form->form_values["post_status"] ?>"><?php echo $form->form_values["post_status"] ?></option>
                            
                            
                            <?php
                            
                                if($form->form_values["post_status"] == "draft")
                                {
                                    echo "<option value='published'>Publish</option>";
                                }
                            
                            
                            ?>
                            
                            <?php else: ?>
                            
                            <option value="draft">Select status</option>
                            <option value="draft">Draft</option>
                            <option value="published">Publish</option>
                            
                            
                            <?php endif; ?>
                        </select>
                        </div>
                    </div>
                   
                    
                    <?php // endif; ?>
                    
                    
                    
                    
                    <div class="form-group">
                        
                       
                        
                        
                        <?php if(!empty($form->error)): ?>
                       <div class="clearfix"> 
                            <label for="image" class="btn btn-default btn-file mr-3" style="float:left; cursor:pointer;">Choose Image
                                <input type="file" name=post_image id="image" style="display:none;" onchange="$('#uploaded_file').html(this.files[0].name)" value="Change">
                            </label>
                            <p id="uploaded_file" style="float:left;"></p>

                            <figure style="float:left" class="figure-img">
                                <img class="mx-auto img-responsive" style="display:block; margin: auto;width: 8em;" src="<?php echo ROOT."public/tmp/".$form->tmp_file ?>" alt="<?php echo $form->tmp_file; ?>">
                                <figcaption class="text-center figure-caption"><?php echo preg_replace('/\d+/u', '', $form->tmp_file) ?></figcaption>
                            </figure>
                       </div>
                        
                        <?php else: ?>
                        
                        <div class="clearfix">
                        
                            <label for="image" class="btn btn-default btn-file mr-3" style="float:left;cursor:pointer;">Choose Image
                                <input type="file" name=post_image id="image" style="display:none" onchange="$('#uploaded_file').html(this.files[0].name)">
                            </label>
                            <p id="uploaded_file" style="float:left;"></p>
                        
                        </div>
                        
                        <?php endif; ?>
                        
                        
                        <?php if(!empty($form->upl_err)): ?>
                        <div style="color:#0066FF"><b>Notice: </b><?php echo  $form->upl_err ?></div>
                        <?php endif; ?>
                        
                        
                        
                    </div>   
                    
                    
                    <div class="form-group">
                        <label for="tags">Post tags</label>
                        <input type="text" name="post_tags" id="tags" class="form-control" value="<?php echo !empty($form->form_values["post_tags"]) ? $form->form_values["post_tags"] : "" ?>">
                    </div>
                    
                    
                    <label>Post Content</label><i class="required-star">*</i>
                    
                    
                     <?php if(!empty($form->error['post_content'])): ?>
                        <div class="<?php echo (!empty($form->style["post_content"])) ? $form->style["post_content"] : "" ?>"><textarea class="form-control" name="post_content" id="content" cols="30" rows="10"><?php echo (!empty($form->form_values["post_content"])) ? $form->form_values["post_content"] : "" ?></textarea></div>
                        <div style="color:#FF3366"><?php echo $form->error['post_content'] ?></div>
                        
                    <?php else : ?>   
                        <div><textarea class="form-control" name="post_content" id="content" cols="30" rows="10"><?php echo (!empty($form->form_values["post_content"])) ? $form->form_values["post_content"] : "" ?></textarea></div>     
                     <?php endif; ?>
                        
                        
                    <button class="btn btn-primary pull-right mt-4 mb-4"  type="submit" name="submit">Publish</button>
                </form>  

                <i class="required-star">*-->Field required</i>
            </div>
        </div>

        <script>
        CKEDITOR.replace('post_content');
    </script>

<?php include "admin/includes/footer.php"; ?>

