<?php //Blog Informations 
$bloginfo = blog_info();
?>

 <!-- Footer  -->
<section id="footer" class="footer_section">
    <div class="container"> 
        <div class="row">
            <div class="col-12 col-md-4 footer_widget">
                <div class="footer_info">
                    <div class="widget-footer">
                        <h3>About</h3>
                        <div class="widget-text">			
                            <div class="textwidget">
                                <p><a href="#">Test</a> is a fast growing online Real Estate firm that functions on the principals of trust, transparency and expertise. We have wide range of verified property listings across the Pune to meet the growing demand of home buyers.</p>
                            </div>
                        </div>
                    </div>	
                                    
                </div>
             </div>
               <div class="col-12 col-md-4 footer_widget">
                    <div class="footer_info">
                        <div class="widget-footer">
                            <h3>Useful Links</h3>
                            <div class="widget-text">
                                <div class="menu-footer-menus-container">
                                    <ul id="menu-footer-menus" class="menu">
                                        <li id="menu-item-39" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-14 current_page_item menu-item-39"><a href="#">Home</a></li>
                                        <li id="menu-item-40" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-40"><a href="#about-us/">About Us</a></li>
                                        <li id="menu-item-38" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-38"><a href="#contact-us/">Contact Us</a></li>
                                        <li id="menu-item-37" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-37"><a href="#buyers-guide/">Buyers Guide</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>	
                    </div>
                </div>
                <div class="col-12 col-md-4 footer_widget_section">
                <div class="footer_info">
                    <div class="widget-footer">
                        <h3>Contact Information</h3>
                        <div class="widget-text">			
                            <div class="textwidget">        
                                <ul class="contact_info_footer">
                                    <li>        
                                       <a href="mailto:sales@example.com"> <i class="fas fa-envelope"></i> sales@example.com</a>
                                    </li>                    
                                    <li>
                                        <a href="tel:45345454"><i class="fas fa-mobile-alt"></i>0303993993</a>  
                                    </li>
                                    <li>
                                     <i class="fas fa-map-marker-alt"></i> Address  - 411061   
                                    </li>
                               </ul>
                            </div>
                        </div>
                    </div>	
                </div>
            </div>
        </div>
     </div>               
</section>
<section id="footer2" class="footer_2">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-12 col-sm-12 text-left">
                <!-- social icon--> 
                <div class="social_links"> 
                    <a href="<?php echo $bloginfo->blog_fb_url; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="<?php echo $bloginfo->blog_insta_url; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="<?php echo $bloginfo->blog_twitter_url; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                </div>     
            </div>
            <div class="col-lg-4 col-md-4 col-12 col-sm-12 text-center">Copyright © 2018. All rights reserved.</div>
            <div class="col-lg-4 col-md-4 col-12 col-sm-12 text-right">Developed by: <a target="_blank" href="#">DeveloperName</a></div>
        </div>
    </div>
</section>    