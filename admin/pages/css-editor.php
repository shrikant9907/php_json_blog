<link rel="stylesheet" href="css/codemirror.css">
 

<div class="row">  
    <div class="col-12">
        <?php 
        
        // Save File
        if(isset($_POST['save_css'])) {   
              
            $save_css = $_POST['csscode']; 
            $cssfiledata = PUBLICHTMLPATH.'/style.css';  
            file_put_contents($cssfiledata, $save_css);      
            
            echo "<div class='alert alert-success'>Refresh page to check updates.</div>"; 
                       
        }
        
        // Get File CSS
        $css_file = PUBLICHTMLPATH.'/style.css';
        $css = file_get_contents($css_file);  

        // Get File Modification Date
        $cssfiletime =  filemtime($css_file);
        $cssfiletime_formated = date(" d/m/Y H:i:s ", $cssfiletime);
        
        ?>
        <form action="" class="css_editor" method="post" enctype="multipart/form-data"> 
            <h2>CSS Editor</h2>
            <div class="last_modified"><b>Last Modified:</b>  <?php echo $cssfiletime_formated; ?> <button type="submit" name="save_css" class="btn btn-success float-right">Save</button></div>
            <textarea id="code" name="csscode"><?php echo $css; ?></textarea>   
        </form>
    </div>
</div>    


    