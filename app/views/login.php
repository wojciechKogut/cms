<?php include "../public/includes/header.php"; ?>
<?php include "../public/includes/navigation.php"; ?>



    <!--<div class="form-gap"></div>-->
    <div class="container">
        <div class="row">
            <div class="col-md-4" style="margin: auto; padding-top: 8rem;">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                            
                            <p><?php  ?></p>

                            <h3><i class="fa fa-user fa-4x"></i></h3>
                            <h2 class="text-center">Login</h2>
                            <div class="panel-body">
                                
                                <?php
//                                    $message = $params;
                                    
                                ?>
                                
                                <?php  if(isset($_SESSION['msg'])): ?>
                                
                                    <div class="alert alert-danger">
                                        <strong><?php echo $_SESSION['msg']; ?></strong>
                                      </div>
                                <?php endif; ?>
                                


                                <form onsubmit="return verify()"  id="login-form" role="form" autocomplete="off" class="form" method="post" action="<?php echo ROOT ?>users/check_user">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

                                            <input name="username" type="text" class="form-control" placeholder="Enter Username">
                                        </div>
                                        <p class="info"></p>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                            <input name="password" type="password" class="form-control" placeholder="Enter Password">
                                            
                                        </div>
                                        <p class="info"></p>
                                    </div>

                                    <div class="form-group">

                                        <input name="login"  class="btn btn-lg btn-primary btn-block" value="Login" type="submit">
                                    </div>


                                </form>

                            </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
    <?php echo include "includes/footer.php" ?>
    
    
    

