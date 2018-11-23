<div class="newsPage">
    <h2><?= htmlspecialchars($this->article->getTitle()) ?></h2>
    <p class="date"><?= $this->article->getDate() ?></p>
    <img src= "<?= UPLOAD_PATH . $this->article->getImage() ?>" title="<?= htmlspecialchars($this->article->getTitle()) ?>">
    <p><?= htmlspecialchars($this->article->getContent()) ?></p>
</div>

<?php if (isset($_SESSION['user'])) : ?>
<div class="comment">
    <form name="comment" action="/article/show/id/<?= $this->article->getId() ?>" method="post">
        <legend>Ваше мнение, <?= $this->user->getUsername() ?>?</legend>
        <textarea rows="5" cols="75" name="textComment"></textarea>
        <input id="submit" type="submit" value="Добавить">
    </form>
</div>
<?php else : ?>
<p>Чтобы оставить комментарий Вам необходимо <a href="<?= $this->url->to('auth/login') ?>">войти</a> или <a href="<?= $this->url->to('user/create') ?>">зарегистрироваться</a></p>
<?php endif;

foreach ($this->errorMsg as $message) : ?>
<p class="error"><?= $message ?></p>
<?php endforeach; ?>

<div id="discuss">ОБСУЖДЕНИЕ</div>
<?php foreach ($this->comments as $comment) : ?>
<div class="comments">
    <table>
        <tr><td><b><?= htmlspecialchars($comment->getUsername()) ?></b></td></tr>
        <tr><td><?= htmlspecialchars($comment->getTextComment()) ?></td></tr>
    </table>
</div>
<?php endforeach; ?>
