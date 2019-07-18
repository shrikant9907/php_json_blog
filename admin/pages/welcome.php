<div class="row">  
    <div class="col-12">
        <div class="welcome_panel"> 
            <h2>Welcome to EZBlog!</h2>
            <h3>The Best Plug & Play Blogging Solution</h3>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into</p>
            <p>  
                <?php if($_SESSION['user_role']=='administrator') { ?>
                    <a href="<?php echo admin_url('/admin.php?action=manage&type=settings'); ?>" class="btn btn-outline-primary">Settings</a> 
                <?php } ?>
                <a href="<?php echo admin_url('/admin.php?action=manage&type=addblog'); ?>" class="btn btn-primary">Start Blogging</a>
            </p>
        </div>
    </div>
</div>    
 
      