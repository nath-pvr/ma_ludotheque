<?php
require_once 'inc/functions.php';

reconnect_cookie();

if (isset($SESSION['auth'])) {
    header('Location: account.php');
    exit();
}
if (!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])) {
    require_once 'inc/db.php';
    require_once 'inc/functions.php';
    $req = $pdo->prepare('SELECT * FROM users WHERE (username= :username OR email = :username) and confirmed_at IS NOT NULL');
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();

    if (password_verify($_POST['password'], $user->password)) {

        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = " Vous êtes bien connecté(e) !!!";

        if ($_POST['remember']) {
            $remember_cookie = str_random(250);
            $pdo->prepare('UPDATE users SET cookie_token = ? WHERE id = ?')->execute([$remember_cookie, $user->id]);
            setcookie('remember', $user->id . '==' . $remember_cookie . sha1($user->id . 'panda'), time() + 60 * 60 * 24 * 7);
        }

        header('Location: account.php');
        exit();
    } else {
        debug($user);
        $_SESSION['flash']['danger'] = "Identifiant ou mot de passe incorrecte";
    }
}
?>

<?php require_once 'inc/functions.php'; ?>
<?php require_once 'inc/header.php'; ?>



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
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" value="1" name="remember" id="remember">
                <label class="form-check-label">Se souvenir de moi</label>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary ">Se connecter</button>
                </div>
        </form>
    </div>
</div>

<?php require_once 'inc/footer.php' ?>