<?php

function debug($variable)
{
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

function str_random($length)
{

    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function logged_only()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['auth'])) {
        $_SESSION['flash']['danger'] = "Vous n'avez pas acces à cette page, merci de vous connecter !";
        header('Location: login.php');
        exit();
    }
}

function reconnect_cookie()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_COOKIE['remember']) && !isset($_SESSION['auth'])){

        require_once 'inc/db.php';

        $remember_cookie = $_COOKIE['remember'];
        $parts = explode('==', $remember_cookie);
        $user_id = $parts['0'];
        $req = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $req->execute([$user_id]);
        $user = $req->fetch();
        if ($user) {
            $expected = $user_id . '==' . $user->cookie_token . sha1($user_id . 'panda');
            if ($expected == $remember_cookie) {
                session_start();
                $_SESSION['auth'] = $user;
                setcookie('remember', $remember_cookie, time() + 60 * 60 * 24 * 7);
            }else {
                setcookie('remember', null, -1);
            }
        } else {
            setcookie('remember', null, -1);
        }
    } 
}
