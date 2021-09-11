<?php if (isset($error)): ?>
    <div class="alert alert__error">
        <?= $error ?>
    </div>
<?php endif; ?>

<div class="text-center">
    <h1 class="mb-1">Update my information</h1>
    <div class="box w-60 m-auto mt-1">
        <form action="" method="post">
            <div class="form-group">
                <label for="login">Login</label>
                <input class="form-field" type="text" id="login" name="login"
                       value="<?= $_SESSION['user']->getLogin() ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="current_password">Current password</label>
                <input class="form-field" type="password" id="current_password" name="current_password"
                       placeholder="Enter your current password">
            </div>

            <div class="form-group">
                <label for="new_password">New password</label>
                <input class="form-field" type="password" id="new_password" name="new_password"
                       placeholder="Enter a new password">
            </div>

            <div class="form-group">
                <label for="password_repeat">Repeat password</label>
                <input class="form-field" type="password" id="password_repeat" name="password_repeat"
                       placeholder="Repeat the password">
            </div>

            <button class="button button--green" type="submit" name="updateForm">Update</button>
            <a href="<?= ROOT . '/user/profile' ?>" class="button button--red">Cancel and return to my profile</a>
        </form>
    </div>
</div>
