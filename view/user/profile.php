<?php if (isset($error)): ?>
    <div class="alert alert__error">
        <?= $error ?>
    </div>
<?php elseif (isset($success)): ?>
    <div class="alert alert__success">
        <?= $success ?>
    </div>
<?php endif; ?>

<div class="grid__2">
    <div>
        <h1 class="mb-1">Account information</h1>
        <div class="box mt-1">
            <div class="form-group">
                <label for="login">Login</label>
                <input class="form-field" type="text" id="login" name="login"
                       value="<?= $_SESSION['user']->getLogin() ?>"
                       disabled>
            </div>

            <a href="<?= ROOT . '/user/update' ?>" class="button button--green">Update my information</a>
        </div>
    </div>
    <div>
        <h1 class="mb-1">Actions</h1>
        <div class="box mt-1">
            <a href="<?= ROOT . '/post/create' ?>" class="button button--blue">Create a new post</a>
            <a href="<?= ROOT . '/user/posts' ?>" class="button button--blue">See all my posts</a>
        </div>
    </div>
</div>
