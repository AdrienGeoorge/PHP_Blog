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
        <h1 class="mb-1">Categories list</h1>
        <?php if (empty($categories)): ?>
            <h2>There are no categories</h2>
        <?php else: ?>
            <?php foreach ($categories as $cat): ?>
                <div class="box grid__2">
                    <div class="post__background__title--relative">
                        <h4 class="absolute__center_y"><?= $cat->getName() ?></h4>
                    </div>
                    <div class="grid__2" style="grid-gap: 0;">
                        <div class="button button--blue"
                             data-id="<?= $cat->getId() ?>">
                            Edit
                        </div>
                        <div class="button button--red"
                             data-id="<?= $cat->getId() ?>">
                            Delete
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div>
        <div class="text-center">
            <h1 class="mb-1">
                <?= empty($_GET['id']) === false && isset($category) ? 'Update category' : 'Create a new category' ?>
            </h1>
            <div class="box m-auto mt-1">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-field"
                               type="text" id="name"
                               name="name"
                               placeholder="<?= empty($_GET['id']) === false && isset($category) ? $category->getName() : 'Enter a name' ?>"
                               value="<?= empty($_GET['id']) === false && isset($category) ? $category->getName() : '' ?>"
                               required>
                    </div>

                    <button class="button button--green"
                            type="submit"
                            name="<?= empty($_GET['id']) === false && isset($category) ? 'updateForm' : 'createForm' ?>"
                    >
                        <?= empty($_GET['id']) === false && isset($category) ? 'Update' : 'Create' ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const buttons = document.querySelectorAll('.button--blue');

    for (const button of buttons) {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            location = '<?= ROOT . '/categories/show/' ?>' + button.getAttribute('data-id');
        });
    }

    const buttonsDelete = document.querySelectorAll('.button--red');

    for (const button of buttonsDelete) {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            location = '<?= ROOT . '/categories/delete/' ?>' + button.getAttribute('data-id');
        });
    }
</script>