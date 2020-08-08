
<?php 
$categories = $params[0];
$pagination = $params[1];
$msg        = $params[2];
?>

<?php require_once "admin/includes/header.php"; ?>
<?php require_once "admin/includes/navigation.php"; ?>

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
        <?php if(!empty($msg)) :?>    
            <?php $class = $msg['type'] === 'success' ? 'bg-success' : 'bg-warning'  ?>    
            <div style="color:#fff" class="bg <?php echo $class ?> form-control"> <?php echo $msg['text'] ?></div>     
        <?php else: ?>
            <li class="breadcrumb-item">
              <a href="#">Categories</a>
            </li>
            <li class="breadcrumb-item active">My categories</li>    
        <?php endif; ?>
      </ol>
    </div> 
    <div class="col-lg-12 mystyle">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">     
        </div> 
        <hr>     
<!--                   TABLE CATEGORIES                                                   -->            
            <div class="col-md-12" id="showCategories">
                <table class="table table-hover table-bordered mx-auto" id="categories" style="margin-bottom:5em;">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Category Title</th>
                            <th>Created</th>
                            <th>Updated</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                         <?php    foreach($categories as $category) : ?>
                        
                            <tr>
                                <td><?php echo $category['id'] ?></td>
                                <td><?php echo $category['cat_title'] ?></td>
                                <td><?php echo $category->created_at->diffForHumans() ?></td>
                                <td><?php echo $category->updated_at->diffForHumans() ?></td>
                                <td><a href="<?php echo ROOT."categories/update/".$category['id'] ?>">Edit</a></td>
                                <td><a style="text-decoration: none;" rel="<?php echo $category['id'] ?>" href="#" class="deleteModal">Delete</a></td>
                             </tr>
                        <?php  endforeach; ?>     
                    </tbody>
                </table> 
                <nav aria-label="Page navigation example">
                            <?php if($pagination->show_pagination()): ?>
                            <ul class="pagination">
                                <li class="page-item">
                                    <?php if ($pagination->has_previous()): ?>
                                        <a class="page-link" href="<?php echo ROOT ?>categories/index/<?php echo $pagination->previous() ?>">Previous</a></li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= ceil($pagination->count); $i++): ?>
                                    <li class='page-item <?php echo $pagination->current_page == $i ? "active" : "" ?>'><a class='page-link' href='<?php echo ROOT ?>categories/index/<?php echo $i ?>'><?php echo $i ?></a></li>
                                <?php endfor; ?> 
                                <li class="page-item">
                                <?php if ($pagination->has_next()): ?>
                                        <a class="page-link <?php echo $pagination->current_page == $i ? "active" : "" ?>" href="<?php echo ROOT ?>categories/index/<?php echo $pagination->next() ?>">Next</a></li>
                                <?php endif; ?>
                            </ul> 
                            <?php endif; ?>  
                        </nav>
            </div>
        </div>
    </div>
   </div>
<!--                   MODAL BOX                                                       -->
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
<!--                   MODAL BOX                                                       -->
</div>  
<?php require_once "admin/includes/footer.php"; ?>








