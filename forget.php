<?php
    if(!empty ($_POST) && !empty($_POST['email']) && !empty($_POST['password'])){
        require_once 'inc/db.php';
        require_once 'inc/functions.php';
        $req = $pdo->prepare('SELECT * FROM users WHERE email = :email) and confirmed_at IS NOT NULL');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if(($user)){
            session_start();
            $reset_token = str_random(60);
            $pdo->prepare('UPDATE users SET reset_token =?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
            $_SESSION['flash']['success'] = " les instruction de rappelle de mot de passe vous ont été envoyés";
            // mail($_POST['email'], 'Réinitialisation de votre mot de passe', "Afin de valider votre compte merci de cliquer sur ce lien \n\n http://localhost/ludotheque/forget.php?id={$user->id}&token=$reset_token");
            // header('Location: confirm.php?id='.{$user->id}.'&token='.$reset_token);
            exit();
        } else {
            $_SESSION['flash']['danger'] = "Aucun compte ne correspond à cette adresse";
        }
    }
?>

<?php require_once 'inc/functions.php';?>
<?php require_once 'inc/header.php';?>



<h1>Mot de passe oublier</h1>

<div class="container">
    <div class="row">
        <form class="col-4 md-12" action="" method="POST">
            <div class="form-group ">
                <label for="email">Saisissez votre adresse mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
           
           
           
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary ">Envoyer</button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'inc/footer.php' ?>