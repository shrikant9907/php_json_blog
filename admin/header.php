<?php include_once('config.php'); ?> 
<?php include_once('functions.php'); ?>   
 
<?php 

// Check User Access 
$useraccess = $user->check_access();  
if(!$useraccess) {    
    // Session Destroy
    session_destroy();    
    redirect_script(site_url(''));   
    die();   
}         

//Blog Informations 
$bloginfo = blog_info();     

?>      
     
<!DOCTYPE html>  
  
<html> 
  
    <head> 

            <!-- Required meta tags -->
            <meta charset="utf-8"> 
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta name="robots" content="noindex, nofollow" />    

            <title><?php echo $bloginfo->blog_name; ?></title>
  
            <link rel="shortcut icon" type="image/jpeg" href="images/favicon.png"/>
            
            <!--Fonts-->    
            <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

            <!-- CSS Files -->
            <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet" /> 
            <link type="text/css" href="css/fontawesome-all.min.css" rel="stylesheet" />
            <link type="text/css" href="css/jquery.dataTables.min.css" rel="stylesheet" /> 
  
            <!-- Light Box -->    
            <link rel="stylesheet" href="assets/lightbox/css/lightbox.min.css" />
            
            <link type="text/css" href="css/style.css" rel="stylesheet" />
            <link type="text/css" href="css/responsive.css" rel="stylesheet" />

    </head>    
	
	<!-- Body Start -->
	<body>
             
            <!-- Header Start -->
            <header class="header_section bg-primary position-relative">
                    <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <ul class="list-inline float-left">
                                <li class="list-inline-item text-white">
                                    <a class="menu-collapse mt-4" href="#"><i class="fas fa-bars"></i></a>
                                </li>
                                <li class="list-inline-item text-white">
                                    <span class="display-7 py-3 d-block">Hi, <?php echo $_SESSION['full_name']; ?></span>
                                </li>
                            </ul>    
                        </div>
                        
                        <div class="col-12 col-md-8 top-notificationicons">  
                            <ul class="list-inline float-right mb-0">  
                                <li class="list-inline-item">
                                <div  class="dropdown-toggle profile_toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="profile-thumb-small"><i class="fas fa-user"></i></span></div>
                                    <div class="dropdown-menu profile-icons"> 
                                    <?php if($_SESSION['user_id']!='0') {  ?>    
                                        <a class="dropdown-item position-relative" href="<?php echo admin_url('/admin.php?action=edit&type=profile'); ?>"><i class="far fa-user-circle"></i>Edit Profile</a>
                                    <?php } else {
                                        ?>
                                        <!--<a class="dropdown-item position-relative" href="<?php //echo admin_url('/admin.php?action=edit&type=superadmin'); ?>"><i class="far fa-user-circle"></i>Edit Profile</a>-->
                                        <?php 
                                    } ?> 
                                        <a class="dropdown-item position-relative" href="<?php echo admin_url('/logout.php'); ?>"><i class="fas fa-sign-out-alt"></i>Log Out</a> 
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>  
                    </div> 
            </header>
		
           
            <!-- Header End -->
            

 