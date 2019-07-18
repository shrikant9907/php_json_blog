<?php 
 
    $FILE = $_FILES['upload'];  
    $CKEditorFuncNum = 1;
      
// If File Uploaded 
    if($FILE['name']) {    
         
        // If Error Not Found 
        if(!$FILE['error']) {

            $file_temp_name  = $FILE['tmp_name']; 
            $file_name       = strtolower(basename($FILE['name']));  
            $file_size       = $FILE['size']; 
            $file_type       = $FILE['type'];   

            $extension = pathinfo($file_name, PATHINFO_EXTENSION);

            if(($extension=='jpg') || ($extension=='jpeg') || ($extension=='png')) {        

                // Destination/Target Path
                $current_dir = getcwd();
                $date = date("Y"); 
                
                $file_name = strtolower(str_replace(' ','_',$file_name));       
                
                $target_path = $current_dir.'/ckuploads/'.$file_name;  
  
                // Data and Time
                 $actual_name = pathinfo($file_name,PATHINFO_FILENAME);  
                 if(file_exists($target_path)) {
                     $current_date_time = '_'.time();    
                     $new_file_name = (string)$actual_name.$current_date_time;
                     $new_name = $new_file_name.".".$extension;       
                     $target_path = $current_dir.'/ckuploads/'.$new_name;      
                 }  

                if(!$new_name) {
                    $new_name = $file_name;   
                }      
                
                 // File Size Filter 1128902
                 if($file_size > (5000000)) {   
//                     echo '<div class="alert alert-danger" role="alert">Oops!  Your file\'s size is to large than 4 MB.</div>';
                 } else {
                     // Move Uploaded File to folder
                     move_uploaded_file($file_temp_name, $target_path);   
//                     echo 'File Uploaded';   
                         $url = $_GET['ai']."/ckuploads/".$FILE['name'];

                          @header('Content-type: text/html; charset=utf-8');
                        ?> 
<script> window.parent.CKEDITOR.tools.callFunction('<?php echo $CKEditorFuncNum; ?>', '<?php echo $url; ?>');   </script>
                        <?php 
                 }

            }  

        }  
 
    }  

                        
 
                    
 