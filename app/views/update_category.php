
<?php require_once "admin/includes/header.php"; ?>
<?php require_once "admin/includes/navigation.php"; ?>


<?php 

$form = $params[0];
$the_category = $params[1];

?>



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
          <a href="#">Categories</a>
        </li>
        <li class="breadcrumb-item active">Update category</li>
      </ol>
    </div> 
    <div class="container mystyle">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <form role="form" action="" id="addCategory" method="post" >

                <?php if(!empty($form->form_values)): ?>
                
                
                <label>Update category</label><i class="required-star">*</i>
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 2em;">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group" style="float:left">
                          <input class="<?php echo $form->style["cat_title"] ?> form-control" type="text" name="cat_title" placeholder="Enter category">
                          <div style="color:#FF3366"><?php echo !empty($form->error["cat_title"]) ? $form->error["cat_title"]: "" ?></div>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                          <button class="btn btn-primary ml-4" style="float:left;" type="submit" name="update">Apply</button>
                      </div>  
                  </div>
                </div>
                
                <?php else: ?>
                
                <label>Update category</label><i class="required-star">*</i>
                 <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 2em;">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="form-group" style="float:left">
                          <input type="text" class="form-control" name="cat_title" value="<?php echo $the_category->cat_title ?>" placeholder="Enter category">
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                          <button class="btn btn-primary ml-4" style="float:left;" type="submit" name="update">Apply</button>
                      </div>  
                  </div>
                </div>
                
                
                <?php endif; ?>
                
            </form>
        </div> 

        
        <hr>
            
<!--                   TABLE CATEGORIES                                                   -->            
            
<i style="margin-top:35em;" class="required-star">*-->Field required</i> 
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








