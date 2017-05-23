$(function() {
    
    //alert('le document est prêt');
    var height = $('#name');
    
    alert(height.css('width'));
    height.css({
        'border' :  'solid 2px red'
        
    });
    
    $('input').css({
        'height' : '30px',
        'width' : '500px'
    });
});


