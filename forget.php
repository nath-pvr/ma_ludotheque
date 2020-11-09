<?php
if (!empty($_POST) && !empty($_POST['email']) && !empty($_POST['password'])) {
    require_once 'inc/db.php';
    require_once 'inc/functions.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE email = ? and confirmed_at IS NOT NULL');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    
    if ($user) {
       session_start();
        if(!empty($_POST)){

            if( empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
                $_SESSION['flash']['danger'] = "Les mots de passes ne correspondent pas";
            } else {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo-> prepare('UPDATE users SET password =? WHERE email =?')->execute([$password, $_POST['email']]);
                $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
            }
        }
    }
}
?>

<?php require_once 'inc/functions.php'; ?>
<?php require_once 'inc/header.php'; ?>



<h1>Mot de passe oublié</h1>

<div class="container">
    <div class="row">
        <form class="col-4 md-12" action="" method="POST">
            <div class="form-group ">
                <label for="email">Saisissez votre adresse mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <form action="" method="POST">
                <div class="form-group col-12">
                    <input class="form-control" type="password" name="password" placeholder="Changer de mot de passe"></input>
                </div>

                <div class="form-group col-12">
                    <input class="form-control" type="password" name="password_confirm" placeholder="Confirmation du nouveau mot de passe"></input>
                </div>



                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary ">Envoyer</button>
                </div>
            </form>
    </div>
</div>

<?php require_once 'inc/footer.php' ?>