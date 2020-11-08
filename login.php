<?php
    if(!empty ($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
        require_once 'inc/db.php';
        $req = $pdo->prepare('SELECT * FROM users WHERE (username= :username OR email = :username) and confirmed_at IS NOT NULL');
        $req->execute(['username' => $_POST['username']]);
        $user = $req->fetch();
        if(password_verify($_POST['password'], $user->password)){
            session_start();
            $_SESSION['auth'] = $user;
            $_SESSION['flash']['succes'] = " Vous êtes bien connecté(e) !!!";
            header('Location: account.php');
            exit();
        } else {
            $_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrecte";
        }
    }
?>

<?php require_once 'inc/functions.php';?>
<?php require_once 'inc/header.php';?>



<h1>Se connecter </h1>

<div class="container">
    <div class="row">
        <form class="col-4 md-12" action="" method="POST">
            <div class="form-group ">
                <label for="username">pseudo ou email</label>
                <input type="text" class="form-control" id="userName" name="username" placeholder="pseudo" required>
            </div>
           
            <div class="form-group">
                <label for="password">Mot de passe <a href="forget.php">(mot de passe oublier ?)</a></label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
           
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary ">Se connecter</button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'inc/footer.php' ?>