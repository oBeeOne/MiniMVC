/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    $("li span").each(function(){
        var cls = $(this).attr("title");
        var cl = cls.split(' ');
        var img = cl[0]+cl[1]+'.png';
        img = 'theme/default/images/'+img;
        
        $(this).css({
            "background-image": "url('"+img+"')",
            "background-size": "180px 180px",
            "background-repeat":"no-repeat",
            "background-position":"center center"
        });
    });
    
    $("li span").mouseover(function(){
        $(this).addClass("hover");
    });
    
    $("li span").mouseleave(function(){
        $(this).removeClass("hover");
    });
});