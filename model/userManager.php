<?php

class UserManager
{
    public static function connect($login, $password = null, $updated = false)
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT *
                FROM users
                WHERE login = :login
                ');
        $query->execute(['login' => $login]);
        $result = $query->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');

        if ($result[0] !== null) {
            if (password_verify($password, $result[0]->getPassword()) || $updated === true) {
                $_SESSION['logged'] = true;
                $_SESSION['user'] = $result[0];
            } else {
                throw new Exception('Password invalid');
            }
        } else {
            throw new Exception('No user with this login');
        }

        self::redirectToProfile();
    }

    public static function register($args)
    {
        $login = $args['login'];
        $password = $args['password'];
        $repeat = $args['password_repeat'];

        if (empty($login) || empty($password) || empty($repeat)) {
            throw new Exception('You must fill all the fields');
        }

        $errors = self::checkUserInfos($login);

        if ($errors !== null) {
            throw new Exception($errors);
        }

        if (preg_match('/^(?=.*[_!@#$%^&*-])(?=.*[0-9])(?=.*[a-z]).{8,}/', $password) === 0) {
            throw new Exception('Password invalid: 8 characters minimum and should include at least one letter, one number, and one special character');
        }

        if ($password !== $repeat) {
            throw new Exception('Passwords do not match');
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $query = MyPDO::getInstance()->prepare('
                INSERT INTO users(login, password)
                VALUES (:login, :password)
                ');
        $query->execute([
            'login' => $login,
            'password' => $hashed,
        ]);

        self::connect($login, $password);
    }

    public static function update($args)
    {
        $login = $args['login'];
        $currentPassword = $args['current_password'];
        $newPassword = $args['new_password'];
        $repeat = $args['password_repeat'];

        if (empty($login)) {
            throw new Exception('You must fill login field');
        }

        $errors = self::checkUserInfos($login);

        if ($errors !== null) {
            throw new Exception($errors);
        }

        if (empty($newPassword) === false) {
            if (empty($currentPassword) || empty($repeat)) {
                throw new Exception('You must fill current password and repeat the new');
            }

            if (preg_match('/^(?=.*[_!@#$%^&*-])(?=.*[0-9])(?=.*[a-z]).{8,}/', $newPassword) === 0) {
                throw new Exception('Password invalid: 8 characters minimum and should include at least one letter, one number, and one special character');
            }

            if (password_verify($currentPassword, $_SESSION['user']->getPassword()) === false) {
                throw new Exception('Current password invalid');
            }

            if ($newPassword !== $repeat) {
                throw new Exception('New passwords do not match');
            }

            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
        } else {
            $hashed = $_SESSION['user']->getPassword();
        }

        $query = MyPDO::getInstance()->prepare('
                UPDATE users
                SET login = :login, password = :password
                WHERE id = :id
                ');
        $query->execute([
            'login' => $login,
            'password' => $hashed,
            'id' => $_SESSION['user']->getId()
        ]);

        self::connect($login, null, true);
    }

    public static function checkUserInfos($login)
    {
        if (self::checkCredentials($login) === false) {
            return 'Login already used';
        }

        return null;
    }

    public static function checkCredentials($login)
    {
        $query = MyPDO::getInstance()->prepare('
                SELECT *
                FROM users
                WHERE login = :login
                AND login != :loginSession
                ');

        $loginSession = isset($_SESSION['user']) ? $_SESSION['user']->getLogin() : null;

        $query->execute([
            'login' => $login,
            'loginSession' => $loginSession
        ]);

        return empty($query->fetchAll());
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ' . ROOT);
    }

    public static function checkLogged()
    {
        return isset($_SESSION['logged']) && $_SESSION['logged'] === true;
    }

    public static function redirectToProfile()
    {
        header('Location: ' . ROOT . '/user/profile');
    }

    public static function redirectToLogin()
    {
        header('Location: ' . ROOT . '/user/login');
    }

    public static function redirectToHome()
    {
        header('Location: ' . ROOT);
    }
}
