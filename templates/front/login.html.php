<form action="index.php?controller=user&task=connect" method="POST">
    <div class="form-floating mb-3 col-lg-6 col-md-8">
        <input class="form-control" type="email" name="email_address" id="email_address" placeholder="Adresse email" required>
        <label for="email_address">Adresse email</label>
    </div>
    <div class="form-floating mb-3 col-lg-6 col-md-8">
        <input class="form-control" type="password" name="password" id="email_address" placeholder="Mot de passe" required>
        <label for="password">Mot de passe</label>
    </div>

    <button type="submit" name="connect" class="btn btn-primary">Connexion</button>

</form>