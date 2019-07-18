<?php

/*
*  Update Blog Post  
*/  
   if(isset($_POST['update_blog'])) {  

        $blogsavestatus = $blog->update();  
                    
        if($blogsavestatus) {
            echo "<div class='alert alert-success text-center'>Your blog post has been updated successfully.</div>" ;  
        } else {
            echo "<div class='alert alert-danger'>Unable to update blog post. Please refresh page and try again.</div>" ;  
        } 
        
    }             
  
/* 
 * Get Blog Details
 */ 
    
if(isset($_GET['bid']) && isset($_GET['type']) && ($_GET['type']=='editblog')) {   
    
    $blog_id    = $_GET['bid'];
    $blogdata   = $blog->get_blog_by_id($blog_id);
     
    if($blogdata) {       

?>

<div class="row">     
    <div class="col-12">
        <form action="" class="add_blog_design" method="post" enctype="multipart/form-data"> 
            <?php 
            
             
            // Take Over  
            if(isset($_GET['take_over'])) { 
               $tstatus =  $blog->blog_takeover($blog_id, $_SESSION['full_name']); 
               if($tstatus) {
                   redirect_script(admin_url('/admin.php?action=edit&type=editblog&bid='.$blog_id.''));
               }
            }
              
            $temp_edit = $blog->get_temp_edit();
            $estatus = 0; 
            
            if($temp_edit) {   
                foreach($temp_edit as $teb) { 
                    
                    if(($teb->blog_id==$blog_id) && ($_SESSION['full_name']!=$teb->author_name)) {
                        ?>
                        <div class="already_inuse">  
                            <p>The article is being edited by <b><?php echo $teb->author_name; ?></b></p>
                            <p><a href="<?php echo admin_url('/admin.php?action=edit&type=editblog&bid='.$blog_id.'&take_over=true'); ?>" class="btn btn-primary">Take Over</a></p>
                        </div>    
                        <?php 
                        $estatus = 1; 
                        break; 
                    }
                }
            } 
            
            if($estatus==0) {
                $tstatus =  $blog->insert_temp_edit($blog_id, $_SESSION['full_name']); 
            }
            
            ?> 
            <input type="hidden" name="blog_id" value="<?php echo $blog_id; ?>"  />
       
            <div class="form-group blog_title">
                <label>Blog Title |</label>
                <input type="text" value="<?php echo $blogdata->blog_title; ?>" name="blog_title" class="form-control" />
            </div>

            <div class="form-group blog_sub_title">
                <label>Blog Sub Title |</label> 
                <input type="text" value="<?php echo $blogdata->blog_sub_title; ?>" name="blog_sub_title" class="form-control" />
            </div> 
            
            <div class="form-group blog_custom_url">
                <h5>Custom URL</h5>
                <div class="form-row">
                    <div class="col-1 text-left">
                        <label class="switch">   
                            <input type="checkbox" <?php echo checked($blogdata->custom_url_switch, 1); ?> name="custom_url_switch" value="1">
                            <span class="slider round"></span>
                        </label> 
                    </div>  
                    <div class="col-11 custom_url_field">
                        <label>/blog/</label>
                        <input type="custom_url" value="<?php echo $blogdata->custom_blog_url; ?>" name="custom_blog_url" class="form-control" placeholder="custom-blog-url.html" />
                    </div>
                </div>
            </div>
            
            <div class="form-group blog_content_editor">
                <div class="form-row">
                    <div class="col-12">
                        <textarea class="form-control" name="blog_content" id="editor"><?php echo $blogdata->blog_content; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-row"> 
                <div class="col-12 col-md-6">
                    <div class="form-group featured_image_field"> 
                        <label>Blog Featured Image</label>
                        <input type="file" value="<?php echo $blogdata->blog_featured_image; ?>" name="blog_featured_image" class="form-control" />      
                    </div>
                </div>
                <div class="col-12 col-md-6">  
                    <a class="fancybox" data-lightbox="example-2" data-title="" href="<?php echo upload_url($blogdata->blog_featured_image); ?>" ><img class="img-thumbnail img-responsive m-0 mb-2" width="100" height="100" src="<?php echo upload_url($blogdata->blog_featured_image); ?>" alt="" /></a> 
                </div>
            </div>
               
            <div class="form-row"> 
                <div class="col-12 col-md-6">
                    <div class="form-group blog_meta_title">
                        <label>Meta Title</label>
                        <input type="blog_meta_title" value="<?php echo $blogdata->blog_meta_title; ?>"  name="blog_meta_title" class="form-control" />
                    </div>
                    <div class="form-group blog_meta_desc">
                        <label>Meta Description</label>
                        <textarea type="blog_meta_desc" name="blog_meta_desc" class="form-control"><?php echo $blogdata->blog_meta_desc; ?></textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group blog_author">
                        <?php $authors = $user->get_users(); ?> 
                        <select class="custom-select"  id="blog_author" name="blog_author" required="required">
                            <?php  
                                if($_SESSION['user_role']=='administrator') { ?> 
                                    <option <?php echo selected($blogdata->blog_author,0); ?> value="0">Admin</option> 
                                <?php }  
                            ?> 
                            <?php     
                                if($authors) {   
                                    foreach($authors as $author) {    
//                                        if($author->role=='author') { ?>           
                                            <option <?php echo selected($blogdata->blog_author, $author->id); ?> value="<?php echo $author->id; ?>"><?php echo $author->firstname.' '.$author->lastname; ?></option>'; 
                                        <?php // }
                                    } 
                                }   
                            ?>
                        </select>
                    </div>
                    <div class="form-group blog_post_status">
                        <select class="custom-select" id="blog_post_status" name="blog_post_status">
                          <option <?php echo selected($blogdata->blog_post_status, ''); ?> value="">Status - Draft | Published</option>
                          <option <?php echo selected($blogdata->blog_post_status, 'Draft'); ?> value="Draft">Draft</option>
                          <option <?php echo selected($blogdata->blog_post_status, 'Published'); ?> value="Published">Published</option> 
                        </select>
                    </div>
                </div>  
                <div class="col-12">
                    <div class="form-group save_blog_btn">
                        <button type="submit" name="update_blog" class="btn btn-primary float-right">Publish</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>    
 
     
<?php 
    } else {
        echo '<div class="alert alert-danger">Unable to retrive the data. Try again.</div>';
    }
} else {
    echo '<div class="alert alert-danger">Invalid URL. Try again.</div>';
}  