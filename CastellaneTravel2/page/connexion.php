
<!-- Main Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">Panel with panel-primary class</div>
                    <div class="panel-body">
                        <form name="" id="form-connexion" action="index.php?use_case=auth&action=ajaxconnexion" >
                            <div class="row control-group">
                                <div class="form-group col-xs-12 floating-label-form-group controls">
                                    <label>Login</label>
                                    <input type="email" class="form-control" placeholder="Login" name="email" id="Login" required data-validation-required-message="Please enter your Login.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="row control-group">
                                <div class="form-group col-xs-12 floating-label-form-group controls">
                                    <label>password</label>
                                    <input type="password" class="form-control" placeholder="pswd" name="passwd" id="" required data-validation-required-message="Please enter your email pswd.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>

                            <div id="success"></div>
                            <div class="row">
                                <div class="form-group col-xs-12">
                                    <button type="submit" class="btn btn-default center-block">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
<script>
    $('#form-connexion').submit(function(e) {

        e.preventDefault();
        var id = $(this).attr('id');
        var elem = $(this); 

        $.ajax({
            type: "POST", 
            dataType: "json",
            data: $(this).serialize(), 
            url: $(this).attr('action'),
            error: function(result){
                //console.log(result);
                console.log("La requête Ajax s'est mal passée");
            },
            success: function(result) {
                console.log("La requête Ajax s'est bien passée\n");  
                console.log(result);
            }

        });
        return false;
    });
</script>

