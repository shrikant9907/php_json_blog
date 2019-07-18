<?php 
 
if(isset($_POST['add_user'])) { 
    
    $status = $user->add_user($_POST);  
    
    if($status==1) {
        echo "<div class='alert alert-success'>User added successfully.</div>" ;  
        $redurl = admin_url('/admin.php?action=manage&type=authors');  
        redirect_withdelay_script($redurl);  
    } else if($status==2){
        echo "<div class='alert alert-danger'>User already exists with given email.</div>" ;  
    } else {   
        echo "<div class='alert alert-danger'>User not inserted.</div>" ;  
    }       
}   
       
?>
<div class="profile_page_design add_blog_design">  
<div class="row">   
     
    <div class="col-12">
    <form action="" class=" full-width-form mb-0" method="post" autocomplete="off" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-3">
                <img src="images/logo.png" alt="" width="100" class="img-thumbnail img-circle img-fluid img-shadow profile_img" />
            </div>    
            <div class="col-md-6">
                <label>Upload Profile Photo (.jpg, .jpeg and .png)  <span class="text-danger">*</span></label>
                <div class="form-group">
                    <input type="file" class="form-control" name="profile_pic" /> 
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-3">
                <label>First Name <span class="text-danger">*</span></label>
            </div>    
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo $userinfo['firstname']; ?>" name="firstname" required="required" autofocus />
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-md-3">
                <label>Last Name <span class="text-danger">*</span></label>
            </div>    
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" value="<?php echo $userinfo['lastname']; ?>" name="lastname" required="required" />
                </div> 
            </div> 
        </div> 
        <div class="row"> 
            <div class="col-md-3">
                <label>Username <span class="text-danger">*</span></label>
            </div>    
            <div class="col-md-6"> 
                <div class="form-group"> 
                    <input type="text" class="form-control verify_username" value="<?php echo $userinfo['username']; ?>" name="username" required="required" />
                </div> 
            </div> 
        </div>
        <div class="row">    
            <div class="col-md-3">
                    <label>Email Address<span class="text-danger">*</span></label>
            </div>    
            <div class="col-md-6">
                <div class="form-group">
                    <input type="email" class="form-control" value="<?php echo $userinfo['email']; ?>" name="email" required="required"  />
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
                        <option value="author">Author</option>   
                        <option value="administrator">Administrator</option> 
                    </select>  
                </div>    
            </div>  
        </div>  
     
        <div class="row">      
            <div class="col-md-3">  
                <label>Set Password</label>
            </div>     
            <div class="col-md-6">
                <div class="form-group">
                    <input type="password" maxlength="10" class="form-control" value="" name="user_password" required="required" />
                </div>  
            </div>  
        </div>
        
        <div class="row">
            <div class="col-md-9"> 
                <button name="add_user" class="btn btn-success btn-inline-block rounded-0 float-right ml-2" type="submit">Save</button>
            </div> 
        </div>

        </form>
    </div>
    
</div>
</div>

