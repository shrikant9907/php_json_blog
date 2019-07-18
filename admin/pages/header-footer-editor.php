<link rel="stylesheet" href="css/codemirror.css">
 
<?php 
/*
 * Regenerate HTML Templates
 */
if(isset($_GET['type']) && isset($_GET['regenhtml']) && ($_GET['type']=='layout') && ($_GET['regenhtml']=='1')) {
    
    echo '<div class="alert alert-info">Blog post template regeneration started. Please do not close this window or refresh until it shows success message.</div>';
    
    $status = $blog->regen_templates();
    
    if($status) {
        $redurl = admin_url('/admin.php?action=manage&type=layout&regenhtml=3');
        redirect_script($redurl); 
    }
     
} 

if(isset($_GET['regenhtml']) && ($_GET['regenhtml']=='3')) { 
    echo '<div class="alert alert-success">Blog templates has been generated successfully.</div>';
}

?>

<div class="row">  
    <div class="col-12 text-center pt-3"><p>You can use this button to regenerate blog posts html templates again. <a class="btn btn-primary" href="<?php echo admin_url('/admin.php?action=manage&type=layout&regenhtml=1'); ?>">Regenerate Blog Templates</a></p></div></div>
    <div class="col-12">
        <?php   
         
         
        // Save header.php
        if(isset($_POST['save_header'])) {  
              
            $headercode = $_POST['headercode'];
            $headerfilepath = SYSTEMPATH.'/blog_header.php';  
            file_put_contents($headerfilepath, $headercode);     
            
            echo "<div class='alert alert-success'>Header file updated successfully.</div>"; 
                       
        }
      
        // Save footer.php
        if(isset($_POST['save_footer'])) {  
             
            $footercode = $_POST['footercode']; 
            $footerfilepath = SYSTEMPATH.'/blog_footer.php';    
            file_put_contents($footerfilepath, $footercode);     
            
            echo "<div class='alert alert-success'>Footer file updated successfully.</div>"; 
                       
        }
         
         
        // Get File CSS
        $headerfile = 'blog_header.php';    
        $headercode = file_get_contents($headerfile); 

        // Get File Modification Date
        $headerfilemodifitime =  filemtime($headerfile);
        $headerfilemodifitime_formated = date(" d/m/Y H:i:s ", $headerfilemodifitime);
         
        ?>
        <form action="" class="css_editor header_editor" method="post" enctype="multipart/form-data"> 
            <h2>Header.php</h2>
            <div class="last_modified"><b>Last Modified:</b>  <?php echo $headerfilemodifitime_formated; ?> <button type="submit" name="save_header" class="btn btn-success float-right">Save</button></div>
            <textarea id="headercode" name="headercode"><?php echo $headercode; ?></textarea>   
        </form>
        
        <?php    
          
        // Get File CSS
        $footerfile = 'blog_footer.php';
        $footercode = file_get_contents($footerfile); 

        // Get File Modification Date
        $footerfilemodifitime =  filemtime($footerfile);
        $footerfilemodifitime_formated = date(" d/m/Y H:i:s ", $footerfilemodifitime);
           
        ?>
        <form action="" class="css_editor footer_editor" method="post" enctype="multipart/form-data"> 
            <h2>Footer.php</h2>
            <div class="last_modified"><b>Last Modified:</b>  <?php echo $footerfilemodifitime_formated; ?> <button type="submit" name="save_footer" class="btn btn-success float-right">Save</button></div>
            <textarea id="footercode" name="footercode"><?php echo $footercode; ?></textarea>   
        </form>
    </div>
</div>    
    