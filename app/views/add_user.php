<?php include "admin/includes/header.php"; ?>
<?php include "admin/includes/navigation.php"; ?>



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
            <li class="breadcrumb-item active">Add user</li>
        </ol>
    </div> 
    <div class="container mystyle">
        <div class="row">
            <div class="col-md-12">
                <hr>

                <?php
                $message = $params[0];
                $form    = $params[1];

                ?>
                
                

                <form action="" method="post" enctype="multipart/form-data">
                    
                <?php if(!empty($form->form_values)) : ?>
                    
                    <div class="form-group">
                        <label for="user_firstname">Firstname</label><i class="required-star">*</i>
                        <input class="<?php echo $form->style["user_firstname"] ?> form-control" type="text" id="Firstname" name="user_firstname"  value="<?php echo $form->form_values["user_firstname"] ?>">
                        <div style="color:#FF3366"><?php echo $form->error["user_firstname"] ?></div>
                    </div>
                    
                    
                    
                    <div class="form-group">
                        <label for="user_lastname">Lastname</label><i class="required-star">*</i>
                        <input class="<?php echo $form->style["user_lastname"] ?> form-control" type="text" value="<?php echo $form->form_values["user_lastname"] ?>" name="user_lastname" id="lastname">
                        <div style="color:#FF3366"><?php echo $form->error["user_lastname"] ?></div>
                    </div>
                    
  
                    <div class="form-group">
                        <label for="user_role">Role</label>
                        <div class="col-md-2 p-0 mb-3">
                            <select class="form-control" name="user_role" id="user_role">
                                <option value="subscriber">Select option</option>
                                <option value="admin">Admin</option>
                                <option value="subscriber">Subscriber</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="user_name">Username</label><i class="required-star">*</i>
                        <input class="<?php echo $form->style["user_name"] ?> form-control" type="text" value="<?php echo $form->form_values["user_name"] ?>" name="user_name" id="username">
                        <div style="color:#FF3366"><?php echo $form->error["user_name"] ?></div>
                    </div>
                    <div class="form-group">
                        <label for="user_email">Email</label><i class="required-star">*</i>
                        <input type="email" class="<?php echo $form->style["user_email"] ?> form-control" value="<?php echo $form->form_values["user_email"] ?>" name="user_email">
                        <div style="color:#FF3366"><?php echo $form->error["user_email"] ?></div>
                    </div>  
                    <div class="form-group">
                        <label for="user_password">Password</label><i class="required-star">*</i>
                        <input type="password" class="<?php echo $form->style["user_password"] ?> form-control" value="<?php // echo $form->form_values["user_password"] ?>" name="user_password">
                        <div style="color:#FF3366"><?php echo $form->error["user_password"] ?></div>
                    </div>  
                    
                    <?php else : ?>
                    
                    <div class="form-group">
                        <label for="user_firstname">Firstname</label><i class="required-star">*</i>
                        <input class="form-control" type="text" id="Firstname" name="user_firstname">

                    </div>
                    
                    
                    
                    <div class="form-group">
                        <label for="user_lastname">Lastname</label><i class="required-star">*</i>
                        <input class="form-control" type="text" value="" name="user_lastname" id="lastname">

                    </div>
                    
                    
                    
                    <div class="form-group">
                        <label for="user_role">Role</label>
                        <div class="col-md-2 p-0 mb-3">
                            <select class="form-control" name="user_role" id="user_role">

                                <option value="subscriber">Select option</option>
                                <option value="admin">Admin</option>
                                <option value="subscriber">Subscriber</option>
                            </select>
                        </div>
                    </div>
                    <!-- <label for="image">Image</label>
                    <input type="file" name=image id="image"> -->

                    <div class="form-group">
                        <label for="user_name">Username</label><i class="required-star">*</i>
                        <input class="form-control" type="text" name="user_name" id="username">

                    </div>
                    <div class="form-group">
                        <label for="user_email">Email</label><i class="required-star">*</i>
                        <input type="email" class="form-control" name="user_email">
               
                    </div>  
                    <div class="form-group">
                        <label for="user_password">Password</label><i class="required-star">*</i>
                        <input type="password" class="form-control" name="user_password">
                
                    </div>  
                    
                    
                    
                    <?php endif; ?>
                    

                    <button class="btn btn-primary" type="submit" name="create_user">Add user</button>
                </form>  
                
                
                
                
                <hr>
                <i class="required-star">*-->Field required</i>
            </div>
        </div>
    </div>
</div>


<?php include "admin/includes/footer.php"; ?>