<?php include_once('admin/config.php'); ?> 
<?php include_once('admin/functions.php'); ?>   

<?php  
    
    //Blog Informations 
    $bloginfo = blog_info(); 
       
    $blog_title    = $bloginfo->blog_name;
    $meta_title    = $bloginfo->blog_meta_title;
    $meta_desc     = $bloginfo->blog_meta_desc; 
    $meta_author        = $bloginfo->blog_name;   
  
    include_once('admin/blog_header.php');      
    
    $blogs = $blog->get_blogs($blog_id);    
    
   
    ?> 
    <link type="text/css" href="admin/css/jquery.dataTables.min.css" rel="stylesheet" /> 
              
    <div class="container"> 
        <div class="row">
            <div class="col-12">  
                <div class="custom_blog_html"> 
                    <h2 class="blog_page_heading">Blog Page</h2>   
                    <div class="blog_listing_front">
                    <table id="blog_list_front" >
                        <thead style="display:none;">
                            <tr>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                 if($blogs) {
                                     foreach($blogs as $blogdata) {
                                         $blog_post_status   = $blogdata->blog_post_status;   
                                         if($blog_post_status=='Published') {
                                             $blog_title         = $blogdata->blog_title; 
                                             $blog_sub_title     = $blogdata->blog_sub_title; 
                                             $custom_blog_url    = $blogdata->custom_blog_url; 
                                             $blog_content       = $blogdata->blog_content;
                                             $blog_url = blog_url('/'.$custom_blog_url);  
                                             $blog_featured_image= $blogdata->blog_featured_image;    

                                             ?>

                                                 <tr>
                                                     <td>
                                                         <div class="blog_list">  
                                                             <h3 class="main_heading"><a href="<?php echo $blog_url; ?>"><?php echo strip_tags($blog_title); ?></a></h3>
                                                               <h4 class="sub_heading"><?php echo strip_tags($blog_sub_title); ?></h4>     
                                             
                                                            <?php if($blog_featured_image!='') { ?>   
                                                                <div class="imgthumbnail_wr">
                                                                <a href="<?php echo $blog_url; ?>"><img class="img-responsive" src="<?php echo upload_url($blog_featured_image); ?>" alt="" /></a> </div>
                                                            <?php } ?> 
                                                             <p><?php echo strip_tags(trim_words($blog_content, 16)); ?></p>

                                                         </div>
                                                     </td>
                                                 </tr>

                                             <?php 
                                         }
                                     }
                                 }
                             ?> 
                         </tbody>

                     </table> 

                    </div>
                </div>
            </div>
        </div> 
    </div>
    <?php      
 
    include_once('admin/blog_footer.php');   
    

    $pagename =  basename($_SERVER['PHP_SELF']);  
    if($pagename=='index.php') { ?>
    <!-- Index Page Scripts-->
    <script type="text/javascript" src="admin/js/jquery.min.js"></script> 
    <script type="text/javascript" src="admin/js/jquery.dataTables.min.js"></script>
    <script>jQuery("document").ready(function(e){table_lenght="<?php echo $bloginfo->blog_pagination; ?>",""===table_lenght&&(table_lenght=10);jQuery("#blog_list_front").DataTable({paging:!0,ordering:!1,info:!1,pageLength:parseInt(table_lenght),aaSorting:[],searching:!1})}); </script>
    <?php }  ?>
    
</body>
</html>

 
 