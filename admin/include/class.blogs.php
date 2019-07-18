<?php
/**
 * Blogs 
 *
 * @author Shrikant Yadav
 */
class Blogs {    
 
    /*
     * Function Add User  
     */
    public function add_blog() { 
           
        $blog_title         = trim($_POST['blog_title']); 
        $blog_sub_title     = trim($_POST['blog_sub_title']); 
        $custom_url_switch  = trim($_POST['custom_url_switch']); 
        $custom_blog_url    = string_to_slug(trim($_POST['custom_blog_url']));        
        $blog_content       = trim($_POST['blog_content']);  
        $blog_meta_title    = trim($_POST['blog_meta_title']); 
        $blog_meta_desc     = trim($_POST['blog_meta_desc']);   
        $blog_author        = trim($_POST['blog_author']);  
        $blog_post_status   = trim($_POST['blog_post_status']);    
        $uploaded_file   = $_FILES['blog_featured_image']; 
        $featured_image_url = '';

        // File Upload 
        $filedata = $this->upload($uploaded_file); 
        if($filedata['status']==1) {
            $featured_image_url = $filedata['location'];
        }  

        // Check if all required value given
        if(($blog_title!='') && ($blog_content!='') && ($blog_post_status!='') ) { 
            
            if(!$custom_url_switch) {           
                $custom_blog_url = string_to_slug($blog_title).'.html';        
            }      
            
            // Time With File Name 
            $filelocation = PUBLICHTMLPATH.'/'.$custom_blog_url;     
              
            // Check if file exists
            if(file_exists($filelocation)) { 
                $actual_name = pathinfo($filelocation, PATHINFO_FILENAME);     
                $custom_blog_url = (string)$actual_name.'-'.time().".html";     
            } 
            
            $extension = pathinfo($custom_blog_url, PATHINFO_EXTENSION);
                if($extension=='') {
                $extension = 'html';
                $custom_blog_url = $custom_blog_url.'.'.$extension;   
            }    
 
            if($blog_post_status=='Published') { 
           
                // Create File  
                $fstatus = $this->create_html_file($custom_blog_url, $blog_meta_title, $blog_meta_desc, $blog_author ,$blog_title, $blog_content, $blog_sub_title, $blog_featured_image, $custom_blog_url);    
 
            } else {  
                $fstatus = 1;  
            }
            if($fstatus==1) {   
        
            if(SYSTEMMODE=='TEST') :     
                console_log('Add new blog.');
            endif;

                $dbfilepath = SYSTEMPATH.'/database/blogs.json'; 
                $dbfilejson = file_get_contents($dbfilepath); 
                $dbfileobj = json_decode($dbfilejson);      
                
//              First Object To Array
                if($dbfileobj) {
                    foreach($dbfileobj as $dbfobj_key => $dbobj) {
                        $dbfilearry[$dbfobj_key] = $dbobj;
                    }
                }   
                
                $inildatacount = count($dbfilearry);
                ksort($dbfilearry);    // Fix reverse Storage
                $lastdata = end($dbfilearry);              
                $lastdataid = $lastdata->id;   

                // Today Date and Time      
                $today = date("F j, Y, g:i a");  

                $newblog->id                =  $lastdataid+1;         
                $newblog->blog_title        =  $blog_title; 
                $newblog->blog_sub_title    =  $blog_sub_title; 
                $newblog->custom_url_switch =  $custom_url_switch;
                $newblog->custom_blog_url   =  $custom_blog_url;
                $newblog->blog_content      =  $blog_content;
                $newblog->blog_meta_title   =  $blog_meta_title;
                $newblog->blog_meta_desc    =  $blog_meta_desc;
                $newblog->blog_author       =  $blog_author; 
                $newblog->blog_post_status  =  $blog_post_status;
                $newblog->blog_featured_image  =  $featured_image_url; 
                $newblog->blog_registered   =  $today;  
  
                $dbfilearry[] = $newblog;      
 
                $finaldatacount = count($dbfilearry);

                if($finaldatacount>$inildatacount) {
                
                    $dbfilearryjson = json_encode($dbfilearry); 
                    
                        // Save in Database     
                        file_put_contents($dbfilepath, $dbfilearryjson);  

                        if(SYSTEMMODE=='TEST') :    
                            console_log('New blog inserted.');
                        endif;

                        return 1;

                } else {   

                    if(SYSTEMMODE=='TEST') :     
                        console_log('New blog not inserted.');
                    endif; 

                    return 0;

                }   
                
            } if($fstatus==3) {    
                if(SYSTEMMODE=='TEST') :     
                        console_log('New blog not inserted 3');
                    endif; 
                return $fstatus;
            } else { 
                if(SYSTEMMODE=='TEST') :     
                        console_log('New blog not inserted. 4');
                    endif; 
                return 0; 
            }

        } else {
            return 4;
        }

    } 
    
