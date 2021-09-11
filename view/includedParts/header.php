<header>
    <div class="header-limiter">
        <h1><a href="#">Blog</h1>
        <nav>
            <a href="<?= ROOT ?>">Posts</a>
            <?php if(isset($_SESSION) && sizeof($_SESSION) > 0): ?>
                <a href="<?= ROOT . '/post/create' ?>">New post</a>
                <a href="<?= ROOT . '/user/posts' ?>">My posts</a>
                <a href="<?= ROOT . '/categories/show' ?>">Categories</a>
            <?php endif; ?>
        </nav>

        <div class="header-right">
            <?php if (UserManager::checkLogged()): ?>
                <div class="header-user__menu">
                    <?= $_SESSION['user']->getLogin() ?>
                    <ul>
                        <li><a href="<?= ROOT . '/user/profile' ?>">My profile</a></li>
                        <li><a href="<?= ROOT . '/user/logout' ?>" class="highlight">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="header-user__button">
                    <a href="<?= ROOT . '/user/login' ?>">Log in or register</a>
                </div>
            <?php endif; ?>
        </div>

    </div>

</header>
