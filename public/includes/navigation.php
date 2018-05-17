<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">

        <a class="navbar-brand" href="<?php echo ROOT ?>">Front</a>
        <button class="navbar-toggler" type="button" id="navbarToggler">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-3">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo ROOT ?>">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" id="adminMenu" href="#<?php // echo ROOT ?>">Admin</a>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a href="<?php echo ROOT ?>pages/admin"><li class="dropdown-item">Dashboard</li></a>
                  <a href="<?php echo ROOT ?>categories"><li class="dropdown-item">Categories</li></a>
                  <a href="<?php echo ROOT ?>posts"><li class="dropdown-item">Posts</li></a>
                  <a href="<?php echo ROOT ?>comments"><li class="dropdown-item">Comments</li></a>
                  <a href="<?php echo ROOT ?>users"><li class="dropdown-item">Users</li></a>
                  <a href="<?php echo ROOT ?>users/profile"><li class="dropdown-item">Profile</li></a>
              </ul>
            </li>
            <li class="nav-item">
                <?php if(!isset($_SESSION['user_name'])): ?>
              <a class="nav-link" href="<?php echo ROOT ?>users/register">Registration</a>
              <?php endif; ?>
            </li>
            <!-- <li class="nav-item">
                <?php //if(!isset($_SESSION['user_name'])): ?>
              <a class="nav-link" href="<?php //echo ROOT ?>users/login">Login</a>
              <?php //endif; ?>
            </li> -->
            <li class="nav-item">
                
              <?php  if(isset($_SESSION['user_name'])):  ?>
                   
              <a class="nav-link" href="<?php echo ROOT ?>users/logout">Logout</a>

              <?php endif; ?>
              
            </li>
            
            <li class="nav-item mr-3" style="width:80px;">
              <a class="nav-link" href="<?php echo ROOT ?>posts/add_front">Add Post</a>
            </li>
            
             <?php if(!isset($_SESSION['user_name'])):  ?>
            <li class="dropdown nav-item">
                   
                <a href="#" class="dropdown-toggle nav-link" role="button" id="#login-form" data-toggle="dropdown">Login</a>

                <form method="post" action="<?php echo ROOT ?>users/check_user" style="width:30rem "  id="login-form" role="form" autocomplete="off" class="form" aria-labelledby="login-form" >
                    
                    <div class="dropdown-menu">
                        <div class="alert alert-danger ml-1 mr-1" style="display: none">
                             <span id="loginErr"><strong></strong></span>
                        </div>
                        <div class="form-group dropdown-item" style="background-color:#fff;">
                            <div class="input-group mt-5">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>

                                <input name="username" id="name" type="text" class="form-control" placeholder="Enter Username">
                            </div>
                            <p class="info"></p>
                        </div>

                        <div class="form-group dropdown-item" style="background-color:#fff;">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                                <input name="password" id="pass" type="password" class="form-control" placeholder="Enter Password">

                            </div>
                            <p class="info"></p>
                        </div>

                        <div class="form-group dropdown-item" style="background-color:#fff;">

                            <input name="login" class="btn btn-lg btn-primary btn-block" value="Login" type="button" onclick="verify()">
                        </div>
                    </div>
              </form>
            </li>
                <?php endif; ?>

            <li class="nav-item">
                <a href="#" style="padding:15px 0; color:grey" class="nav-link ml-2" role="button" id="#login-form" data-toggle="dropdown"><?php echo isset($_SESSION['user_name']) ? "User online: " . $_SESSION['user_name'] : "" ?></a>
            </li>
            
            <li class="nav-item" style="position:relative; width:40rem;">
                    <div id="navbar-items">
                    <span id="city"></span>  
                    <img  id="weather_img" />
                    <span id="degree"></span>
                    <span class="mr-5" id="time"></span>
                    </div>
            </li>
 
          </ul>
             
      </div>
      </div>
    </nav>


<script>
    $('#navbarToggler').on('click',function() {
        $('#navbarResponsive').toggle();
    });
</script>