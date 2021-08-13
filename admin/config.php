<?php

// Default Username and password
// superadmin 
 
// Not Required, But it can be use to forcefully overwrite the URL.
// If the domain transfer from one domain to another.  
define( 'SITEURL', 'http://localhost/projects/php_json_blog' );          
 
/*
 * Custom JSON Database
 */ 

global $connection;    
global $databasename;      

/*
 * Database Main File 
 */

$databasename = 'd32e39b18c1a1d07d511fe9cfc1c210a';     
$dbusername = 'sbdbuser'; 
$dbpassword = 'pgk*g[fS;Q+6]6n~';  
 

/*
 * Connect JSON DB file
 */

$connection = sb_jsondb_connect($databasename,$dbusername,$dbpassword,'admin');
if(!$connection) {
    die('Error in connect with database');   
}      
  
/*
 * Json DB Connect Function
 */
function sb_jsondb_connect($databasename,$dbusername,$dbpassword,$type='') { 
    
    $out = 0;
    
    // Check Request By User 
    if ($type=='admin') :
        $dbfilepath = dirname(__FILE__).'/database/admin/'.$databasename.'.json';
    else :
        $dbfilepath = dirname(__FILE__).'/database/'.$databasename.'.json';
    endif; 

    // Check if database exists    
    if (!file_exists($dbfilepath)) : 
        
        echo "Database not exists.";
        die(); 
        
    else :  
     
    $encstring = 'ICRkYmZpbGVqc29uID0gZmlsZV9nZXRfY29udGVudHMoJGRiZmlsZXBhdGgpOwogICAgICAgJGRiZmlsZWFycnkgPSBqc29uX2RlY29kZSgkZGJmaWxlanNvbik7CiAgICAgICAKICAgICAgICRqZGJ1c3JuYW1lID0gJGRiZmlsZWFycnlbJzAnXS0+ZGJ1c2VybmFtZTsgCiAgICAgICAkamRidXNycGFzcyA9ICRkYmZpbGVhcnJ5WycwJ10tPmRicGFzc3dvcmQ7IAogICAgICAgCiAgICAgICAKICAgICAgIGlmKCgkZGJ1c2VybmFtZSE9JycpICYmICgkamRidXNybmFtZSE9JycpICYmICgkZGJwYXNzd29yZCE9JycpICYmICgkamRidXNycGFzcyE9JycpICYmICgkZGF0YWJhc2VuYW1lIT0nJykpOgogICAgICAgICAgIAogICAgICAgICAgIGlmKChiYXNlNjRfZW5jb2RlKCRkYnVzZXJuYW1lKT09JGpkYnVzcm5hbWUpICYmIChiYXNlNjRfZW5jb2RlKCRkYnBhc3N3b3JkKT09JGpkYnVzcnBhc3MpKToKICAgICAgICAgICAgICAgICRvdXQgPSAxOwogICAgICAgICAgIGVuZGlmOwogICAgICAgICAgIAogICAgICAgZW5kaWY7';
     
    eval(base64_decode($encstring)); 
    
    endif;
    
    return $out;   
}   

/*
* First User Status
*/
function get_first_user_status() {      
         
    $out = 1;   

    $dbfilepath = SYSTEMPATH.'/database/admin/d32e39b18c1a1d07d511fe9cfc1c210a.json';
    $dbfilejson = file_get_contents($dbfilepath);
    $superadmin = json_decode($dbfilejson);
    
    if($superadmin) { 
        foreach($superadmin as $authordata) {     
            $out = $authordata->adminfirst; 
        }
    }        
                  
    return $out;        
}