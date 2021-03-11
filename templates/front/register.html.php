<p>Complétez le formulaire ci-dessous pour soumettre votre profil.</p>

<form method="POST" action="index.php?controller=user&task=submit">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Prénom" required>
                <label for="author">Prénom</label>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Nom" required>
                <label for="author">Nom</label>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="public_name" id="public_name" placeholder="Pseudo public">
                <label for="public_name">Pseudo public</label>
                <small class="text-form">Si vide, le prénom et le nom seront utilisés.</small>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-8">
        <div class="form-floating mb-3">
            <input type="email" class="form-control" name="email_address" id="email_address" placeholder="Adresse email" required>
            <label for="email_address">Adresse email</label>
        </div>
    </div>
    <div class="form-floating mb-3 col-lg-6 col-md-8">
        <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe" required>
        <label for="password">Mot de passe</label>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Soumettre</button>
</form>