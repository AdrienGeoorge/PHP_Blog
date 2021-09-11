<?php
if (!empty($_GET['action'])) {
    if ($_GET['action'] === 'show') {
        $post = PostManager::getPost($_GET['id']);

        if (empty($post)) {
            UserManager::redirectToHome();
        }

        if (isset($_POST['commentForm'])) {
            try {
                $success = CommentManager::create($_POST);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        } elseif (isset($_POST['commentDelete'])) {
            try {
                $success = CommentManager::delete($_POST['comment']);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $comments = CommentManager::getCommentsByPost($_GET['id']);

        $returnedTemplate = 'post/showOnePost';
    } elseif ($_GET['action'] === 'create') {
        if (isset($_SESSION['logged']) === false) {
            UserManager::redirectToLogin();
        }

        $categories = CategoryManager::getCategories();

        if (isset($_POST['createForm'])) {
            try {
                $success = PostManager::create($_POST);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }
        $returnedTemplate = 'post/create';
    } elseif ($_GET['action'] === 'update') {
        if (isset($_SESSION['logged']) === false) {
            UserManager::redirectToLogin();
        }

        $post = PostManager::getPost($_GET['id']);
        $categories = CategoryManager::getCategories();

        if (isset($_POST['updateForm'])) {
            try {
                $success = PostManager::update($_POST, $post);
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        $post = PostManager::getPost($_GET['id']);
        $returnedTemplate = 'post/update';
    } elseif ($_GET['action'] === 'delete') {
        $post = PostManager::getPost($_GET['id']);

        try {
            $success = PostManager::delete($_GET['id']);
            header('Location: ../../user/posts');
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        $returnedTemplate = 'post/showOnePost';
    }
}
