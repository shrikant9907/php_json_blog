<?php

// Username and Password : superadmin
 
//Remove Error Reporting

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
error_reporting(E_ERROR | E_PARSE);

/*  
 * Session Start;
 */    
session_start();     
 
//Current Working Directory
$current_dir = getcwd(); 
define('SYSTEMMODE', 'TEST');
define('SYSTEMPATH', dirname(__FILE__));
define('HPDIRPATH', $current_dir);
define('UPLOADDIRPATH', $current_dir.'/uploads/');

define( 'ABSPATH', dirname(dirname(__FILE__)));
 
/*
 * Public Directory
 */
define('PUBLICHTMLPATH', ABSPATH.'');     

include 'include/class.users.php';   
include 'include/class.settings.php'; 
include 'include/class.blogs.php';  

 
/*
 * Site URL - Dyamic
 */
function _site_url(){ 
  
  if(SITEURL=='') {    
      return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        ''
      );
    } else {
        return SITEURL; 
    }
}

/*  
 * Return Site URL.
 */
function site_url($next='') {  
  
    $settings = new Settings();  
    $allsettings = $settings->get();
    $new_site_url = $allsettings->site_url;
    if($new_site_url=='') {
        $url = _site_url().$next;    
    } else {   
        $url = $new_site_url.$next;  
    }
    return $url;
   
}   

/*    
 * Admin URL
 */
function admin_url($next='') {     
  
    $admin_url = site_url('/admin').$next;
    return $admin_url;
   
}   

/*     
 * Upload URL
 */
function upload_url($location='') {     
  
    $upload_url = site_url('/admin/uploads/'.$location); 
    return $upload_url;
   
}   

/*
 * Time Zone
 */
$blogsettings = $settings->get();
$timezone = $blogsettings->time_zone;
date_default_timezone_set($timezone);    

/*
 * Search Engine Visibility 
 */
$sengvis = $blogsettings->search_engine_visibility;
$robottxtfile = 'robots.txt';
if($sengvis==0) {  
    
    $filelocation = HPDIRPATH.'/'.$robottxtfile;  
    $rbtext = '
User-agent: *
Disallow: /
        '; 
    $rbttext = fopen($filelocation, "w"); 
    fwrite($rbttext, $rbtext); 
    fclose($rbttext);  
    
} else { 
    // Delete Robots.txt file  
    if(file_exists($robottxtfile)) {
        unlink($robottxtfile); 
    } 
}

/*  
 * Return Blog URL
 */
function blog_url($next='') {                 
   
    $settings = new Settings();  
    $allsettings = $settings->get();
    $new_blog_url = $allsettings->blog_url;
    if($new_blog_url=='') { 
        $url = _site_url().'/'.$next;    
    } else {  
       $url = $new_blog_url.$next;
    } 
    return $url;    
}       
 
/*  
 * Return Admin Email
 */
function admin_email() {                 
   
    $settings = new Settings();  
    $allsettings = $settings->get();
    $admin_email = $allsettings->admin_email;
     
    return $admin_email;    
}        
 
/*  
 * Return Blog Info
 */
function blog_info() {                       
   
    $settings = new Settings();  
    $allsettings = $settings->get();
     
    return $allsettings;    
}        
 
/*
 * Get Date Format
 */
function get_date_format($admitted) {  
    
    if($admitted!='') {
    
        if(preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/", $admitted) === 0) {
            $admitted = date('d F Y',strtotime($admitted));  
        } else {
            list($d, $m, $y) = explode('/', $admitted);
            $admitted = mktime(0, 0, 0, $m, $d, $y);  
            $admitted = date('d F Y',$admitted);   
        } 
     
    } 
         
    return $admitted; 
}



/*
 * Get Date Format
 */
function get_formatted_datetime($admitted) {  
    
    if($admitted!='') {
    
        if(preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/", $admitted) === 0) {
            $admitted = date('d M Y, h:i A',strtotime($admitted));  
        } else {
            list($d, $m, $y) = explode('/', $admitted);
            $admitted = mktime(0, 0, 0, $m, $d, $y);  
            $admitted = date('d M Y, h:i A',$admitted);   
        } 
     
    } 
         
    return $admitted; 
}  


/*
 * Get Attachment URL
 */
function get_attachment_url($resumeid) {
    
    global $connection; 
    $url = ''; 
   
    $sql = "SELECT * FROM uploads WHERE id='$resumeid'"; 
    $result = mysqli_query($connection, $sql); 
    if($result) {
        $num_rows = mysqli_num_rows($result);
        if($num_rows>0) {
           $row = mysqli_fetch_assoc($result);
           $file = $row['upload_location']; 
        }
    }     
    
    return $file; 
}

/*
 * Get Attachment URL
 */
function get_attachment_data($resumeid) {
    
    global $connection; 
    $url = ''; 
   
    $sql = "SELECT * FROM uploads WHERE id='$resumeid'"; 
    $result = mysqli_query($connection, $sql); 
    if($result) {
        $num_rows = mysqli_num_rows($result);
        if($num_rows>0) {
           $row = mysqli_fetch_assoc($result);
        }
    }      
    
    return $row; 
}

/*
 * Upload File
 */
