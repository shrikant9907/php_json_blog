
jQuery('document').ready(function($) {
 
//  Blog List Table - Data Table
    if(table_lenght==='') {
        table_lenght = 10;
    }
     
    var table = jQuery('#blog_list_front').DataTable({
        "paging":   true,
        "ordering": false,  
        "info":     false,     
        "pageLength": parseInt(table_lenght),
        "aaSorting": [],  
        "searching": false  
    });   
      
});


   