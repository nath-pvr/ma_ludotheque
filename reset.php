<?php session_start();
require_once 'inc/functions.php';
logged_only();

if(!empty($_POST)){

    if( empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $_SESSION['flash']['danger'] = "Les mots de passes ne correspondent pas";
    } else {
        $user_id = $_SESSION['auth']-> id;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once 'inc/db.php';
        $pdo-> prepare('UPDATE users SET password =? WHERE id =?')->execute([$password, $user_id]);
        $_SESSION['flash']['succes'] = "Votre mot de passe a bien été mis à";
    }
}

?>
<?php require_once 'inc/header.php';?>

<p>Veuillez entrer votre nouveau mot de passe</p>
</br>
<form action="" method="POST">
    <div class="form-group col-4 md-12">
        <input class="form-control" type="password" name="password"  placeholder="Changer de mot de passe"></input>
    </div>

    <div class="form-group col-4 md-12">
        <input class="form-control" type="password" name="password_confirm" placeholder="Confirmation du mot de passe"></input>
    </div>

    <button class="btn btn-primary">Changer mon mot de passe</button>
</form>