function upload_file($FILE, $newfilename = '') {     
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

            if(($extension=='jpg') || ($extension=='jpeg') || ($extension=='png')) {        

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
                     $filedata = sk_insert_upload_data($file_name,$new_name,$file_size,$file_type,$extension,$target_path);  
                     $output = $filedata;   
                     $output['message'] = 'File Uploaded';
                 }

            } else {  
                $output['message'] = '<div class="alert alert-danger" role="alert">Invalid file format.</div>'; 
            }

        } else { 
             $output['message'] = '<div class="alert alert-danger" role="alert">Unable to upload file. Please try again.</div>';
        }  
 
    } 
    
    return $output; 
    
}

/*
 * Save Uploaded File Data
 */
function  sk_insert_upload_data($file_name,$new_name,$file_size,$file_type,$extension,$file_full_path) {
    
    global $connection; 
    $output = array();  
    $output['status'] = 0; 
    $output['last_insert_id'] = '';     
    $date = date("Y");
    $upload_location = $date.'/'.$new_name; 

    $output['status'] = 1; 
    $output['file_name'] = $new_name; 
    $output['file_upload_loc'] = $upload_location;  
    $output['last_insert_id'] = $last_id;   
             
    return $output;
}


/*
 * Function Selected Option
 */
function selected($v1, $v2){  
    if($v1==$v2){
        return 'selected="selected"';
    }  
}  

/*
 * Function Checked Option
 */
function in_array_checked($v1, $v2){ 
    
    if(in_array($v1,$v2)){
        return 'checked="checked"';
    }  
}

/*
 * Function Checked Option
 */
function checked($v1, $v2){ 
    
    if($v1==$v2){
        return 'checked="checked"';
    }  
}
 
/*
 * Send mail with attachment
 */
function send_mail($to, $from, $fromName, $subject ,$htmlContent, $file = '', $bcc = '') {
    
        $status = 0; 
        if(($to!='') && ($from!='') && ($fromName!='') && ($subject!='') && ($htmlContent!='')) { 
    
            //header for sender info
//           $headers = "From: $fromName"." <".$from.">";
            $headers  = "From: $fromName <$from> \r\n";
             
            if($bcc!=''){
                $headers .= "Bcc: $bcc ";  
            }  
  
            //boundary 
            $semi_rand = md5(time()); 
            $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 

            //headers for attachment 
            $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 

            //multipart boundary 
            $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
            "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 

            //preparing attachment
            if(!empty($file) > 0){
                if(is_file($file)){
                    $message .= "--{$mime_boundary}\n";
                    $fp =    @fopen($file,"rb");
                    $data =  @fread($fp,filesize($file));

                    @fclose($fp);
                    $data = chunk_split(base64_encode($data));
                    $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
                    "Content-Description: ".basename($files[$i])."\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
                    "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                }
            }
            
            $message .= "--{$mime_boundary}--";
            $returnpath = "-f" . $from;
            
            //send email
            $mail = @mail($to, $subject, $message, $headers, $returnpath); 
            if($mail) {
                $status = 1;
            }
//            //email sending status
//            echo $mail?"<div class='alert alert-success'>Mail sent.</div>":"<div class='alert alert-danger'>Mail sending failed.</div>";
//        
        } 
        
        return $status; 
}

/*
 * Console Log
 */

function console_log($data) {
    ?>
        <script>
            
            console.log('<?php echo $data ?>'); 
            
        </script>
    <?php
}

/*
 * Console Log
 */
  
function redirect_script($url) {
    ?>
       <script>
            window.location.href="<?php echo $url; ?>";
        </script>
    <?php
}

/*
 * Console Log
 */
  
function redirect_withdelay_script($url) {
    ?>
        <script>
            var delay = 3000;   
            setTimeout(function(){ window.location.href="<?php echo $url; ?>"; }, delay);
        </script>
    <?php
}


function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


/*
 * Get Directory Size
 */
function get_directory_size($path){  
    $bytestotal = 0;
    $path = realpath($path);
    if($path!==false && $path!='' && file_exists($path)){
        foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
            $bytestotal += $object->getSize();
        }
    }
    return $bytestotal;
}


/*
 * Get Directory Size Units
 */
function get_size_units($bytes) {
    
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }

    return $bytes;
}


/*
 * String to slug
 */   
function string_to_slug($str){

    $str = strip_tags($str); 
    $slug = strtolower(str_replace(' ', '-', trim($str))); 
     
    return $slug;

} 

/*
 * Trim Words 
 */
function trim_words($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = strip_tags(substr($text, 0, $pos[$limit]) . '...');
      }
      return $text;
}

/*
* Social Share
*/
function social_share_links($title = '', $content = '', $image = '', $url = '') {  
    ob_start();
    ?>
    <div class="social_share_option">
        <a  target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>"><i class="fab fa-facebook-f"></i> Share on Facebook</a>
        <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>&title=<?php echo $title; ?>&summary=<?php echo $content; ?>&source=<?php echo site_url(); ?>"><i class="fab fa-linkedin-in"></i>Share on LinkedIn</a> 
        <!-- <a href="https://twitter.com/home?status=twitter">Share on Twitter</a> -->
        <a target="_blank" href="https://plus.google.com/share?url=<?php echo $url; ?>"><i class="fab fa-google-plus-g"></i>Share on Google+</a>
    </div>
    <?php
    return ob_get_clean();
}

/* 
* Breadcrumb   
*/
function php_breadcrumb($title = '') {   
    ob_start();
    ?> 
    <div class="breadcrumb">
        <div class="container">
            Blog / <?php echo $title; ?>
        </div>
    </div>
    <?php    
    return ob_get_clean();
} 