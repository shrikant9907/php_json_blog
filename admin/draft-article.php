<?php 
 
if(($_GET['action']=='draft') && isset($_GET['blogid'])) {  ?>

<?php include_once('config.php'); ?> 
<?php include_once('functions.php'); ?>   

<?php  
if(isset($_SESSION['user_id'])) {
    
    $blog_id = $_GET['blogid']; 
    $blogdata = $blog->get_blog_by_id($blog_id);    

    $blog_title         = $blogdata->blog_title; 
    $blog_sub_title     = $blogdata->blog_sub_title; 
    $custom_blog_url    = $blogdata->custom_blog_url; 
    $blog_content       = $blogdata->blog_content;
    $blog_meta_title    = $blogdata->blog_meta_title;
    $blog_meta_desc     = $blogdata->blog_meta_desc; 
    $blog_author        = $blogdata->blog_author;   
    $blog_post_status   = $blogdata->blog_post_status;     
    $blog_featured_image= $blogdata->blog_featured_image;    

    include_once('blog_header.php');      
    ?> 
    <div class="container"> 
        <div class="row">
            <div class="col-12">  
                <div class="custom_blog_html"> 
                <h2><?php echo $blog_title; ?></h2>   
                <h3><?php echo $blog_sub_title; ?></h3>    
 
                <?php if($blog_featured_image!='') { ?>  
                    <img class="img-thumbnail img-responsive m-0 mb-2" src="<?php echo upload_url($blog_featured_image); ?>" alt="" /> 
                <?php } ?>
                <?php echo $blog_content; ?>
                </div>
            </div>
        </div>
    </div>
    <?php     
 
    include_once('blog_footer.php');   

} else {
    redirect_script(site_url('/')); 
}
    }    