    /*
    * Function For Retrive All Blogs
    */
    public function get_blogs() {

        $dbfilepath = SYSTEMPATH.'/database/blogs.json';
        $dbfilejson = file_get_contents($dbfilepath);
        $dbfilearry = json_decode($dbfilejson);
        
        // Reverse Sort 
        if($dbfilearry) {
            krsort($dbfilearry);
        }
        
        return $dbfilearry;       
    } 

    /*
    * Get Blog By ID 
    */
    public function get_blog_by_id($blog_id){  

        $blog = array(); 
        
        $blogs = $this->get_blogs();
        if($blogs) {
            foreach($blogs as $blogdata) {    
                if($blog_id == $blogdata->id) {
                    $blog = $blogdata;
                    break;
                }  
            }
        }     
        
        return $blog; 

    }  

    /*
    * Get Blog By Author ID 
    */ 
    public function get_blog_by_author_id($blog_id){ 

        $blog = array(); 
        
        $blogs = $this->get_blogs();
        if($blogs) {
            foreach($blogs as $blogdata) {    
                if($blog_id == $blogdata->id) {
                    $blog = $blogdata;
                    break;
                }  
            }
        }    
         
        return $blog;        

    } 
    
    /*
     * Delete Blog 
     */ 
    public function delete($blog_id) {
        
        $newblog = array(); 
        $blogs = $this->get_blogs();

        if($blogs) {
             
            // Delete User
            foreach($blogs as $blogkey => $blogdata) {    
                if($blog_id != $blogdata->id) {
                    $newblog[$blogkey] = $blogdata;  
                } else {
                    
                    // Delete HTML File    
                    $custom_blog_url = $blogdata->custom_blog_url;
                    $filelocation = PUBLICHTMLPATH.'/'.$custom_blog_url;     
                    unlink($filelocation);
            
                }  
            }  
        
            $dbfilepath = SYSTEMPATH.'/database/blogs.json'; 
            $dbfilearryjson = json_encode($newblog);    
            file_put_contents($dbfilepath, $dbfilearryjson);  
        
            return 1;   
            
        } else {
            return 0;   
        }    
    }       
      
    /*
     * Delete Blog From List
     */ 
    public function delete_from_list($blog_array) {
        
        $newblog = array(); 
        $blogs = $this->get_blogs();

        if($blogs) {
                   
            // Delete Blog From List 
            foreach($blogs as $blogkey => $blogdata) {    
                if(!in_array($blogdata->id, $blog_array)) {
                    $newblog[$blogkey] = $blogdata;  
                } else {
                
                    // Delete HTML File    
                    $custom_blog_url = $blogdata->custom_blog_url;
                    $filelocation = PUBLICHTMLPATH.'/'.$custom_blog_url;     
                    unlink($filelocation);
             
                } 
            }       
        
            $dbfilepath = SYSTEMPATH.'/database/blogs.json'; 
            $dbfilearryjson = json_encode($newblog);    
            file_put_contents($dbfilepath, $dbfilearryjson);  
        
            return 1;   
            
        } else {
            return 0;   
        }    
    }        
    
     
    /*
     * Delete All Blogs 
     */
    public function delete_all() {     
        
        $newauthors = '[{}]';     
        $dbfilepath = SYSTEMPATH.'/database/blogs.json'; 
        file_put_contents($dbfilepath, $newauthors);  
        
        return 1; 

    }
    

