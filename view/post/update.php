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
    <h1 class="mb-1">Update my post</h1>
    <div class="box w-60 m-auto mt-1">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-field" type="text" id="title" name="title" value="<?= $post->getTitle() ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea class="form-field" id="content" name="content"
                          required><?= $post->getContent() ?></textarea>
            </div>

            <div class="images--preview">
                <div class="grid__2 mb-1">
                    <?php if (empty($post->getImage()[0]) === false): ?>
                        <img src="<?= ROOT . '/' . $post->getImage()[1] ?>" alt="">
                    <?php else: ?>
                        <img src="<?= ROOT . '/assets/images/choose_image.png' ?>" alt="">
                    <?php endif; ?>
                    <div class="actions">
                        <div class="absolute__center">
                            <input class="form-field" type="file" name="post_img">
                        </div>
                    </div>
                </div>
            </div>

            <select name="category" id="category" class="form-field mb-1" required>
                <option disabled>
                    <?= empty($categories) === true ? 'Create category before choosing' : 'Choose a category' ?>
                </option>
                <?php
                if (empty($categories) === false):
                    foreach ($categories as $category): ?>
                        <option value="<?= $category->getId() ?>" <?= $post->getCategory() === $category->getName() ? 'selected' : '' ?>><?= $category->getName() ?></option>
                    <?php endforeach;
                endif;
                ?>
            </select>

            <button class="button button--green" type="submit" name="updateForm">Update</button>
            <a href="<?= ROOT . '/post/delete/' . $post->getId() ?>" class="button button--red">Delete</a>
            <a href="<?= ROOT . '/user/posts' ?>" class="button button--blue">Cancel and return to my posts</a>
        </form>
    </div>
</div>