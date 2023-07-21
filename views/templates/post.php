<?php
if (count($post) > 0) {
$post = $post[0];
?>
<div class="post-container">
    <h1 class="post-title"><?= $post->title ?></h1>
    <div class="post-content">
        <?= $post->content ?>
    </div>
    <?php
    } else {
        require_once BASE_DIR . '/views/templates/404.php';
    }
    ?>
</div>