    /*
     * Update Blog  
     */
    public function update() {  
    
        $result = 0;
 
        $blog_id            = $_POST['blog_id'];          
        
        $blog_title         = trim($_POST['blog_title']);  
        $blog_sub_title     = trim($_POST['blog_sub_title']);  
        $custom_url_switch  = trim($_POST['custom_url_switch']); 
        $custom_blog_url    = string_to_slug(trim($_POST['custom_blog_url']));        
        $blog_content       = trim($_POST['blog_content']);  
        $blog_meta_title    = trim($_POST['blog_meta_title']); 
        $blog_meta_desc     = trim($_POST['blog_meta_desc']);   
        $blog_author        = trim($_POST['blog_author']);  
        $blog_post_status   = trim($_POST['blog_post_status']);    
        $uploaded_file   = $_FILES['blog_featured_image']; 
        $featured_image_url = '';

        // File Upload
        $filedata = $this->upload($uploaded_file); 
        if($filedata['status']==1) {
            $featured_image_url = $filedata['location'];
        }     
         
        $blogs = $this->get_blogs();
          
        if($blogs) {
            foreach($blogs as $blogdata) {     
                if($blog_id == $blogdata->id) {  
                    
                    if(!$custom_url_switch) {           
                        $custom_blog_url = string_to_slug($blog_title).'.html';        
                    }      

                    $blogdata->blog_title        =  $blog_title;       
                    $blogdata->blog_sub_title    =  $blog_sub_title; 
                    $blogdata->custom_url_switch =  $custom_url_switch;
                
                    $extension = pathinfo($custom_blog_url, PATHINFO_EXTENSION);
                    if($extension=='') {
                        $extension = 'html';
                        $custom_blog_url = $custom_blog_url.'.'.$extension;   
                    }    
                
                    if(($custom_blog_url!='') && ($custom_blog_url!=$blogdata->custom_blog_url)) {    
                        $blogdata->custom_blog_url   =  $custom_blog_url;
                    } 
                     
                    if($blog_post_status=='Published') {   
                        // Update File  
                        if($featured_image_url=='') {
                            $featured_image_url = $blogdata->blog_featured_image;
                        }
                        $this->create_html_file($custom_blog_url, $blog_meta_title, $blog_meta_desc, $blog_author ,$blog_title, $blog_content , $blog_sub_title, $featured_image_url, $custom_blog_url);    
                    } 

//                    Delete File          
                    if($blog_post_status=='Draft') {
                        $filelocation = PUBLICHTMLPATH.'/'.$custom_blog_url;      
                        unlink($filelocation);
                    } 
                    
                    
                    $blogdata->blog_content      =  $blog_content;
                    $blogdata->blog_meta_title   =  $blog_meta_title;
                    $blogdata->blog_meta_desc    =  $blog_meta_desc;
                    $blogdata->blog_author       =  $blog_author;
                    $blogdata->blog_post_status  =  $blog_post_status;   
                    if($featured_image_url!='') {
                        $blogdata->blog_featured_image  =  $featured_image_url;  
                    }
                     
                }  
            } 
    
            $dbfilepath = SYSTEMPATH.'/database/blogs.json'; 
              
             $blogsjson = json_encode($blogs);  
        
            file_put_contents($dbfilepath, $blogsjson);      

            if(SYSTEMMODE=='TEST') :     
                console_log('Blog updated.');
            endif;
            
            $result = 1;
            
        } else { 
            if(SYSTEMMODE=='TEST') :     
                console_log('New blog not updated.');
            endif;  
        }
        
        return $result; 

    }
 
    /*
     * Update Blogs Status  
     */
    public function update_status($blogslist, $newstatus) {  
    
        $result = 0;
       
        $blogs = $this->get_blogs(); 
          
        if($blogs) {
            foreach($blogs as $blogdata) { 
                if(in_array($blogdata->id, $blogslist)) { 
                    $blogdata->blog_post_status  =  $newstatus; 
                } else {
                    // echo "no";
                }   
            }    
                    
            $dbfilepath = SYSTEMPATH.'/database/blogs.json'; 
            $blogsjson = json_encode($blogs);  
            file_put_contents($dbfilepath, $blogsjson);         

            if(SYSTEMMODE=='TEST') :     
                console_log('Blog updated.');
            endif;
            
            $result = 1;
            
        } else { 
            if(SYSTEMMODE=='TEST') :     
                console_log('New blog not updated.');
            endif;  
        }
        
        return $result; 

    }
    
    /*
    * Function For Retrive All Editing blogs
    */
    public function get_temp_edit() {   

        $dbfilepath = SYSTEMPATH.'/database/temp_edit.json';
        $dbfilejson = file_get_contents($dbfilepath);
        $dbfilearry = json_decode($dbfilejson);
          
        return $dbfilearry;       
    }  
    
