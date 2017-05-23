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
        <p>
            <input type="submit" value="Soumettre le formulaire" />
        </p>
    </form>
</div>
<script>
    /*
    $('#autocomplete').autocomplete( {
        source: "<?php  ?>"
    })
    */
</script>

