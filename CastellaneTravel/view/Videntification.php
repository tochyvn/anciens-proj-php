

        <div class="form-connexion">
            <form id="form-connexion" action="<?php echo site_url('auth/connexion'); ?>" method="POST">
            <!--
            <p>
                <input type="hidden" name="action" value="connexion" />
            </p>
            -->
            <p>
                <label>Email : </label>
                <input type="text" name="email" class="form_required valid_email" />
            </p>
            <p>
                <label>Mot de passe : </label>
                <input type="password" name="passwd" class="form_required" />
            </p>
            <p>
                <input type="submit" value="Soummetre le formulaire" />
            </p>
            </form>
        </div>

        
        