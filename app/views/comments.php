
<?php include "admin/includes/header.php"; ?>
<?php include "admin/includes/navigation.php"; ?>


<div class="content-wrapper">
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <h1> <?php ?><small> Welcome to administrator panel</small> </h1>
            </div>
        </div>
        <hr>
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Comments</a>
            </li>
            <li class="breadcrumb-item active">Posts Comments</li>
        </ol>

    </div> 
    <div class="container mystyle">
        <div class="row">
            <div class="col-md-12">
            
        <form action="<?php echo ROOT ?>comments/select_option/" method="post">
            
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 2em;">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group" style="float:left">
                        <select class="form-control" name="options" >
                            <option value="">Select options</option>
                            <option value="approved">Approved</option>
                            <option value="unapproved">Unapproved</option>
                            <option value="delete">Delete</option>
                        </select> 
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <button class="btn btn-primary ml-4" type="submit" name="apply"  style="float:left;">Apply</button>
                    </div>  
                </div>
            </div>


       

        <!--                   TABLE COMMENTS                                                   -->            

        <div class="col-md-12" id="showCategories">
            <table class="table table-responsive-md table-responsive-sm table-responsive-xl table-responsive-lg table-hover table-bordered" id="categories" style="margin-bottom:5em;">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th>Id</th>
                        <th>Post title</th>
                        <th>Author</th>
                        <th>Email</th>
                        <th>Content</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Approved</th>
                        <th>Unapproved</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                 
                       $comments = $params[0];
                        $pagination = $params[1];
                                        

                        
                    ?>

                        <?php foreach ($comments as $comment): ?>
                        <tr>
                            <td><input type="checkbox" class="checkboxArray" value="<?php echo $comment->id  ?>" name="checkboxes[]"></td>
                            <td><?php echo $comment->id  ?></td>
                            <td><a href="<?php echo ROOT . "users/post/". $comment->post->slug; ?>"><?php echo $comment->post->post_title ?></a></td>
                            <td><?php echo $comment->get_comm_author($comment->comment_user_id)  ?></td>
                            <td><?php echo $comment->comment_email ?></td>
                            <td><?php echo (strlen($comment->comment_content) > 100) ? substr($comment->comment_content, 0, 80) . " (...)" : $comment->comment_content ;  ?></td>
                            <td><?php echo $comment->comment_status ;  ?></td>
                            <td><?php echo $comment->created_at->diffForHumans() ;  ?></td>
                            <td><?php echo $comment->updated_at->diffForHumans() ;  ?></td>
                            <td><a href="<?php echo ROOT ?>comments/status/approved/<?php echo $comment->id ;  ?>/">Approved</a></td>
                            <td><a href="<?php echo ROOT ?>comments/status/unaproved/<?php echo $comment->id  ?>/">Unapproved</a></td>
                            <td><a rel="<?php echo $comment->id  ?>" href="#" class="deleteModal">Delete</a></td>
                        </tr>


                        <?php endforeach; ?>


                </tbody>
            </table>

        </div>
        
        
    </form>
 </div> 
        
            <nav aria-label="Page navigation example" class="ml-5">
            
            <?php if($pagination->show_pagination()): ?>
            
            <ul class="pagination">
                <li class="page-item">
                    <?php if ($pagination->has_previous()): ?>
                        <a class="page-link" href="<?php echo ROOT ?>comments/index/<?php echo $pagination->previous() ?>">Previous</a></li>
                <?php endif; ?>
                


                <?php for ($i = 1; $i <= $pagination->count; $i++): ?>
                    <li class='page-item <?php echo $pagination->current_page == $i ? "active" : "" ?>'><a class='page-link' href='<?php echo ROOT ?>comments/index/<?php echo $i ?>'><?php echo $i ?></a></li>



                <?php endfor; ?> 
                <li class="page-item">
                    <?php if ($pagination->has_next()): ?>
                        <a class="page-link" href="<?php echo ROOT ?>comments/index/<?php echo $pagination->next() ?>">Next</a></li>
                <?php endif; ?>
            </ul>
          </nav>
            
            <?php endif; ?>
        
</div>
        
        <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">DELETE</h4>
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
   </div>
</div> 
    

    
    <?php 
    
       
    
    ?> 
    
    
    <?php require_once "admin/includes/footer.php"; ?>

    <script>
//    
////    $('.deleteModal').click(function(e){
////            e.preventDefault();
////            var id = $(this).attr('rel');
////            console.log(id);
////            $('#myModal').modal('show'); 
////            $('.btnDelete').click(function(){
////               window.location.href = '/refector/comments/delete_comments/'+id;
////            });
////    });  
            
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
    
    
    
    </script>