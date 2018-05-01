
<?php include "admin/includes/header.php"; ?>
<?php include "admin/includes/navigation.php"; ?>


<?php 

    $users      = $params[0];
    $pagination = $params[1];
    $msg        = $params[2];
?>

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <h1> <?php  ?><?php  ?><small> Welcome to administrator panel</small> </h1>
            </div>
        </div>
        <hr>
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
          
           <?php if(!empty($msg)) :?>
            
            <div style="color:#fff" class="bg bg-success form-control"> <?php echo $msg ?></div>
            
            <?php else: ?>
            

        <li class="breadcrumb-item">
          <a href="#">Users</a>
        </li>
        <li class="breadcrumb-item active">User List</li>
        
        <?php endif; ?>
        
      </ol>
    </div> 
    <div class="container mystyle">
    <div class="row">
        <div class="col-md-12">
            <hr>
                
            <form action="<?php echo ROOT . "users/select_option/" ?><?php echo $pagination->current_page . "/" ?>" method="post">
               <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 2em;">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="form-group" style="float:left">
                        <select class="form-control" name="options" >
                            <option value="">Select options</option>
                            <option value="admin">Change to admin</option>
                            <option value="subscriber">Change to subscriber</option>
                            <option value="delete">Delete</option>
                        </select> 
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 ml-4">
                        <button class="btn btn-primary ml-4" type="submit" name="apply"  style="float:left;">Apply</button>
                    </div>  
                </div>
            </div>



                    <!--                   TABLE uesrs                                                   -->            

                    <div class="col-md-12">
                        <table class="table  table-responsive-lg table-responsive-md table-responsive-sm table-hover table-bordered mx-auto"  style="margin-bottom:5em;">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="checkAll"></th>
                                    <th>Id</th>
                                    <!--<th>category id</th>-->
                                    <th>Username</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><input type="checkbox" class="checkboxArray" value="<?php echo $user->id; ?>" name="checkboxes[]"></td>
                                        <td><?php echo $user->id ?></td>
            <!--                            <td><?php // echo $post->post_category_id; ?></td>-->
                                        <td><?php echo $user->user_name ?></td>
                                        <td><?php echo $user->user_firstname ?></td>
                                        <td><?php echo $user->user_lastname ?></td>
                                        <td><?php echo $user->user_email ?></td>
                                        <td><?php echo $user->user_role ?></td>
                                        <td><?php echo $user->created_at->diffForHumans(); ?></td>
                                        <td><?php echo $user->updated_at->diffForHumans(); ?></td>
                                        <td><a href="<?php echo ROOT ?>users/update/<?php echo $user->id ?>">Edit</a></td>
                                        <td><a rel="<?php echo $user->id ?>" href="#" class="deleteModal">Delete</a></td>
                                    </tr>

                                    <?php endforeach; ?>
                            </tbody>
                        </table>

                        <nav aria-label="Page navigation example">
                            
                            <?php if($pagination->show_pagination()): ?>
                            
                            <ul class="pagination">
                                <li class="page-item">
                                    <?php if ($pagination->has_previous()): ?>
                                        <a class="page-link" href="<?php echo ROOT ?>users/index/<?php echo $pagination->previous() ?>">Previous</a></li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= ceil($pagination->count); $i++): ?>
                                    <li class='page-item <?php echo $pagination->current_page == $i ? "active" : "" ?>'><a class='page-link' href='<?php echo ROOT ?>users/index/<?php echo $i ?>'><?php echo $i ?></a></li>



                                <?php endfor; ?> 
                                <li class="page-item">
                                <?php if ($pagination->has_next()): ?>
                                        <a class="page-link" href="<?php echo ROOT ?>users/index/<?php echo $pagination->next() ?>">Next</a></li>
                                <?php endif; ?>
                            </ul>
                            
                            <?php endif; ?>
                            
                        </nav>

                    </div>
                </form>  
        </div>
    </div>

    </div>    


    <!--MODAL-->

</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title text-center">DELETE</h4>
            </div>
            <div class="modal-body">
                <p>You are about to delete.</p>
                <p>Do you want to proceed?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger btnDelete" data-dismiss="modal">Delete</button>
            </div>
        </div>

    </div>
</div>
    
    
    
    
    <?php require_once "admin/includes/footer.php"; ?>

    
    <script>
        
            $(document).ready(function(){
                    $('#checkAll').on('click',function(){
                        var isCheck = $('#checkAll').prop('checked');
                        if(!isCheck){
                            $('.checkboxArray').each(function(index){
                            $(this).attr('checked',false);
                        });
                        }else{
                            $('.checkboxArray').each(function(index){
                            $(this).attr('checked',true);
                        });
                        }  
               });
            });
            
       
            
    </script>
