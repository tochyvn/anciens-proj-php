$(document).ready(function() {
    
        $('#ville').autocomplete({
            source : '../action/autocompletion.php',
            minLength : 3,
            scroll : true,
            select : function(event, ui) {
                var inputId = $('#id_ville'), inputCP = $('#cp');
                resultat = ui.item.value;
                tableau = resultat.split(' ');
                cp = tableau[0], ville = tableau[1], idVille = tableau[tableau.length - 1];
                console.log(tableau+'\n');
                for (i = 2; i<tableau.length-1; i++) {
                    ville = ville + ' ' + tableau[i];
                }
                ui.item.value = ville;
                inputId.val(idVille);
                inputCP.val(cp);
                console.log(inputId.val()+'\n');
                console.log(inputCP.val()+'\n');
            }
        });
        
        
        /**
         * Suppression d'un produit
         */
        $('.supprimer_produit').each(function(index, value) {
            
            $(value).click(function() {
                inputId = $(this).prev();
                id = inputId.val();
                supprimer_produit(id);
            });
           
        });
        
        function supprimer_produit(id) {
            
            $.ajax({
                url : '../action/deleteProduit.php',
                method: 'post',
                datatype : 'json',
                data : { id : id },
                error : function() {
                    console.log('Mon debugging');
                },
                success : function(data) {
                    $('table.produits #produit_'+id).remove();
                }
            });
            
        }
        
        
        /**
         * AJOUT DE PRODUIT
         */
        $('#ajout_produit').submit(function(e) {
            
            e.preventDefault();
            /**
             * ICI A INTEGRER LA VALIDATION DU FORMULAIRE
             */
            var $form = $(this);
            var formdata = (window.FormData) ? new FormData($form[0]) : null;
            var data = (formdata !== null) ? formdata : $form.serialize();
 
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                contentType: false, // obligatoire pour de l'upload
                processData: false, // obligatoire pour de l'upload
                dataType: 'json', // selon le retour attendu
                data: data,
                success: function (response) {
                    console.log(response);
                }
            });
            
        });
        
        
        $('#modifier_produit').submit(function(e) {
            
            e.preventDefault();
            /**
             * ICI A INTEGRER LA VALIDATION DU FORMULAIRE
             */
            
            $.ajax({
                url : $(this).attr('action'),
                data : $(this).serialize(),
                datatype : 'json',
                method : 'post',
                error : function() {
                    console.log('erreur');
                },
                success : function(data) {
                    console.log(data);
                }
            });
           
        });
        
        /**
         * AJOUT DE Utilisateur
         */
        $('#ajout_utilisateur').submit(function(e) {
            
            e.preventDefault();
            /**
             * ICI A INTEGRER LA VALIDATION DU FORMULAIRE
             */
            $.ajax({
                url : $(this).attr('action'),
                data : $(this).serialize(),
                datatype : 'json',
                method : 'post',
                error : function() {
                    console.log('erreur AJAX');
                },
                success : function(data) {
                    console.log(data);
                }
            });
           
        });
        
        $('#modifier_utilisateur').submit(function(e) {
            
            e.preventDefault();
            /**
             * ICI A INTEGRER LA VALIDATION DU FORMULAIRE
             */
            $.ajax({
                url : $(this).attr('action'),
                data : $(this).serialize(),
                datatype : 'json',
                method : 'post',
                error : function() {
                    console.log('erreur AJAX');
                },
                success : function(data) {
                    console.log(data);
                }
            });
           
        });
        
        $('.supprimer_user').each(function(index, value) {
            
            console.log('tochapppp');
            $(value).click(function() {
                inputId = $(this).prev();
                id = inputId.val();
                supprimer_produit(id);
            });
           
        });
        
        
        
        $('#ajout_categorie').submit(function(e) {
            
            e.preventDefault();
            /**
             * ICI A INTEGRER LA VALIDATION DU FORMULAIRE
             */
            $.ajax({
                url : $(this).attr('action'),
                data : $(this).serialize(),
                datatype : 'json',
                method : 'post',
                error : function() {
                    console.log('erreur AJAX');
                },
                success : function(data) {
                    console.log(data);
                }
            });
           
        });
        
        $('#modifier_categ').submit(function(e) {
            
            e.preventDefault();
            /**
             * ICI A INTEGRER LA VALIDATION DU FORMULAIRE
             */
            $.ajax({
                url : $(this).attr('action'),
                data : $(this).serialize(),
                datatype : 'json',
                method : 'post',
                error : function() {
                    console.log('erreur AJAX');
                },
                success : function(data) {
                    console.log(data);
                }
            });
           
        });
        
        $('.supprimer_categ').each(function(index, value) {
            
            console.log('tochapppp');
            $(value).click(function() {
                inputId = $(this).prev();
                id = inputId.val();
                supprimer_categ(id);
            });
           
        });
        
        function supprimer_categ(id) {
            
            $.ajax({
                url : '../action/deleteUser.php',
                method: 'post',
                datatype : 'json',
                data : { id : id },
                error : function() {
                    console.log('Mon debugging');
                },
                success : function(data) {
                    $('table.users #user_'+id).remove();
                }
            });
            
        }
        
        
       /**
        * 
        * PERMETTANT L'AJOUT D'UN SEUL FICHIER A LA FOIS
        */
       var allowedTypes = ['png', 'jpg', 'jpeg'],
       fileInput = document.querySelector('#input_file_photo'),
        prev = document.querySelector('#prev');

    

        fileInput.addEventListener('change', function() {
            var files = this.files,
            imgType;
            
            imgType = files[0].name.split('.');
            console.log(imgType);
            //imgType = imgType.toLowerCase(); // On utilise toLowerCase() pour éviter les extensions en majuscule
            if(allowedTypes.indexOf(imgType[1]) != -1) {
                console.log('tochp');
                createThumbnail(files[0]);
            }
            console.log('tochp');
        }, false);
        
        function createThumbnail(file) {

            var reader = new FileReader();
            reader.addEventListener('load', function() {
                var imgElement = document.createElement('img');
                imgElement.style.maxWidth = '150px';
                imgElement.style.maxHeight = '150px';
                imgElement.setAttribute('class', 'prev_img');
                imgElement.src = this.result;
                
            var child = document.getElementsByClassName('prev_img');
            if(child[0]) {
                prev.removeChild(child[0]);
            }
            prev.appendChild(imgElement);
            }, false);

            reader.readAsDataURL(file);
        }
});


