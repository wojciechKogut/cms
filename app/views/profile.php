<?php include "admin/includes/header.php"; ?>
<?php include "admin/includes/navigation.php"; ?>


<?php

$the_user = $params[0];
$form     = $params[1];



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
                <a href="#">User</a>
            </li>
            <li class="breadcrumb-item active">User profile</li>
        </ol>
    </div> 
    <div class="container mystyle">
        <div class="row">
            <div class="col-md-12">
                <hr>
            

            <form action="" method="post" enctype="multipart/form-data">
                
              <?php if(!empty($form->form_values)): ?>
                
                <div class="form-group">
                    <label for="author">Firstname</label><i class="required-star">*</i>
                    <input class="<?php echo !empty($form->style["user_firstname"]) ? $form->style["user_firstname"] : "" ?> form-control" type="text" id="Firstname" name="user_firstname" class="form-control" value="<?php echo $form->form_values['user_firstname'] ?>" >
                    <div style="color:#FF3366"><?php !empty($form->error["user_firstname"]) ? $form->error["user_firstname"] : "" ?></div>
                </div>
                
                
                <div class="form-group">
                    <label for="status">Lastname</label><i class="required-star">*</i>
                    <input class="<?php echo !empty($form->style["user_lastname"]) ? $form->style["user_lastname"] : "" ?> form-control" type="text" name="user_lastname" id="lastname" class="form-control" value="<?php echo $form->form_values['user_lastname'] ?>">
                    <div style="color:#FF3366"><?php echo !empty($form->error["user_lastname"]) ? $form->error["user_lastname"] : "" ?></div>
                </div>
                
                
                <div class="col-md-2 pl-0 mb-3">
                    <label for="user_role">Role</label>
                    <select class="form-control" name="user_role" id="user_role">
                        <!--<option value="subscriber">Select option</option>-->
                        <?php
                        echo "<option value='" . $form->form_values['user_role'] . "'>" . $form->form_values['user_role'] . "</option>";
                        echo ($form->form_values['user_role'] == 'subscriber') ? "<option value='admin'>Admin</option>" : "<option value='subscriber'>Subscriber</option>";
                        ?>

                    </select>
                </div>
                

                <div class="clearfix"> 
                            <label for="image" class="btn btn-default btn-file mr-3" style="float:left; cursor:pointer;">Choose Image
                                <input type="file" name=user_image id="image" style="display:none;" onchange="$('#uploaded_file').html(this.files[0].name)" value="Change">
                            </label>
                            <p id="uploaded_file" style="float:left;"></p>

                            <figure style="float:left" class="figure-img">
                                <img class="mx-auto img-responsive" style="display:block; margin: auto;width: 8em;" src="<?php echo (empty($form->tmp_file)) ? ROOT."images/upload_img/$the_user->user_image" : ROOT."public/tmp/".$form->tmp_file ?>" alt="<?php echo $form->tmp_file; ?>">
                                <!--<figcaption class="text-center figure-caption"><?php // echo preg_replace('/\d+/u', '', $form->tmp_file) ?></figcaption>-->
                            </figure>
                       </div>

                <div class="form-group">
                    <label for="user_name">Username</label><i class="required-star">*</i>
                    <input class="<?php echo !empty($form->style["user_name"]) ? $form->style["user_name"] : "" ?> form-control" type="text" name="user_name" id="username" class="form-control" value="<?php echo $form->form_values['user_name'] ?>">
                    <div style="color:#FF3366"><?php echo !empty($form->error["user_name"]) ? $form->error["user_name"] : "" ?></div>
                </div>
                
                
                
                <div class="form-group">
                    <label for="email">Email</label><i class="required-star">*</i>
                    <input class="<?php echo !empty($form->style["user_email"]) ? $form->style["user_email"] : "" ?> form-control" type="email" class="form-control" name="user_email" value="<?php echo $form->form_values['user_email'] ?>">
                    <div style="color:#FF3366"><?php echo !empty($form->error["user_email"]) ? $form->error["user_email"] : "" ?></div>
                </div>  
                
                
                <div class="form-group">
                    <label for="user_password">Password</label><i class="required-star">*</i>
                    <input class="<?php echo !empty($form->style["user_password"]) ? $form->style["user_password"] : ""  ?> form-control" type="password" class="form-control" name="user_password">
                    <div style="color:#FF3366"><?php echo !empty($form->error["user_password"]) ? $form->error["user_password"] : "" ?></div>
                </div>  
                
              <?php else: ?>  
                
                <div class="form-group">
                    <label for="user_firstname">Firstname</label><i class="required-star">*</i>
                    <input type="text" id="Firstname" name="user_firstname" class="form-control" value="<?php echo $the_user['user_firstname'] ?>" >

                </div>
                <div class="form-group">
                    <label for="user_lastname">Lastname</label><i class="required-star">*</i>
                    <input type="text" name="user_lastname" id="lastname" class="form-control" value="<?php echo $the_user['user_lastname'] ?>">
                </div>
                
                <div class="col-md-2 pl-0 mb-3">
                    <label for="user_role">Role</label>
                    <select name="user_role" class="form-control" id="user_role">
                        <!--<option value="subscriber">Select option</option>-->
                        <?php
                        echo "<option value='" . $the_user['user_role'] . "'>" . $the_user['user_role'] . "</option>";
                        echo ($the_user['user_role'] == 'subscriber') ? "<option value='admin'>Admin</option>" : "<option value='subscriber'>Subscriber</option>";
                        ?>


                    </select>
                </div>
                
                <div class="clearfix">

                       
                     <figure style="" class="figure-img">
                            <img class="img-responsive" style="display:block;width: 8em;" src="<?php echo !empty($the_user->user_image) ? ROOT."images/upload_img/$the_user->user_image" : ROOT."images/upload_img/userplaceholder.png" ?>" alt="">
                                    <!--<figcaption class="text-center figure-caption"><?php // echo $the_user->user_image ?></figcaption>-->
                     </figure>
                        
                        
                    <label for="image" class="btn btn-default btn-file mr-3" style="cursor:pointer;">Choose Image
                            <input type="file" name=user_image id="image" style="display:none" onchange="$('#uploaded_file').html(this.files[0].name)">
                     </label>
                     <p id="uploaded_file" style="float:left;"></p>
                        
                </div>


                <div class="form-group">
                    <label for="tags">Username</label><i class="required-star">*</i>
                    <input type="text" name="user_name" id="username" class="form-control" value="<?php echo $the_user['user_name'] ?>">
                </div>
                <div class="form-group">
                    <label for="user_email">Email</label><i class="required-star">*</i>
                    <input type="email" class="form-control" name="user_email" value="<?php echo $the_user['user_email'] ?>">
                </div>  
                <div class="form-group">
                    <label for="user_password">Password</label><i class="required-star">*</i>
                    <input type="password" class="form-control" name="user_password">
                </div>  
                
                
                
              <?php endif; ?>    
                

                <button class="btn btn-primary" type="submit" name="user_profile">UPDATE PROFILE</button>
            </form>  

                <hr>
                <i class="required-star">*-->Field required</i>


        </div>   

    </div>

    </div>

</div>


<?php include "admin/includes/footer.php"; ?>