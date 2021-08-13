<?php 

$uid = $_SESSION['user_id'];   
  
if(isset($_POST['update_user'])) {  
    
    $user->update($_POST);         
}

if(isset($_GET['uid']) && isset($_SESSION['user_role']) && ($_SESSION['user_role']=='administrator')) {
    $uid = $_GET['uid']; 
} 
  
?>
<div class="profile_page_design add_blog_design">  
<?php if($uid!='') {  
    $userinfo = $user->get_user_by_id($uid);
 ?> 
    <div class="row">   
     
    <div class="col-12">

    <form action="" class=" full-width-form mb-0" method="post" autocomplete="off" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?php echo $uid; ?>"  />
        <div class="row">
            <div class="col-md-3"> 
                <?php $author_img = $userinfo->author_img; ?> 
                <?php if($author_img!='$author_img') { ?>    
                    <img src="<?php echo admin_url('/uploads/'.$author_img); ?>" alt="" width="100" class="img-thumbnail img-circle img-fluid img-shadow profile_img" />
                <?php } ?>
            </div>    
            <div class="col-md-6">
                <label>Upload Profile Photo (.jpg, .jpeg and .png)  <span class="text-danger">*</span></label>
                <div class="form-group">
                    <input type="file" class="form-control" value="" name="profile_pic" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>First Name <span class="text-danger">*</span></label>
            </div>    
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo $userinfo->firstname; ?>" name="firstname" required="required" autofocus />
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Last Name <span class="text-danger">*</span></label>
            </div>    
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo $userinfo->lastname; ?>" name="lastname" required="required" />
                </div> 
            </div> 
        </div>
        <div class="row">     
            <div class="col-md-3">   
                    <label>Username<span class="text-danger">*</span></label>
            </div>    
            <div class="col-md-6"> 
                <div class="form-group">
                    <input type="email" readonly="readonly" class="form-control" value="<?php echo $userinfo->username; ?>" name="username" required="required"  />
                </div>  
            </div>    
        </div>
       <div class="row">    
            <div class="col-md-3">
                    <label>Email Address<span class="text-danger">*</span></label>
            </div>    
            <div class="col-md-6">
                <div class="form-group"> 
                    <input type="email" class="form-control" value="<?php echo $userinfo->email; ?>" name="email" required="required"  />
                </div>  
            </div>    
        </div>
        <div class="row">    
            <div class="col-md-3">
                    <label>User Role<span class="text-danger">*</span></label>
            </div>      
            <div class="col-md-6">  
                <div class="form-group">
                    <select class="custom-select" id="user_role" name="role">  
                        <option <?php echo selected('author', $userinfo->role); ?> value="author">Author</option>   
                        <option <?php echo selected('administrator', $userinfo->role); ?> value="administrator">Administrator</option> 
                    </select>  
                </div>    
            </div>  
        </div> 
        
        <div class="row">
            <div class="col-md-9"> 
                <button name="update_user" class="btn btn-success btn-inline-block rounded-0 float-right ml-2" type="submit">Update</button>
                <button name="delete_user" class="btn btn-danger btn-inline-block rounded-0 float-right" type="submit">Delete</button>
            </div> 
        </div>

    </form>
    </div>
</div>    
<hr />
<div class="row"> 
    <div class="col-12">
        <form action="" class="full-width-form" method="post" autocomplete="off">
            <div class="display-7 mb-3">Change Password</div>
            <?php if(isset($_POST['change_password'])) {      
                    $new_password = trim($_POST['user_new_password']);
                    $confirm_password = trim($_POST['user_cnew_password']); 
                    $user->admin_change_password($uid, $new_password, $confirm_password); 
            } ?>  
            <div class="row">     
                <div class="col-md-3">  
                    <label>New Password</label>
                </div>     
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="password" maxlength="8" class="form-control" value="" name="user_new_password" required="required" />
                    </div>  
                </div>  
            </div>
            <div class="row">    
                <div class="col-md-3">
                    <label>Confirm Password</label> 
                </div>    
                <div class="col-md-6"> 
                    <div class="form-group">
                        <input type="password" maxlength="8" class="form-control" value="" name="user_cnew_password" required="required" />
                    </div>  
                </div>  
            </div>   
            <div class="row">
                <div class="col-md-9">
                    <button name="change_password" class="btn btn-success btn-inline-block rounded-0 float-right " type="submit">Change Password</button>
                </div>
            </div>
        </form>
    </div>
    
</div> 
<?php } ?>    
</div>

