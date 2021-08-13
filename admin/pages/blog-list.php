<?php

/*
 * Bulk Update 
 */
if(isset($_POST['bulk_submit'])) {
    
    extract($_POST);      
        
    if($blog_bulk_action!='') {   
        if($blog_bulk_action=='Delete') {
            
            $status = $blog->delete_from_list($bloglist);   
            if($status) {  
                echo "<div class='alert alert-success'>Blogs deleted.</div>";  
            }
        }  
        if($blog_bulk_action=='Published') {
            $ustatus = $blog->update_status($bloglist, $blog_bulk_action);   
            if($ustatus) {
                echo "<div class='alert alert-success'>Blogs status updated to Published.</div>";  
            }
        }
        if($blog_bulk_action=='Draft') {
            $ustatus = $blog->update_status($bloglist, $blog_bulk_action);
            if($ustatus) {
                echo "<div class='alert alert-success'>Blogs status updated to Draft.</div>";  
            }
        }
    } else {
        echo "<div class='alert alert-danger'>Please select bulk action.</div>"; 
    }
} 
  
/*
 * Delete Blog
 */ 
if(isset($_GET['bid']) && isset($_GET['action2']) && ($_GET['action2'])=='delete') {

    $blog_id = $_GET['bid']; 
 
    if($_SESSION['user_role']=='administrator') {    
        if(isset($_GET['confirm']) && ($_GET['confirm']==1)) {
            $status = $blog->delete($blog_id);   
            if($status) {
                echo "<div class='alert alert-success'>Blog post deleted successfully.</div>"; 
            } else {
                echo "<div class='alert alert-danger'>Blog post not deleted. Try again.</div>"; 
            }   
        } else {  
             $confirm_url = admin_url('/admin.php?action=manage&type=blog&action2=delete&bid='.$blog_id.'&confirm=1'); 
             $cancel_delete_url = admin_url('/admin.php?action=manage&type=blog');  
             ?>
             <div class="alert alert-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Are you sure you want to delete blog post(<?php echo $blog_id; ?>)? <a href='<?php echo $confirm_url; ?>' class="btn btn-danger">Yes</a> <a href='<?php echo $cancel_delete_url; ?>' class="btn btn-success">No</a></div>
             <?php 
        } 
    } else {
        echo '<div class="alert alert-warning">You don\'t have permission to delete article.</div>'; 
    }

}  

    $databasepath =  HPDIRPATH.'/database/'; 
    $foldersize = get_directory_size($databasepath);  
//    echo get_size_units($foldersize); 
  
    $df = disk_total_space($databasepath); 
//    echo get_size_units(get_size_units($df)); 
    
    $floatval = $foldersize*100/$df;  
    $outputarr = explode('.',$floatval);
    $sizeper = $outputarr['0'];
    
?>
<div class="row">  
    <div class="col-12">
        <form action="" method="post" enctype="multipart/form-data">
                        
        <div class="blog_list_design add_blog_design">  
      
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: <?php echo $sizeper; ?>%;" aria-valuenow="<?php echo $sizeper; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $sizeper; ?>%</div>
            </div>
                   
            <div class="form-row"> 
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <h5>Blog List</h5>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                </div>
            </div>
              
            <div class="form-row">
                <div class="col custom_lbloglist"> 
                    <div class="form-group blog_list_field">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="blog_check_all">
                            <label class="custom-control-label" for="blog_check_all">Select All</label>
                        </div>    
                        <select class="custom-select" id="blog_bulk_action" name="blog_bulk_action">
                            <option value="">Action</option>
                            <option value="Draft">Draft</option>
                            <option value="Published">Published</option> 
                            <option value="Delete">Delete</option> 
                        </select> 
                        <input type="submit" name="bulk_submit" class="btn btn-success text-white border-0" value="Apply">
                    </div>   
                </div> 
                <div class="col">    
                    <div class="form-group">
                        <a href="<?php echo admin_url('/admin.php?action=manage&type=addblog'); ?>" class="btn btn-primary float-right">Create New</a> 
                    </div>
           
