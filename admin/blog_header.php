<!DOCTYPE html>

<html>  

    <head>   

            <!-- Required meta tags -->
            <meta charset="utf-8"> 
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

            <title>Blog | <?php echo $blog_title; ?></title>

            <?php if($bloginfo->search_engine_visibility==0) { ?> 
                <meta name="robots" content="noindex" />    
            <?php } ?> 

            <meta name="title" content="<?php echo $meta_title; ?>">    
            <meta name="description" content="<?php echo $meta_desc; ?>">
            <meta name="author" content="<?php echo $meta_author; ?>">   

            <link rel="shortcut icon" type="image/jpeg" href="<?php echo site_url('/images/logo.png'); ?>"/>
 
            <!--Fonts-->   
            <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

            <!-- CSS Files -->
            <link type="text/css" href="<?php echo admin_url('/css/bootstrap.min.css'); ?>" rel="stylesheet" /> 
            <link type="text/css" href="<?php echo admin_url('/css/fontawesome-all.min.css'); ?>" rel="stylesheet" />
            <link type="text/css" href="<?php echo site_url('/style.css'); ?>" rel="stylesheet" />
     
    </head>   
 
        <!-- Body Start --> 
        <body> 

        <!-- Header Style1 Start --> 
        <header class="header_design1 style1"> 
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-2"> 
                        <div class="logo_wr"> 
                            <a href="<?php echo site_url('/'); ?>"><img class="img-fluid" src="<?php echo site_url('/images/logo.png'); ?>" alt="Website Logo" /></a>
                        </div>
                    </div>
                    <div class="col-12 col-md-10">
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                              <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto"> 
                                    <li class="nav-item active">
                                        <a class="nav-link" href="<?php echo site_url('/'); ?>">Blog</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="<?php echo site_url('/#contact'); ?>">Contact</a>
                                    </li>
                                </ul>
                            </div> 
                        </nav> 
                    </div>
                </div>
            </div> 
        </header>
        <!-- Header Style1 End --> 