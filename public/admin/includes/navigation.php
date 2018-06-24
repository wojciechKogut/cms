<?php if (!isset($_SESSION['id'])) session_start(); ?>
<body class="fixed-nav sticky-footer bg-dark" id="page-top ">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
        <a class="navbar-brand" href="<?php echo ROOT ?>pages/admin"><small>Administrator Panel</small> </a>
        <a class="navbar-brand" style="width:100px" href="<?php echo ROOT ?>">Home</a>
        <div class="ml-2 " style="border-radius: 25px; width:100px; height:30px; background-color: #f1f1f1;">
            <img style="height:30px; border-radius:50%;" class="img-fluid img-responsive img-circle" src="<?php  echo isset($_SESSION['user_image']) ? ROOT . "images/upload_img/". $_SESSION['user_image']  : ROOT . "images/userr.png" ?>" alt="">
           <span><?php echo !empty($_SESSION['user_name']) ? " " .$_SESSION['user_name'] : "" ?> </span>
        </div>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <?php if($_SESSION['user_role'] === "subscriber"): ?>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a  href="<?php echo ROOT ?>pages/admin" class="nav-link">
                        <i class="fa fa-fw fa-dashboard"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Comments">
                    <a class="nav-link"  href="<?php echo ROOT ?>comments">
                        <i class="fa fa-fw fa-table"></i>
                        <span class="nav-link-text">My comments</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" data-parent="#exampleAccordion" title="Components">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#posts" >
                        <i class="fa fa-fw fa-wrench"></i>
                        <span class="nav-link-text">My posts</span>
                    </a>
                    <ul class="collapse show" id="posts">
                        <li><a class="" href="<?php echo ROOT ?>posts">View all posts</a></li>
                        <li><a class="" href="<?php echo ROOT ?>posts/add">Add new post</a></li>
                    </ul>
                </li>               
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Profile">
                    <a class="nav-link" href="<?php echo ROOT ?>users/profile">
                        <i class="fa fa-fw fa-link"></i>
                        <span class="nav-link-text">My Profile</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item"><a  class="nav-link text-center" id="sidenavToggler"><i class="fa fa-fw fa-angle-left"></i></a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-fw fa-sign-out"></i>Logout</a>
                </li>
            </ul>
        </div>
        <?php else: ?>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                    <a  href="<?php echo ROOT ?>pages/admin" class="nav-link">
                        <i class="fa fa-fw fa-dashboard"></i>
                        <span class="nav-link-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip"  data-parent="#exampleAccordion"  data-placement="right" title="Category">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#category">
                        <i class="fa fa-fw fa-area-chart"></i>
                        <span class = "nav-link-text">Categories</span>
                    </a>
                    <ul class="collapse show" id="category">
                        <li><a class="" href="<?php echo ROOT ?>categories">View categories</a></li>
                        <li><a class="" href="<?php echo ROOT ?>categories/add">Add new category</a></li> 
                    </ul>
                </li>  
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Comments">
                    <a class="nav-link"  href="<?php echo ROOT ?>comments">
                        <i class="fa fa-fw fa-table"></i>
                        <span class="nav-link-text">Comments</span>
                    </a>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" data-parent="#exampleAccordion" title="Components">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#posts" >
                        <i class="fa fa-fw fa-wrench"></i>
                        <span class="nav-link-text">Posts</span>
                    </a>
                    <ul class="collapse show" id="posts">
                        <li><a class="" href="<?php echo ROOT ?>posts">View all posts</a></li>
                        <li><a class="" href="<?php echo ROOT ?>posts/add">Add new post</a></li>
                    </ul>
                </li>
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Users" data-parent="#exampleAccordion">
                    <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#users" >
                        <i class="fa fa-fw fa-file"></i>
                        <span class="nav-link-text">Users</span>
                    </a>
                    <ul class="collapse show" id="users">
                        <li><a class="" href="<?php echo ROOT ?>users">View all users</a></li>
                        <li><a class="" href="<?php echo ROOT ?>users/add">Add new user</a></li>
                    </ul>
                </li>
              
                <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Profile">
                    <a class="nav-link" href="<?php echo ROOT ?>users/profile">
                        <i class="fa fa-fw fa-link"></i>
                        <span class="nav-link-text">My profile</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item">
                    <a  class="nav-link text-center" id="sidenavToggler">
                        <i class="fa fa-fw fa-angle-left"></i>
                    </a>
                </li>
 
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-fw fa-sign-out"></i>Logout</a>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </nav>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php echo ROOT ?>users/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>


    

        
        
        
        
     
