<?php
if (!empty($_GET['action'])) {
    if ($_GET['action'] === 'show') {
        if (isset($_SESSION['logged']) === false) {
            UserManager::redirectToLogin();
        }

        $categories = CategoryManager::getCategories();

        if (isset($_POST['createForm'])) {
            try {
                $success = CategoryManager::create($_POST);
                $categories = CategoryManager::getCategories();
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        }

        if (empty($_GET['id']) === false) {
            $category = CategoryManager::getCategory($_GET['id']);

            if (isset($_POST['updateForm'])) {
                try {
                    $success = CategoryManager::update($_POST, $category);
                    $categories = CategoryManager::getCategories();
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        $returnedTemplate = 'categories/show';
    } elseif ($_GET['action'] === 'delete') {
        try {
            $success = CategoryManager::delete($_GET['id']);
            header('Location: ../../categories/show');
        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        $categories = CategoryManager::getCategories();
        $returnedTemplate = 'categories/show';
    }
}