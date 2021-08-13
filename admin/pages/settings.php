<?php 

if(isset($_POST['save_bloginfo'])) { 
    $settings->update($_POST);       

    ?>    
   <div class="">Please regenerate templates after making the changes in <b>Search Engine Visibility</b> and <b>Breadcrumb</b> settings. <a class="btn btn-primary btn-sm" href="<?php echo admin_url('/admin.php?action=manage&type=settings&regenhtml=1'); ?>">Regenerate Blog Templates</a></div> 
    <?php   
} 

$bloginfo = $settings->get();   
/*
 * Regenerate HTML Templates
 */
if(isset($_GET['type']) && isset($_GET['regenhtml']) && ($_GET['type']=='settings') && ($_GET['regenhtml']=='1')) {
    
    echo '<div class="alert alert-info">Blog post template regeneration started. Please do not close this window or refresh until it shows success message.</div>';
    
    $status = $blog->regen_templates();
    
    if($status) {
        $redurl = admin_url('/admin.php?action=manage&type=settings&regenhtml=3');
        redirect_script($redurl); 
    }
     
} 

if(isset($_GET['regenhtml']) && ($_GET['regenhtml']=='3') && (!isset($_POST['save_bloginfo']))) { 
    echo '<div class="alert alert-success">Blog templates has been generated successfully.</div>';
}

?>

<div class="settings_page_design">  
    <div class="row">  
            <div class="col-12 ">
   
            </div>
    </div>
    <form action="" class="" method="post" autocomplete="off">
        <div class="row">  
            <div class="col-12 col-md-6">

                <h5>Blog Info</h5>

                <div class="form-group">
                    <label>Blog Name </label>
                    <input type="text" class="form-control" value="<?php echo $bloginfo->blog_name; ?>" name="blog_name" required="required" autofocus />
                </div>

                <div class="form-group">
                    <label>Blog Meta Title </label>
                    <input type="text" class="form-control" value="<?php echo $bloginfo->blog_meta_title; ?>" name="blog_meta_title" required="required" />
                </div>

                <div class="form-group">
                    <label>Blog Meta Description </label>
                    <textarea class="form-control" name="blog_meta_desc"><?php echo $bloginfo->blog_meta_desc; ?></textarea>
                </div>

                <div class="form-group">
                    <label>Site URL </label>
                    <input type="text" class="form-control" value="<?php echo $bloginfo->site_url; ?>" name="site_url" required="required" />
                </div> 
                <div class="form-group">
                    <label>Blog URL </label>
                    <input type="text" class="form-control" value="<?php echo $bloginfo->blog_url; ?>" name="blog_url" required="required" />
                </div> 

                <div class="form-group">
                    <label>Admin Email </label>
                    <input type="email" class="form-control" value="<?php echo $bloginfo->admin_email; ?>" name="admin_email" required="required" />
                </div> 

                <div class="form-group">
                    <label>Time Zone </label>
                    <?php $timezones = timezone_identifiers_list();  ?>
                    <select class="custom-select" id="time_zone" name="time_zone">
                        <?php 
                            if($timezones) { 
                                foreach($timezones as $tzkey => $timezone) {
                                    echo '<option '.selected($timezone, $bloginfo->time_zone).'  value="'.$timezone.'">'.$timezone.'</option>';    
                                }
                            }
                        ?>
                    </select>
                </div> 
 
                <div class="form-group">
                    <label>Pagination (Max - Posts per page)</label>
                    <input type="text" class="form-control" value="<?php echo $bloginfo->blog_pagination; ?>" name="blog_pagination" required="required" />
                </div> 

                <div class="form-group">
                    <label>Search Engine Visibility </label> 
                    <select class="custom-select" id="search_engine_visibility" name="search_engine_visibility">
                        <option <?php echo selected($bloginfo->search_engine_visibility, '1') ?> value="1">ALLOW INDEX ALL PAGES</option>
                        <option <?php echo selected($bloginfo->search_engine_visibility, '0') ?> value="0">OFF</option>
                    </select>
                 </div> 

                <div class="form-group">
                    <label>Breadcrumb </label>  
                    <select class="custom-select" id="blog_breadcrumb" name="blog_breadcrumb"> 
                        <option <?php echo selected($bloginfo->blog_breadcrumb, 'No') ?> value="No">No</option>
                        <option <?php echo selected($bloginfo->blog_breadcrumb, 'Yes') ?> value="Yes">Yes</option>
                    </select>
                </div> 

            </div>   
            <!--Col 1 End-->
            <div class="col-12 col-md-6 social_media_settings">

                <h5>Social Media</h5>
                <div class="form-group">
                    <label>Facebook</label>
                    <i class="fab fa-facebook-f"></i>
                    <input type="text" class="form-control" value="<?php echo $bloginfo->blog_fb_url; ?>" name="blog_fb_url" />
                </div>

                <div class="form-group">
                    <label>Instagram</label>
                    <i class="fab fa-instagram"></i>
                    <input type="text" class="form-control" value="<?php echo $bloginfo->blog_insta_url; ?>" name="blog_insta_url" />
                </div>

                <div class="form-group">
                    <label>Twitter</label>
                    <i class="fab fa-twitter"></i>
                    <input type="text" class="form-control" value="<?php echo $bloginfo->blog_twitter_url; ?>" name="blog_twitter_url" />
                </div>

            </div> 
             <!--Col 2 End-->
        </div>
        <!--Row 1 End-->
        
        <div class="row">
            <div class="col-12"> 
                <button name="save_bloginfo" class="btn btn-success btn-inline-block rounded-0 float-right ml-2" type="submit">Save</button>
            </div> 
        </div>
        <!--Row 2 End-->

    </form>
    <!--Form End-->
</div>
 
           