    /*
     * Update Blogs Status  
     */
    public function blog_takeover($blog_id, $author_name) {  
    
        $result = 0;
       
        $blogs = $this->get_temp_edit(); 
          
        if($blogs) {
            
            foreach($blogs as $blogdata) { 
                if($blogdata->blog_id==$blog_id) { 
                    $blogdata->author_name  =  $author_name; 
                }
            }    
                     
            $dbfilepath = SYSTEMPATH.'/database/temp_edit.json'; 
            $blogsjson = json_encode($blogs);   
            file_put_contents($dbfilepath, $blogsjson);         
 
            if(SYSTEMMODE=='TEST') :     
                console_log('Takeover applied.');
            endif;
            
            $result = 1;
                 
        }        
        
        return $result; 

    }
    
    /*
     * Insert Edit Blog   
     */
    public function insert_temp_edit($blog_id, $author_name) {  
     
        $result = 0;
       
        $dbfilepath = SYSTEMPATH.'/database/temp_edit.json'; 
        $dbfilejson = file_get_contents($dbfilepath); 
        $dbfileobj = json_decode($dbfilejson);      
                
        // First Object To Array
        if($dbfileobj) {
            foreach($dbfileobj as $dbfobj_key => $dbobj) {
                $dbfilearry[$dbfobj_key] = $dbobj;
            }
        }   
                
        $inildatacount = count($dbfilearry);

        $lastdata = end($dbfilearry);
        $lastdataid = $lastdata->id;   

        $newblog->id                =  $lastdataid+1;         
        $newblog->blog_id           =  $blog_id; 
        $newblog->author_name       =  $author_name;
            
        $dbfilearry[] = $newblog;      
 
        $finaldatacount = count($dbfilearry);

        if($finaldatacount>$inildatacount) { 

            $dbfilearryjson = json_encode($dbfilearry); 

            // Save in Database    
            file_put_contents($dbfilepath, $dbfilearryjson);  

            $result = 1;   
 
        }  
        
        return $result;

    }
    
    /*
     * Create a new HTML File
     */
    
    function create_html_file($file_name, $meta_title = '', $meta_desc = '', $meta_author = '', $blog_title = '', $generatedhtml = '', $blog_sub_title = '', $blog_featured_image = '', $custom_blog_url = '') {     

        $user = new Users();  
        $authormeta = $user->get_user_by_id($meta_author);
        
        $meta_author = $authormeta->firstname.' '.$authormeta->lastname;  
        
        if($file_name!='') {  
             
            $extension = pathinfo($file_name, PATHINFO_EXTENSION);
            if($extension=='') {
                $extension = 'html';
                $file_name.'.'.$extension;   
            }
             
            if(($extension=='html') || ($extension=='htm')) {   
                
                $filelocation = PUBLICHTMLPATH.'/'.$file_name;  
                
                $htmlfile = fopen($filelocation, "w");     

ob_start();   
include('blog_header.php');  

$bloginfo = blog_info();
if($bloginfo->blog_breadcrumb=='Yes') { 
    echo $php_breadcrumb = php_breadcrumb($blog_title);
}

$blog_header = ob_get_clean();

ob_start();
include('blog_footer.php');  
echo '</body></html>';
$blog_footer = ob_get_clean();         
$image = upload_url($blog_featured_image);
$content = strip_tags($generatedhtml); 
$url = site_url('/'.$custom_blog_url);   
$social_share_links = social_share_links($blog_title, $content, $image, $url); 
$htmlcontent = '   
<div class="container"> 
    <div class="row">
        <div class="col-12">   
            <div class="custom_blog_html">
            <h2 class="main_heading">'.$blog_title.'</h2>   
            '.$social_share_links.'
            <h3 class="sub_heading">'.$blog_sub_title.'</h3> ';  
            if($blog_featured_image!='') { 
                $htmlcontent .= '<img class="img-thumbnail img-responsive m-0 mb-2" src="'.upload_url($blog_featured_image).'" alt="" />';
            } 
            $htmlcontent .= $generatedhtml.'</div>

        </div>
    </div>
</div>
';   
                 
                fwrite($htmlfile, $blog_header.$htmlcontent.$blog_footer);         
                fclose($htmlfile);   
                
                return 1;  
              
            } else {
                  
                return 3;
            }
        } else {
            return 2;
        }
    }
    
 
    
