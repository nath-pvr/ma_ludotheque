<?php
require_once "header.php";?>

<?php
if (!empty($_POST)) {

    $errors = array();
    require_once 'inc/db.php';

    if (empty($_POST['username']) || !preg_match('/^[a-zA-Z0-9_]+$/', $_POST['username'])) {
        $errors['username'] = "Votre pseudo n'est pas valide";
    } else{
        $req =$pdo->prepare('SELECT id FROM users WHERE username = ?');
        $req ->execute([$_POST['username']]);
        $user = $req->fetch();
        if($user){
            $errors['username'] = 'Ce pseudo est déjà pris';
        }
    } 

    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Votre email n'est pas valide";
    } else{
        $req =$pdo->prepare('SELECT id FROM users WHERE email = ?');
        $req ->execute([$_POST['email']]);
        $mail = $req->fetch();
        if($mail){
            $errors['email'] = 'Cet email est déjà utilisé pour un autre compte';
        }
    }

    if (empty($_POST['password']) || $_POST['password'] != $_POST['confirmpassword']) {
        $errors['password'] = "Vous devez rentrer un mot de passe valide";
    }

    if (empty($errors)) {


        $req = $pdo->prepare("INSERT INTO users SET username = ?, email = ? ,password = ?, confirmation_token =? ");
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = str_random(60);
        $req->execute([$_POST['username'], $_POST['email'], $password, $token]);
        $user_id = $pdo->lastInsertId();
        mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien \n\n http://localhost/ludotheque/confirm.php?id=$user_id&token=$token");
        header('Location: confirm.php');
        exit();

    }
}
?>

<h1>S'inscrire</h1>

<?php if(!empty($errors)) :?>
    <div class="alert alert-danger">
        <p>Vous n'avez pas remplis le formulaire correctement</p>
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?= $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>


<div class="container">
    <div class="row">
        <form class="col-4 md-12" action="" method="POST">
            <div class="form-group ">
                <label for="username">pseudo</label>
                <input type="text" class="form-control" id="userName" name="username" placeholder="pseudo" required>
            </div>
            <div class="form-group">
                <label for="email">Adresse mail</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="mail@opérateur.fr" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmpassword">Confirmez votre mot de passe</label>
                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" required>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary ">M'inscrire</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once "footer.php"?>