
jQuery('document').ready(function($) {

    // validate username  
    jQuery('.vs_msg').remove();  
    jQuery('.verify_username').attr('autocomplete', 'off');
    jQuery('.verify_username').parent().addClass('verify_username_wr'); 
    jQuery('.verify_username').on('keyup', function(){
        var vthis = jQuery(this);
        var cusername = vthis.val();
        var cunamelen =  cusername.length;  
        vthis.attr('autocomplete', 'off');

        jQuery('.vs_msg').remove();   
        jQuery('.vs_msg2').remove();   

       if(cunamelen>6) {      
           if(vthis.attr('requestRunning')==="true") { 
               return false;  
           } else {
                $.ajax({
                    method: "POST",
                    url: "./ajax_checkusername.php", 
                    data: { cusername: cusername }, 
                    success: function(data) { 
                        if(data=='0') {  
                            vthis.after('<span class="vs_msg text-secondary">Not available</span>');
                        } else {
                            vthis.after('<span class="vs_msg text-success">Available</span>'); 
                        }
                    },
                    error: function(){
                        console.log( "error" );
                        vthis.before('<span class="vs_msg text-danger">Error, Please try again.</span>'); 
                    }
                });  
           }
       } else { 
           vthis.attr('requestRunning', "false");
           jQuery('.vs_msg2').remove();
           vthis.before('<span class="vs_msg2 text-danger">Username must be more than 6 letters.</span>'); 
       }
 
    });

    // Script Select All - Users 
    jQuery('#user_check_all').click(function(){
        jQuery(".table_checkboxes2").prop('checked', jQuery(this).prop('checked'));
    }); 
     
    jQuery(".table_checkboxes2").change(function(){
        if (!jQuery(this).prop("checked")){
            jQuery("#user_check_all").prop("checked",false);
        }
    });         
     
    // Script Select All - Blogs
    jQuery('#blog_check_all').click(function(){
        jQuery(".table_checkboxes").prop('checked', jQuery(this).prop('checked'));
    }); 
     
    jQuery(".table_checkboxes").change(function(){
        if (!jQuery(this).prop("checked")){
            jQuery("#blog_check_all").prop("checked",false);
        }
    });         
     
    // Menu Collapse
    jQuery('.menu-collapse').click(function(){
        jQuery('body').toggleClass('shortmenu');
    }); 
     
});


   