    /*
     * Regenerate Blog Templates  
     */
    public function regen_templates() {  
    
        $result = 0;
        
        $blogs = $this->get_blogs();
          
        if($blogs) {
            foreach($blogs as $blogdata) {     
                    
                $blog_title         = $blogdata->blog_title; 
                $blog_sub_title     = $blogdata->blog_sub_title; 
                $custom_blog_url    = $blogdata->custom_blog_url; 
                $blog_content       = $blogdata->blog_content;
                $blog_meta_title    = $blogdata->blog_meta_title;
                $blog_meta_desc     = $blogdata->blog_meta_desc;
                $blog_author        = $blogdata->blog_author;   
                $blog_post_status   = $blogdata->blog_post_status;  
                $blog_featured_image   = $blogdata->blog_featured_image;
                
                // Delete File
//                $filelocation = PUBLICHTMLPATH.'/'.$custom_blog_url;      
//                unlink($filelocation);
                if($blog_post_status=='Published') { 
           
                // Create HTML Template
                $this->create_html_file($custom_blog_url, $blog_meta_title, $blog_meta_desc, $blog_author ,$blog_title, $blog_content, $blog_sub_title, $blog_featured_image, $custom_blog_url);   
                }
//                sleep(2);    
            }  
      
            if(SYSTEMMODE=='TEST') :     
                console_log('Templates Regenerated');
            endif;  
      
            $result = 1;
            
        } else { 
            if(SYSTEMMODE=='TEST') :     
                console_log('Templates not updated');
            endif;  
            
            $result = 0;
        }
        
        return $result; 

    }


    /*
     * Upload File
     */
    public function upload($FILE, $newfilename = '') {     
        $output = array();
        $newfilename = trim($newfilename);  
          
    // If File Uploaded 
        if($FILE['name']) {
             
            // If Error Not Found 
            if(!$FILE['error']) {

                $file_temp_name  = $FILE['tmp_name']; 
                $file_name       = strtolower(basename($FILE['name']));  
                $file_size       = $FILE['size']; 
                $file_type       = $FILE['type'];   

                $extension = pathinfo($file_name, PATHINFO_EXTENSION);

                if(($extension=='png') || ($extension=='jpg') || ($extension=='jpeg') || ($extension=='gif')) {      
                    // Destination/Target Path
                    $current_dir = getcwd();
                    $date = date("Y"); 
                    
                    if($newfilename!='') {
                        $file_name = $newfilename.".".$extension; 
                    }
                     
                    $file_name = strtolower(str_replace(' ','_',$file_name));      
                    
                    $target_path = $current_dir.'/uploads/'.$date.'/'.$file_name;  
      
                    // Data and Time
                     $actual_name = pathinfo($file_name,PATHINFO_FILENAME);  
                     if(file_exists($target_path)) {
                         $current_date_time = '_'.time();    
                         $new_file_name = (string)$actual_name.$current_date_time;
                         $new_name = $new_file_name.".".$extension;       
                         $target_path = $current_dir.'/uploads/'.$date.'/'.$new_name;      
                     }  

                    if(!$new_name) {
                        $new_name = $file_name;   
                    }      
                    
                     // File Size Filter 
                     if($file_size > (4096000)) {   
                         $output['message'] = '<div class="alert alert-danger" role="alert">Oops!  Your file\'s size is to large than 4 MB.</div>';
                     } else { 
                         // Move Uploaded File to folder
                         move_uploaded_file($file_temp_name, $target_path);   
                         
                         $upload_location = $date.'/'.$new_name;   
                         $output['location'] = $upload_location;     
                         $output['status'] = 1; 
                         $output['message'] = 'File Uploaded';
                     }

                } else {  
                    $output['status'] = 0;
                    $output['message'] = '<div class="alert alert-danger" role="alert">Invalid file format.</div>'; 
                }

            } else { 
                $output['status'] = 0;
                 $output['message'] = '<div class="alert alert-danger" role="alert">Unable to upload file. Please try again.</div>';
            }  
     
        } 
        
        return $output; 
        
    }
        
} 
 
$blog = new Blogs();  
