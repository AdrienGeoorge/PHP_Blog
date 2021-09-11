<?php
if (!empty($_GET['action'])) {
    if ($_GET['action'] === 'login') {
        if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
            UserManager::redirectToProfile();
        }

        if (isset($_POST['registerForm'])) {
            try {
                UserManager::register($_POST);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        } elseif (isset($_POST['loginForm'])) {
            try {
                UserManager::connect($_POST['login'], $_POST['password']);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        $returnedTemplate = 'user/login';
    } elseif ($_GET['action'] === 'logout') {
        UserManager::logout();
    } elseif ($_GET['action'] === 'profile') {
        if (isset($_SESSION['logged']) === false) {
            UserManager::redirectToLogin();
        }

        if (isset($_POST['sendArchive'])) {
            try {
                $success = PostManager::sendArchive();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $returnedTemplate = 'user/profile';
    } elseif ($_GET['action'] === 'update') {
        if (isset($_SESSION['logged']) === false) {
            UserManager::redirectToLogin();
        }

        if (isset($_POST['updateForm'])) {
            try {
                UserManager::update($_POST);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $returnedTemplate = 'user/update';
    } elseif ($_GET['action'] === 'posts') {
        if (isset($_SESSION['logged']) === false) {
            UserManager::redirectToLogin();
        }

        $posts = PostManager::getPostByUser();

        $returnedTemplate = 'user/posts';
    }
}
