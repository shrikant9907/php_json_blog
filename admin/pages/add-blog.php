<?php
/* 
* Add New Blog  
*/  
   if(isset($_POST['save_blog'])) {  

        $blogsavestatus = $blog->add_blog();   
           
        if($blogsavestatus==1) {
            echo "<div class='alert alert-success'>Your blog post has been saved successfully.</div>" ;  
            $redurl = admin_url('/admin.php?action=manage&type=blog');  
            redirect_withdelay_script($redurl); 

        } else if($blogsavestatus==3){     
            echo '<div class="alert alert-danger">Invalid file format in custom url.</div>';
        } else {
            echo "<div class='alert alert-danger'>Unable to insert blog. Please refresh page and try again.</div>" ;  
        } 

    }            
           
?>   
 
<div class="row">  
    <div class="col-12">
        <form action="" class="add_blog_design" method="post" enctype="multipart/form-data"> 
            
            <div class="form-group blog_title">
                <label>Blog Title |</label>
                <input type="text" value="" name="blog_title" class="form-control" required="required" />
            </div>

            <div class="form-group blog_sub_title">
                <label>Blog Sub Title |</label>
                <input type="text" value="" name="blog_sub_title" class="form-control" />
            </div> 
    
            <div class="form-group blog_custom_url">
                <h5>Custom URL</h5>
                <div class="form-row">
                    <div class="col-1 text-left">
                        <label class="switch">
                            <input type="checkbox" name="custom_url_switch" value="1">
                            <span class="slider round"></span>
                        </label> 
                    </div>  
                    <div class="col-11 custom_url_field">
                        <label>/blog/</label>
                        <input type="custom_url" value="" name="custom_blog_url" class="form-control" placeholder="custom-blog-url.html" />
                    </div>
                </div>
            </div>
     
            <div class="form-group blog_content_editor">
                <div class="form-row">
                    <div class="col-12">
                        <textarea class="form-control" name="blog_content" id="editor" ></textarea> 
                    </div>
                </div>
            </div> 
     
            <div class="form-row"> 
                <div class="col-12">
                    <div class="form-group featured_image_field"> 
                        <label>Blog Featured Image</label>
                        <input type="file" value="<?php echo $blogdata->blog_featured_image; ?>" name="blog_featured_image" class="form-control" />      
                    </div>  
                </div>
            </div>
               
            <div class="form-row"> 
                <div class="col-12 col-md-6">
                    <div class="form-group blog_meta_title">
                        <label>Meta Title</label>
                        <input type="blog_meta_title" value=""  name="blog_meta_title" class="form-control" />
                    </div>
                    <div class="form-group blog_meta_desc">
                        <label>Meta Description</label>
                        <textarea type="blog_meta_desc" name="blog_meta_desc" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group blog_author">
                        <?php $authors = $user->get_users(); ?>  
                        <select class="custom-select"  id="blog_author" name="blog_author" > 
                            <option value="">Author</option>    
                               
                            <?php  
                                if($authors) {  
                                    if($_SESSION['user_role']=='administrator') {
                                        echo '<option '.selected($_SESSION['user_id'],0).' value="0">Admin</option>';  
                                    } 
                                    foreach($authors as $author) { 
                                        echo '<option '.selected($_SESSION['user_id'],$author->id).' value="'.$author->id.'">'.$author->firstname.' '.$author->lastname.'</option>';                                      
//                                        if($_SESSION['user_role']=='administrator') {
//                                            echo '<option '.selected($_SESSION['user_id'],0).' value="0">Admin</option>';  
////                                            echo '<option '.selected($_SESSION['user_id'],$author->id).' value="'.$author->id.'">'.$author->firstname.' '.$author->lastname.'</option>'; 
//                                        }
//                                         else {
//                                            if($author->role=='author') {     
//                                                echo '<option '.selected($_SESSION['user_id'],$author->id).' value="'.$author->id.'">'.$author->firstname.' '.$author->lastname.'</option>'; 
//                                            }
//                                        }
                                    }
                                }  
                            ?>
                        </select>
                    </div>
                    <div class="form-group blog_post_status">
                        <select class="custom-select" id="blog_post_status" name="blog_post_status" required="required">  
                          <option value="">Status - Draft | Published</option>    
                          <option value="Draft">Draft</option>
                          <option value="Published">Published</option> 
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group save_blog_btn">
                        <button type="submit" name="save_blog" class="btn btn-primary float-right">Publish</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>    
 
     