<!--                    <div class="form-group blog_search_field">   
                        <input type="text" value="" placeholder="Search..." name="blog_list_search" class="form-control" id="blog_list_search" />
                        <label class="btn btn-primary" for="blog_list_search"><i class="fas fa-search"></i></label>
                    </div>-->
                </div>
            </div> 
            
            <!--Blog List-->
            <div class="users_table">
                <?php $bloglist = $blog->get_blogs(); ?>   
                <table id="blog_list_table" class="table" style="font-size: 12px; width:100%;" >
                <thead>
                    <tr> 
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Blog URL</th>
                        <th scope="col">Meta Title</th>
                        <th scope="col">Meta Description</th>
                        <th scope="col">Author (ID)</th> 
                        <th scope="col">Status</th>  
                        <th scope="col">Registered</th>  
                        <th scope="col">Action</th>
                    </tr> 
                </thead>
                <tbody>  
                    <?php 
                    if($bloglist) { 
                       
                        foreach($bloglist as $blogdata) { 
                             
                            $blog_id            = $blogdata->id;   
                            $blog_title         = $blogdata->blog_title;  
                            $custom_blog_url    = $blogdata->custom_blog_url;  
                            $blog_content       = $blogdata->blog_content;  
                            $blog_meta_title    = $blogdata->blog_meta_title;  
                            $blog_meta_desc     = $blogdata->blog_meta_desc;   
                            $blog_author        = $blogdata->blog_author;  
                            $blog_post_status   = $blogdata->blog_post_status;  
                            $blog_registered    = $blogdata->blog_registered;   
                            
                            if($blog_post_status=='Published') {
                                $blog_post_status = '<span class="text-success">'.$blog_post_status.'</span>';
                                $blog_url = blog_url('/'.$custom_blog_url);   
                            } else {
                                $blog_post_status = '<span class="text-secondary">'.$blog_post_status.'</span>';
                                $blog_url = admin_url('/draft-article.php?action=draft&blogid='.$blog_id);       
                            }
                            
                            // Author Name
                            $userdata = $user->get_user_by_id($blog_author);
                            $authorname = $userdata->firstname.' '.$userdata->lastname;
                        ?>   
                        <tr>   
                            <td><input type="checkbox" value="<?php echo $blog_id; ?>" name="bloglist[]" class="table_checkboxes" /></td> 
                            <td><?php echo $blog_id; ?></td> 
                            <td><a target="_blank" href="<?php echo $blog_url; ?>"><?php echo $blog_title; ?> (<?php echo $blog_id; ?>)</a></td> 
                            <td><a target="_blank" href="<?php echo $blog_url; ?>"><?php echo $custom_blog_url; ?></a></td>
                            <td><?php echo $blog_meta_title; ?></td>
                            <td><?php echo $blog_meta_desc; ?></td>  
                            <td><?php echo $authorname; ?> (<?php echo $blog_author; ?>)</td>
                            <td><?php echo $blog_post_status; ?></td>  
                            <td><?php echo get_formatted_datetime($blog_registered); ?></td>  
                            <td style="min-width: 90px;" class="text-center"> 
                                <a style="font-size: 10px; " title="Edit" class="btn btn-primary btn-sm" href="<?php echo admin_url('/admin.php?action=edit&type=editblog&bid='.$blog_id); ?>">Edit</a>  
                                <a style="font-size: 10px; " title="Delete" class="btn btn-danger btn-sm" href="<?php echo admin_url('/admin.php?action=manage&type=blog&action2=delete&bid='.$blog_id); ?>">Delete</a>
                            </td>
                        </tr>  
                        <?php 
                        }  } 
                        ?>

                </tbody>
                </table>

            </div>
            <!--Blog List End-->
            
        </div> 
        <!--blog_list_design End--> 
        
        </form>   
    </div>
</div>    
 
    