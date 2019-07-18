<?php include_once('config.php'); ?>
<?php include_once('functions.php'); ?>   

<?php //Blog Informations 
$bloginfo = blog_info();
?>  
    
<!DOCTYPE html>

<html>
<head> 

    <!-- Required meta tags -->
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title><?php echo $bloginfo->blog_name; ?></title>

    <!--Fonts-->   
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- CSS Files -->
    <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet" />
    <link type="text/css" href="css/bootstrap-addon.css" rel="stylesheet" />
    <link type="text/css" href="css/fontawesome-all.min.css" rel="stylesheet" />
    <link type="text/css" href="css/style.css" rel="stylesheet" />
    <link type="text/css" href="css/responsive.css" rel="stylesheet" />

</head>  

<!-- Body Start -->
<body>
 

    <!--Signup Form Page Start-->
    <div class="signup_form_page">
        <div class="container">
            <div class="row"> 
                <div class="col-12">
                    <?php  

                    /*  
                     * User Signup  
                     */  
                    if(isset($_POST['register_submit'])) {  
      
                        // $loginstatus = $user->first_admin_signup($_POST);  
                        $loginstatus = $user->signup($_POST);  
                         
                        if($loginstatus>0) {
                            
                            $pageurl = site_url('/');  
                            echo "<div class='alert alert-success text-center'>You are successfully Registered. <a href='".$pageurl."'>Login here</a></div>" ;   
                            
                            //Redirect 
//                            header("Location:$pageurl");  
                        
                        } else {  
                            echo "<div class='alert alert-danger text-center'>User already exists with given email address.</div>" ;   
                        }
                    } else { 
                        $login = $user->check_login();
                        if($login) {
                            $dashboardurl = site_url('/admin.php'); 
                            header("Location:$dashboardurl");    
                    }  
                    }  
                    ?>      
                    
                    <!--Signup Form Start-->
                    <form action="" class="form-signin form-design" method="post" autocomplete="off"> 
                        <input type="hidden" value="author" name="role" />   
                        <div class="form_logo text-center"><img src="images/logo.png" alt="" class="img-fluid" /></div>
                        <h2 class="form-heading text-center">Set Up</h2>
                        <p class="text-center">Please enter credentials to access this system</p>
                        <p>
                            <label><b>Username</b> <span class="text-danger">*</span></label>
                            <input type="text" id="user_email" class="form-control" name="user_name" placeholder="Enter username." required="required" />
                        </p> 
                        <p>
                            <label><b>Email</b> <span class="text-danger">*</span></label>
                            <input type="email" id="user_email" class="form-control" name="user_email" placeholder="Enter your email id." required="required" />
                        </p>
                        <p class="position-relative">
                            <label><b>Password</b> <span class="text-danger">*</span></label>
                            <input type="password" maxlength="10" id="user_password" class="form-control" name="user_password" placeholder="Enter your password." required="required" />
                        </p>

                        <p class="text-center"><button name="register_submit" class="btn btn-primary d-block rounded-0 w-100" type="submit">Register</button></p>
                    </form> 
                    <!--Signup Form End-->
                    
                </div>
                <!-- col-12 End-->
            </div>
            <!--Row End-->
        </div>
        <!--Container End-->
    </div>   
    <!--Signup Form Page End-->

</body>
<!-- Body End -->

</html>