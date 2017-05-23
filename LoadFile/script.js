$(document).ready(function(){
   $(".loadfile").change(function(){
       
       //-- Ces lignes de code doivent t'afficher l'image
       //-- dans le contenaire class="img" -------
       var val=$(this).val();
       var img="<img src=" + val + ">";
       $(".img").html(img);
   }); 
});