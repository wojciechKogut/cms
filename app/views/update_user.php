
<?php include "admin/includes/header.php"; ?>
<?php include "admin/includes/navigation.php"; ?>


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
                <a href="#">Users</a>
            </li>
            <li class="breadcrumb-item active">User List</li>
        </ol>
    </div> 
    <div class="container mystyle">
        <div class="row">
            <div class="col-md-12">
           
        <?php 
            
            $user    = $params[0];
            $user_id = $params[1];
            $message = $params[2];
            $form    = $params[3];
            
        ?>
                
            <form action="" method="post" enctype="multipart/form-data" class="col-md-8" >
                
                <?php if(!empty($form->form_values)): ?>
                
                
                
                <div class="form-group">
                    <label for="author">Firstname</label><i class="required-star">*</i>
                    <input type="text" id="Firstname" name="user_firstname" class="<?php echo !empty($form->style["user_firstname"]) ? $form->style["user_firstname"] : ""  ?> form-control" value="<?php echo $form->form_values["user_firstname"] ?>" >
                    <div style="color:#FF3366"><?php echo !empty($form->error["user_firstname"]) ? $form->error["user_firstname"] : "" ?></div>
                </div>
                
                
                <div class="form-group">
                    <label for="status">Lastname</label><i class="required-star">*</i>
                    <input type="text" name="user_lastname" id="lastname" class="<?php echo !empty($form->style["user_lastname"]) ? $form->style["user_lastname"] : "" ?> form-control" value="<?php echo $form->form_values["user_lastname"] ?>">
                    <div style="color:#FF3366"><?php echo !empty($form->error["user_lastname"]) ? $form->error["user_lastname"] : ""  ?></div>
                </div>
                
                
                <div class="form-group">
                    <label for="user_role">Role</label>
                    <div class="col-md-3 p-0 mb-3">
                        <select class="form-control" name="user_role" id="user_role">
                            <option value="<?php echo $form->form_values["user_role"] ?>"><?php echo $form->form_values["user_role"]  ?></option>
                            <?php
                            if ($form->form_values["user_role"]  == 'subscriber')
                            {
                                echo "<option value='admin'>admin</option>";
                            } 
                            else
                            {
                                echo "<option value='subscriber'>subscriber</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tags">Username</label><i class="required-star">*</i>
                    <input type="text" name="user_name" id="username" class="<?php echo !empty($form->style["user_name"]) ? $form->style["user_name"] : "" ?> form-control" value="<?php echo $form->form_values["user_name"] ?>">
                    <div style="color:#FF3366"><?php echo !empty($form->error["user_name"]) ? $form->error["user_name"] : "" ?></div>
                </div>
                
                
                <div class="form-group">
                    <label for="email">Email</label><i class="required-star">*</i>
                    <input type="email" class="<?php echo !empty($form->style["user_email"]) ? $form->style["user_email"] : "" ?> form-control" name="user_email" value="<?php echo $form->form_values["user_email"] ?>">
                    <div style="color:#FF3366"><?php echo !empty($form->error["user_email"]) ? $form->error["user_email"] : "" ?></div>
                </div>  
                
                
                <div class="form-group">
                    <label for="password">Password</label><i class="required-star">*</i>
                    <input type="password" class="<?php echo !empty($form->style["user_password"]) ? $form->style["user_password"] : "" ?> form-control" name="user_password">
                    <div style="color:#FF3366"><?php echo !empty($form->error["user_password"]) ? $form->error["user_password"] : "" ?></div>
                </div>  
                
             <?php else: ?>   
                
              <div class="form-group">
                    <label for="author">Firstname</label><i class="required-star">*</i>
                    <input type="text" id="Firstname" name="user_firstname" class="form-control" value="<?php echo $user->user_firstname; ?>" >

                </div>
                <div class="form-group">
                    <label for="status">Lastname</label><i class="required-star">*</i>
                    <input type="text" name="user_lastname" id="lastname" class="form-control" value="<?php echo $user->user_lastname; ?>">
                </div>
                <div class="form-group">
                    <label for="user_role">Role</label>
                    <div class="col-md-3 p-0 mb-3">
                        <select class="form-control" name="user_role" id="user_role">
                            <option value="<?php echo $user->user_role; ?>"><?php echo $user->user_role; ?></option>
                            <?php
                            if ($user->user_role == 'subscriber') {
                                echo "<option value='admin'>admin</option>";
                            } else {
                                echo "<option value='subscriber'>subscriber</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tags">Username</label><i class="required-star">*</i>
                    <input type="text" name="user_name" id="username" class="form-control" value="<?php echo $user->user_name ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label><i class="required-star">*</i>
                    <input type="email" class="form-control" name="user_email" value="<?php echo $user->user_email ?>">
                </div>  
                <div class="form-group">
                    <label for="password">Password</label><i class="required-star">*</i>
                    <input type="password" class="form-control" name="user_password">
                </div>  
                
                
             <?php endif; ?>
                <button class="btn btn-primary" type="submit" name="update_user">Update user</button>     
            </form>  
           <hr>
           <i class="required-star">*-->Field required</i>
        </div>
    </div>
    </div>
 <?php require_once "admin/includes/footer.php"; ?>