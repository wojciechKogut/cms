<?php include "includes/header.php";?>
<?php include "includes/navigation.php";?>

<?php 

if(isset($_SESSION['user_name'])) header("location: ".ROOT."/pages/admin/");

$form = $params[0];
if(!empty($form->error['user_exists'])) $user_exists = $form->error['user_exists']; 
else $user_exists = "";
if(!empty($form->error['email_exists']))  $email_exists = $form->error['email_exists'];
else $email_exists = "";

?>

    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6" style="background-color: #fff; margin:auto; padding-top: 8rem; ">
                <div class="form-wrap">
                <h1>Register</h1>

                <form  action="" method="post" onsubmit="return validate()" id="loginForm" autocomplete="off">
   
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="user_name" id="username" class="form-control <?php echo !empty($form->style['user_name']) ? $form->style['user_name'] : "";  ?>" placeholder="Enter Desired Username" 
                            autocomplete="on" 
                            value = "">
                            <?php if(!empty($form->error['user_name'])): ?>
                            <div style="color:#FF3366"> <?php echo $form->error['user_name'] ?>
                             <?php endif; ?>
                             <div style="color:#FF3366"><?php echo $user_exists ?></div>
                            
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="user_email" id="email" class="form-control <?php echo !empty($form->style['user_email']) ? $form->style['user_email'] : "";  ?>" placeholder="somebody@example.com" 
                            autocomplete="on" 
                            value = "">
                            <!--<p class="info"></p>-->
                            <?php if(!empty($form->error['user_email'])): ?>
                            <div style="color:#FF3366"> <?php echo $form->error['user_email'] ?></div>
                             <?php endif; ?>
                             <div style="color:#FF3366"><?php echo $email_exists ?></div>
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="user_password" id="password" class="form-control" placeholder="Password">
                            <p class="info"></p>
                
                
                    <input type="submit" name="wyslij"  id="submitForm" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>

                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>







    <?php include "includes/footer.php" ?>   

 <script src="<?php echo ROOT ?>admin/js/main.js"></script>