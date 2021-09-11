<?php if (isset($error)): ?>
    <div class="alert alert__error">
        <?= $error ?>
    </div>
<?php elseif (isset($success)): ?>
    <div class="alert alert__success">
        <?= $success ?>
    </div>
<?php endif; ?>

<div class="text-center">
    <h1 class="mb-1">Create a new post</h1>
    <div class="box w-60 m-auto mt-1">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-field" type="text" id="title" name="title" placeholder="Enter a title" required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-field" id="content" name="content"
                          placeholder="Enter post content" required></textarea>
            </div>

            <div class="form-group">
                <label for="user_img">Image</label>
                <input class="form-field" type="file" name="post_img" required>
            </div>

            <select name="category" id="category" class="form-field mb-1" required>
                <option disabled>
                    <?= empty($categories) === true ? 'Create category before choosing' : 'Choose a category' ?>
                </option>
                <?php
                if (empty($categories) === false):
                    foreach ($categories as $category): ?>
                        <option value="<?= $category->getId() ?>"><?= $category->getName() ?></option>
                    <?php endforeach;
                endif;
                ?>
            </select>

            <button class="button button--green" type="submit" name="createForm">Post</button>
            <a href="<?= ROOT . '/user/posts' ?>" class="button button--red">Cancel and return to my posts</a>
        </form>
    </div>
</div>
