<div class="container inscription_connexion" >
    <div class="row" >
        <div class="col-lg-5 col-md-5" style="min-height: 400px; ">
            <h3>Vous etes deja client veillez vous connecter</h3>
            <div class="form-connexion">
            <form id="form-connexion" action="<?php echo site_url('auth/connexion'); ?>" method="POST">
            
            <p>
                <label for="email">Email : </label>
                <input type="email" name="email" id="email" class="form_required valid_email" required /><br/>
                <span class="tooltip_error">error</span>
            </p>
            <p>
                <label for="passwd">Mot de passe : </label>
                <input type="password" name="passwd" id="passwd" class="form_required" required/><br/>
                <span class="tooltip_error">error</span>
            </p>
            <p class="valider">
                <input type="submit" value="Connexion" />
            </p>
            </form>
            </div>
        </div>
        <div class="col-lg-7 col-lg-offset-0 col-md-5 col-md-offset-2" >
            <h3 >Vous n'êtes pas client veillez vous inscrire</h3>
            <div class="form-subscribe">
                <div class="error-msg"></div>
                <div class="success-msg"></div>
                <form id="form-subscribe" action="<?php echo site_url('auth/signin'); ?>" method="POST">
                    <p>
                        <label for="nom">Nom : </label>
                        <input type="text" name="nom" id="nom" class="form_required" required />
                    </p>
                    <p>
                        <label for="pseudo">Pseudonyme : </label>
                        <input type="text" name="pseudo" id="pseudo" class="form_required" required />
                    </p>
                    <p>
                        <label for="email">Email : </label>
                        <input type="email" name="email" id="email" class="form_required valid_email" required />
                    </p>
                    <p>
                        <label for="passwd">Mot de passe : </label>
                        <input type="password" name="passwd" id="passwd" class="form_required" required />
                    </p>
                    <p>
                        <label for="passwd1">Confirmer mot de passe : </label>
                        <input type="password" name="passwd1" id="passwd1" class="form_required" required />
                    </p>
                    <p>
                        <label for="adresse">Adresse : </label>
                        <input type="text" name="adresse" id="adresse" class="form_required" required />
                    </p>
                    <p>
                        <label for="ville">Ville : </label>
                        <input type="text" id="ville" name="ville" class="form_required" autocomplete="off" required />
                        <input type="hidden" name="id_ville" id="id_ville" />
                    </p>
                    <p class="valider">
                        <input type="submit" value="Inscription" />
                    </p>
                </form>
            </div>
        </div>
    </div>   
</div>