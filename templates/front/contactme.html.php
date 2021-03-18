<form action="index.php?task=contact" method="POST">
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="sender_name" id="sender_name" placeholder="Nom ou pseudo" value="<?= ($isConnected) ? filter_var($sessionTab['user_name'], FILTER_SANITIZE_STRING) : '' ?>" required>
                <label for="sender_name">Nom ou pseudo</label>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="form-floating mb-3">
                <input type="email" class="form-control" name="sender_email_address" id="sender_email_address" placeholder="Adresse email" value="<?= ($isConnected) ? filter_var($sessionTab['user_email'], FILTER_SANITIZE_EMAIL) : '' ?>" required>
                <label for="sender_email_address">Adresse email</label>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-9">
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="sender_subject" id="sender_subject" placeholder="Sujet" required>
            <label for="sender_subject">Sujet</label>
        </div>
    </div>
    <div class="form-floating mb-3">
        <textarea class="form-control" placeholder="Message" name="sender_message" id="sender_message" style="height: 8.5em;" required></textarea>
        <label for="sender_message">Message</label>
    </div>

    <button type="submit" name="sendEmail" class="btn btn-primary">Envoyer</button>

</form>