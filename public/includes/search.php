

<div class="card my-5">
    <h5 class="card-header mt-0">Search</h5>
    <div class="card-body">
        <form method="post" action="<?php echo ROOT."posts/search/" ?>">
        <div class="input-group">
            
            <input type="text" name="keywords" class="form-control" placeholder="Search for...">
            <span class="input-group-btn">
                <button class="btn btn-success" name="search" type="submit">Go!</button>
            </span>
            
           
        </div>
             </form>
    </div>
</div>