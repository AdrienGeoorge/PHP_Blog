<?php
$i = $nbIteration = 0;
?>

<h1 class="mb-1">My posts (<?= count($posts) ?>)</h1>
<section class="lastPost">
    <?php if (empty($posts)): ?>
        <h2>There are no posts</h2>
    <?php else: ?>
        <?php while ($i < count($posts)): ?>
            <div class="lastPosts__row">
                <?php for ($numPost = $i; $numPost < $i + 2; $numPost++):
                    if (isset($posts[$numPost])): ?>
                        <a href="<?= ROOT . '/post/show/' . $posts[$numPost]->getId() ?>"
                           class="lastPosts__row__block <?= $numPost % 3 == 0 ? "lastPosts__row__block--large" : "" ?>"
                           style="background-image: url('<?= empty($posts[$numPost]->getImage()) ? ROOT . '/assets/images/no_images.png' : ROOT . '/' . $posts[$numPost]->getImage()[1] ?>');">
                            <div class="button button--blue mt-1 edit--btn"
                                 data-id="<?= $posts[$numPost]->getId() ?>">
                                Edit post
                            </div>
                            <div class="textBlock">
                                <div class="centeredText">
                                    <h1 class="textBlock--title"><?= $posts[$numPost]->getTitle() ?></h1>
                                    <p class="textBlock--description">
                                        <b><?= $posts[$numPost]->getCategory() ?></b>
                                    </p>
                                </div>
                            </div>
                        </a>
                    <?php endif;
                endfor; ?>
            </div>
            <?php $i += 2;
            $nbIteration++;
        endwhile;
    endif; ?>
</section>
<script>
    const buttons = document.querySelectorAll('.edit--btn');

    for (const button of buttons) {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            location = '<?= ROOT . '/post/update/' ?>' + button.getAttribute('data-id');
        });
    }
</script>
