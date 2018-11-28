
$(document).ready(function(){
    
    $("option[value='10']").attr("selected", "selected");
    
    $("input[type='submit']").attr("disabled", "disabled");
    
    if($("#EAN").length){
        $("#EAN").focus();
    }
    else{
        $("#IMEI").focus();
    }
    
    $("#EAN").change(function(){
       $(this).blur();
       $("#IMEI").focus(); 
    });
    
    $("#IMEI").change(function(){
       $(this).blur();
       $("input[type='submit']").removeAttr('disabled');
       $("input[type='submit']").focus();
    });
    
});