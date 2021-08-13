<?php include_once('header.php');  ?>

<div class="page-dashboard">
        <div class="container-fluid"> 
        <div class="row">  
            <div class="col-12 col-md-12">
                <div class="admin_menus">
                    <div class="logo_wr adminlogo my-3 text-center">  
                        <div class="display-7"><a class="text-white" style="text-decoration: none; " target="_blank" href="<?php echo site_url('/'); ?>">ez<span>BLOG</span></a></div>
                    </div>
                    <ul class="list-group rounded-0 border-0">
                        <?php 
                        
                        if($_SESSION['user_role']=='administrator') {      
                            include_once('admin-menu.php'); 
                        }
                        
                        if($_SESSION['user_role']=='author') {     
                            include_once('author-menu.php'); 
                        }
                            
                        ?> 
                    </ul>    
                </div> 
                <?php  
                if(isset($_GET['action']) && isset($_GET['type'])) {
                    
                    // Administrator  
                    if($_SESSION['user_role']=='administrator') { 

                        if(($_GET['action']=='edit') && ($_GET['type']=='profile')) {
                                include_once('pages/edit-profile.php');   
                        }  

                        if(($_GET['action']=='manage') && ($_GET['type']=='addblog')) {
                              include_once('pages/add-blog.php');    
                        }  
                        
                        if(($_GET['action']=='manage') && ($_GET['type']=='addauthor')) {
                              include_once('pages/add-author.php');    
                        }   
                        
                        if(($_GET['action']=='edit') && ($_GET['type']=='editblog')) {
                              include_once('pages/edit-blog.php');    
                        }  
                       
                        if(($_GET['action']=='manage') && ($_GET['type']=='blog')) {
                              include_once('pages/blog-list.php');    
                        }   
                      
                        if(($_GET['action']=='manage') && ($_GET['type']=='authors')) {
                              include_once('pages/author-list.php');    
                        }  
                        
                        if(($_GET['action']=='manage') && ($_GET['type']=='style')) {
                              include_once('pages/css-editor.php');    
                        }   
                        
                        if(($_GET['action']=='manage') && ($_GET['type']=='layout')) { 
                              include_once('pages/header-footer-editor.php');    
                        }   
                        
                        if(($_GET['action']=='manage') && ($_GET['type']=='settings')) {
                              include_once('pages/settings.php');           
                        }   
                        
                        if(($_GET['action']=='manage') && ($_GET['type']=='users')) {
                              include_once('pages/manage-users.php');   
                        }  

                        if(($_GET['action']=='edit') && ($_GET['type']=='users') && isset($_GET['uid'])) {
                              include_once('pages/edit-user.php');   
                        }

                        if(($_GET['action']=='add') && ($_GET['type']=='user')) {
                              include_once('pages/add-user.php');   
                        } 

                    } 
                    
                    if($_SESSION['user_role']=='author') {
                        
                        if(($_GET['action']=='edit') && ($_GET['type']=='profile')) {
                                include_once('pages/edit-profile.php');   
                        }  

                        if(($_GET['action']=='manage') && ($_GET['type']=='addblog')) {
                              include_once('pages/add-blog.php');    
                        }
                        
                        if(($_GET['action']=='edit') && ($_GET['type']=='editblog')) {
                              include_once('pages/edit-blog.php');    
                        }  
                       
                        if(($_GET['action']=='manage') && ($_GET['type']=='blog')) {
                              include_once('pages/blog-list.php');    
                        }   
                     
                    }
                        
                } else { 
                    include_once('pages/welcome.php');   
                }                  
                
                ?>
            </div>   
          
        </div>
        </div>
</div>    
               
<?php include_once('footer.php'); 