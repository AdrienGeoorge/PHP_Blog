<?php if (isset($error)): ?>
    <div class="alert alert__error">
        <?= $error ?>
    </div>
<?php elseif (isset($success)): ?>
    <div class="alert alert__success">
        <?= $success ?>
    </div>
<?php endif; ?>

<div class="post__container">
    <div class="post__background"
         style="background-image: url('<?= empty($post->getImage()) ? ROOT . '/assets/images/no_images.png' : ROOT . '/' . $post->getImage()[1] ?>');">
        <div class="post__background__title">
            <div class="post__background__title--relative">
                <div class="post__background__title--absolute">
                    <div class="post__background__title--name"><?= $post->getTitle() ?></div>
                    <div class="post__background__title--infos">Published on
                        <b><?= strftime("%A %d %B %Y", strtotime($post->getDate())) ?></b> by
                        <b><?= $post->getUser() ?></b>
                    </div>
                </div>
            </div>
            <div class="post__background__title--relative">
                <div class="post__background__title--absolute text-center">
                    <div class="post__background__title--category"><?= $post->getCategory() ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="post__content">
        <?= htmlspecialchars_decode($post->getContent()) ?>
    </div>
</div>

<h1 class="mt-1 mb-1">Comments</h1>
<?php
if (empty($comments) === false):
    foreach ($comments as $comment):
        ?>
        <div class="post__container mb-1">
            <div class="post__content">
                <div class="post__background__title--infos">Published on
                    <b><?= strftime("%A %d %B %Y", strtotime($comment->getDate())) ?></b> by
                    <b><?= $comment->getUser() ?></b>
                </div>
                <p class="mt-1"><?= $comment->getComment(); ?></p>
                <?php if(isset($_SESSION['user']) && $comment->getUser() === $_SESSION['user']->getLogin()): ?>
                <form action="" method="post" class="mt-1">
                    <input type="hidden" id="comment" name="comment" value="<?= $comment->getId() ?>">
                    <button class="button button--red" type="submit" name="commentDelete">Delete</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    <?php
    endforeach;
else:
    ?>
    <h2 class="mb-1">There are no comments</h2>
<?php
endif;
?>
<?php if (isset($_SESSION['logged'])): ?>
    <h1>Comment this post</h1>
    <div class="post__container mt-1">
        <div class="post__content">
            <form action="" method="post">
                <div class="form-group">
                    <label for="comment">Your comment</label>
                    <textarea class="form-field" id="comment" name="comment" placeholder="Write here..."
                              required></textarea>
                </div>
                <input type="hidden" id="post" name="post" value="<?= $post->getId() ?>">
                <div class="text-center">
                    <button class="button button--blue" type="submit" name="commentForm">Comment</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>
