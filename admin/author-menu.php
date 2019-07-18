
<?php 
    if(isset($_GET['type'])) {
        $mtype = $_GET['type'];
    } else {
        $mtype = '';
    }  
?>     
   
<li class="list-group-item <?php if($mtype=='blog') { echo 'active'; } ?>"><a href="admin.php?action=manage&type=blog"><i class="fab fa-blogger"></i>Blog</a></li>
<li class="list-group-item"><a href="<?php echo site_url('/admin/logout.php'); ?>"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
 