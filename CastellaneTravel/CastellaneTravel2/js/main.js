/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
(function($) {
    //alert("salut");
    
    $('.addPanier').click(function(event){
        event.preventDefault();
        $.get($(this).attr('href'),{}, function(data){
            //console.log(data);
            if (data.error){
                console.log(data.message);
            } else {
                console.log(data.message);
            }
        },'json');
        return false;
    });
})(jQuery);

