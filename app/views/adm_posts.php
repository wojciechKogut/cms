<?php
    $posts = $params[0];
    $pagination = $params[1];
    $msg = $params[2];
?>
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
      <?php if (empty($msg)) : ?>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Posts</a></li>
        <li class="breadcrumb-item active">Posts List</li>
       </ol>  
        <?php else : ?>
        <div style="color:#fff; padding: 20px 10px" class="bg bg-success"> <?php echo $params[2] ?></div>
        <?php endif; ?>
    </div> 
    <div class="col-lg-12 mystyle">
    <div class="row">
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <hr>
            <form action="<?php echo ROOT . "posts/select_option/" ?><?php echo $pagination->current_page; ?>" method="post">
            <div class="row" style="margin-bottom: 2em;">
                <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="form-group" style="float:left">
                        <select class="form-control" name="options" >
                            <option value="">Select options</option>
                            <option value="published">Publish</option>
                            <option value="draft">Draft</option>
                            <option value="delete">Delete</option>
                        </select> 
                    </div>
                    <button class="btn btn-primary ml-4" type="submit" name="apply"  style="float:left;">Apply</button> 
                </div>
                <form action=""></form>
                    <div class="col-md-2">
                        <form action="" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="searchTerm" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
                            <div class="input-group-prepend">                       
                                <button class="btn btn-outline-secondary" type="submit" name="search"><i class="fa fa-search"></i></button>                       
                            </div>
                        </form>
                    </div>
            </div>
            <div class="col-md-2">
                <form action="" method="post">                                               
                    <button class="btn btn-outline-secondary form-control w-50" type="submit" name="reset">Reset</button>                       
                </form>
            </div>
<!--                   TABLE COMMENTS                                                   -->            
            
            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12" id="showCategories">
                <table class="table table-responsive-lg table-responsive table-responsive-md table-responsive-sm table-responsive-xl table-hover table-bordered  mx-auto" id="categories" style="margin-bottom:5em;">
                    <thead class="">
                        <tr>
                            <th><input type="checkbox" id="checkAll"></th>
                            <th>Id</th>
                            <th style="width:90px;"><span class="float-left">Title</span> <div style="position:relative;width:50px; height:24px;"> <a href="<?php echo ROOT . "posts/sortBy/" . $pagination->current_page . "/titleDesc" ?>" class=""><i class="fa fa-angle-down ml-2 sortDownArrow"></i></a> <a href="<?php echo ROOT . "posts/sortBy/" . $pagination->current_page . "/titleAsc" ?>" class=""><i class="fa fa-angle-up ml-2 sortUpArrow"></i></a></div> </th>
                            <th style="width:90px;"> <span class="float-left">Author</span><div style="position:relative;width:50px; height:24px;"> <a href="<?php echo ROOT . "posts/sortBy/" . $pagination->current_page . "/authorDesc" ?>" class=""><i class="fa fa-angle-down ml-2 sortDownArrow"></i></a> <a href="<?php echo ROOT . "posts/sortBy/" . $pagination->current_page . "/authorAsc" ?>" class=""><i class="fa fa-angle-up ml-2 sortUpArrow"></i></a></div></th> 
                            <th>Photo</th>
                            <th>Content</th>
                            <th>Comments count</th>
                            <th>Status</th>
                            <th>Post category</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post) : ?>
                        <tr>
                            <td><input type="checkbox" class="checkboxArray" value="<?php echo $post->id; ?>" name="checkboxes[]"></td>
                            <td><?php echo $post->id; ?></td>
                            <td><a href="<?php echo !empty($post->post_user_id) ? ROOT . "users/post/$post->slug" : "#" ?>"><?php echo $post->post_title; ?></a></td>
                            <td><?php echo ($post->post_user_id == 0) ? $post->post_author : $post->user->user_name; ?></td>
                            
                            <td><img width='100' src="<?php echo ROOT . "images/upload_img/"; ?><?php echo ($post->post_image != "") ? $post->post_image : "placeholder.jpg"; ?>"></td>
                            <td><?php echo strip_tags(html_entity_decode(truncate($post->post_content))) ?></td>
                            <td><?php echo $post->post_comment_count; ?></td>
                            <td><?php echo $post->post_status; ?></td>
                            <td><?php echo !empty($post->category->cat_title) ? $post->category->cat_title : "Uncategorized"; ?></td>
                            <td><?php echo $post->created_at->diffForHumans(); ?></td>
                            <td><?php echo $post->updated_at->diffForHumans(); ?></td>
                            <td><a href="<?php echo ROOT ?>posts/update/<?php echo $post->id; ?>">Edit</a></td>
                            <td><a rel="<?php echo $post->id; ?>" href="#" class="deleteModal">Delete</a></td>
                        </tr>
                        <?php endforeach; ?> 
                    </tbody>
                </table>
            </div>
        </form>  
        </div>
        <nav aria-label="Page navigation example" class="ml-5">
             <?php if ($pagination->show_pagination()) : ?>
              <ul class="pagination">
                  <li class="page-item">
                      <?php if ($pagination->has_previous()) : ?>
                      <a class="page-link" href="<?php echo ROOT ?>posts/index/<?php echo $pagination->previous() ?>">Previous</a></li>
                      <?php endif; ?>
                        <?php for ($i = 1; $i <= ceil($pagination->count); $i++) : ?>
                             <li class='page-item <?php echo $pagination->current_page == $i ? "active" : "" ?>'><a class='page-link' href='<?php echo ROOT ?>posts/index/<?php echo $i ?>'><?php echo $i ?></a></li>  
                  <?php endfor; ?> 
                  <li class="page-item <?php echo $pagination->current_page == $i ? "active" : "" ?>">
                      <?php if ($pagination->has_next()) : ?>
                      <a class="page-link" href="<?php echo ROOT ?>posts/index/<?php echo $pagination->next() ?>">Next</a></li>
                      <?php endif; ?>
              </ul>
             <?php endif; ?>
          </nav>
       </div>    
      </div>    
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
