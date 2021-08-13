
<div class="row">  
    <div class="col-12">
        <form action="" method="post" enctype="multipart/form-data">
        
        <div class="blog_list_design add_blog_design">  
      
        <?php
            /*
            * Bulk Update 
            */
            if(isset($_POST['bulk_submit'])) { 

                extract($_POST);      

                if($user_bulk_action!='') {    
                    if($user_bulk_action=='Delete') {

                        if($_SESSION['user_role']=='administrator') { 
                            $status = $user->delete_from_list($userlist);         
                            if($status) {    
                                echo "<div class='alert alert-success'>Users deleted.</div>";  
                            }
                        } else {
                            echo '<div class="alert alert-warning">You don\'t have permission to delete users.</div>'; 
                        }
                
                        
                    }     
                } else {
                    echo "<div class='alert alert-danger'>Please select bulk action.</div>"; 
                }
            } 

            // Delete User  
            if(isset($_GET['uid']) && isset($_GET['action2']) && ($_GET['action2'])=='delete') {

                $user_id = $_GET['uid'];    
                
                if($_SESSION['user_role']=='administrator') { 
                    if(isset($_GET['confirm']) && ($_GET['confirm']==1)) {
                        $status = $user->delete($user_id);
                        if($status) {
                            echo "<div class='alert alert-success'>User deleted successfully.</div>"; 
                        } else {
                            echo "<div class='alert alert-danger'>User not deleted. Try again.</div>"; 
                        }
                    } else { 
                         $confirm_url = admin_url('/admin.php?action=manage&type=authors&action2=delete&uid='.$user_id.'&confirm=1'); 
                         $cancel_delete_url = admin_url('/admin.php?action=manage&type=authors');  
                         ?>
                         <div class="alert alert-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Are you sure you want to delete user(<?php echo $user_id; ?>)? <a href='<?php echo $confirm_url; ?>' class="btn btn-danger">Yes</a> <a href='<?php echo $cancel_delete_url; ?>' class="btn btn-success">No</a></div>
                         <?php 
                    }
                } else {
                    echo '<div class="alert alert-warning">You don\'t have permission to delete users.</div>'; 
                }
               
            }  
       
            // Delete All Users   
            if(isset($_GET['action2']) && ($_GET['action2'])=='deleteall') {

                if($_SESSION['user_role']=='administrator') { 
                    if(isset($_GET['confirm']) && ($_GET['confirm']==1)) {
                        $status = $user->delete_all();  
                        if($status) {
                            echo "<div class='alert alert-success'>Users deleted successfully.</div>"; 
                        } else {
                            echo "<div class='alert alert-danger'>User not  deleted. Try again.</div>"; 
                        }
                    } else {
                         $confirm_url = admin_url('/admin.php?action=manage&type=authors&action2=deleteall&confirm=1'); 
                         $cancel_delete_url = admin_url('/admin.php?action=manage&type=authors');  
                         ?>
                         <div class="alert alert-warning"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Are you sure you want to delete all users? <a href='<?php echo $confirm_url; ?>' class="btn btn-danger">Yes</a> <a href='<?php echo $cancel_delete_url; ?>' class="btn btn-success">No</a></div>
                         <?php 
                    }
                } else {
                    echo '<div class="alert alert-warning">You don\'t have permission to delete user.</div>'; 
                }
               
            }  

        ?>
            
            <div class="form-row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <h5>Author/User List</h5>
                    </div>
                </div>
            </div>     
                         
            <div class="form-row"> 
                <div class="col custom_lbloglist">  
                    <?php if($_SESSION['user_role']=='administrator') { ?> 
                        <div class="form-group blog_list_field">
                            <div class="custom-control custom-checkbox"> 
                                <input type="checkbox" class="custom-control-input" id="user_check_all">
                                <label class="custom-control-label" for="user_check_all">Select All</label>
                            </div> 
                            <select class="custom-select" id="user_bulk_action" name="user_bulk_action">
                                <option value="">Action</option>
                                <option value="Delete">Delete</option> 
                            </select>
                            <input type="submit" name="bulk_submit" class="btn btn-success text-white border-0" value="Apply">
                        </div>
                    <?php } ?>
                </div> 
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <!--<a href="<?php //echo admin_url('/admin.php?action=manage&type=authors&action2=deleteall'); ?>" class="btn btn-danger float-right ml-2">Delete All</a>--> 
                        <a href="<?php echo admin_url('/admin.php?action=manage&type=addauthor'); ?>" class="btn btn-primary float-right">Create New</a> 
                    </div>
                </div>
            </div>
            
            <hr />
            
            <!--Blog List-->
            <div class="users_table"> 
                <?php $authors = $user->get_users(); ?>   
                <table id="blog_list_table" class="table text-left" style="font-size: 12px; width:100%;" >
                <thead>
                    <tr> 
                        <th scope="col">#</th>
                        <th scope="col">User Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Registered</th>
                        <th scope="col">Action</th>
                    </tr> 
                </thead> 
                <tbody>   
                    <?php 
                        if($authors) {
                           
                            foreach($authors as $authordata) {    
                            
                                $authorname = $authordata->firstname.' '.$authordata->lastname;  
                                $authorid = $authordata->id;  
                                $authoremail = $authordata->email;  
                                $userrole = $authordata->role;  
                                $authorreg = $authordata->registered;      
//                                if($authordata->role=='author') {      
                                ?>      
                                    <tr>   
                                        <td><input type="checkbox" value="<?php echo $authorid; ?>" name="userlist[]" class="table_checkboxes2" /></td> 
                                        <td><?php echo $authorid; ?></td> 
                                        <td><a href="<?php echo admin_url('/admin.php?action=edit&type=profile&uid='.$authorid); ?>"><?php echo ucwords($authorname); ?></a></td> 
                                        <td><?php echo $authoremail; ?></td>
                                        <td><?php echo $userrole; ?></td>
                                        <td><?php echo get_formatted_datetime($authorreg); ?></td>  
                                        <td style="min-width: 90px;" class="text-center"> 
                                            <a style="font-size: 10px; " title="Edit" class="btn btn-primary btn-sm" href="<?php echo admin_url('/admin.php?action=edit&type=profile&uid='.$authorid); ?>">Edit</a>
                                            <a style="font-size: 10px; " title="Delete" class="btn btn-danger btn-sm" href="<?php echo admin_url('/admin.php?action=manage&type=authors&action2=delete&uid='.$authorid); ?>">Delete</a>
                                        </td>
                                    </tr> 
                                <?php 
//                                }  
                            }   
                        }  
                    ?>

                </tbody>
                </table>

            </div>
            <!--Blog List End-->
            
        </div> 
        <!--blog_list_design End-->
        </form>   
    </div>
</div>    
 
    