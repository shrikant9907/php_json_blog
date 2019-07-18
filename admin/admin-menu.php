
<?php 
    if(isset($_GET['type'])) {
        $mtype = $_GET['type'];
    } else {
        $mtype = '';
    } 
?>    
  
<li class="list-group-item <?php if($mtype=='blog') { echo 'active'; } ?>"><a href="admin.php?action=manage&type=blog"><i class="fab fa-blogger"></i>Blog</a></li>
<li class="list-group-item <?php if($mtype=='authors') { echo 'active'; } ?>"><a href="admin.php?action=manage&type=authors"><i class="fas fa-users"></i>Authors</a></li>
<li class="list-group-item <?php if($mtype=='style') { echo 'active'; } ?>"><a href="admin.php?action=manage&type=style"><i class="fas fa-paint-brush"></i>Style</a></li>
<li class="list-group-item <?php if($mtype=='layout') { echo 'active'; } ?>"><a href="admin.php?action=manage&type=layout"><i class="fas fa-columns"></i>Layout</a></li>
<li class="list-group-item <?php if($mtype=='settings') { echo 'active'; } ?>"><a href="admin.php?action=manage&type=settings"><i class="fas fa-cog"></i>Settings</a></li>
<li class="list-group-item"><a href="<?php echo site_url('/admin/logout.php'); ?>"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
