<div class="newsPage">
    <h2><?= htmlspecialchars($this->article->getTitle()) ?></h2>
    <p class="date"><?= $this->article->getDate() ?></p>
    <img src= "<?= UPLOAD_PATH . $this->article->getImage() ?>" title="<?= htmlspecialchars($this->article->getTitle()) ?>">
    <p><?= htmlspecialchars($this->article->getContent()) ?></p>
</div>

<?php if (isset($_SESSION['userId'])) : ?>
<div class="comment">
    <form name="comment" action="/article/index/id/<?=$this->article->getArticleId() ?>" method="post">
        <legend>Ваше мнение, <?php echo $_SESSION['username'] ?>?</legend>
        <input type="hidden" name="username" value="<?php echo $_SESSION['username'] ?>" />
        <textarea rows="5" cols="75" name="textComment"></textarea>
        <input type="hidden" name="articleId" value="<?= $this->article->getArticleId() ?>" />
        <input id="submit" type="submit" value="Добавить" />
    </form>
</div>
<?php else : ?>
<p>Чтобы оставить комментарий Вам необходимо <a href="<?= $this->url->to('auth/login') ?>">войти</a> или <a href="<?= $this->url->to('register') ?>">зарегистрироваться</a></p>
<?php endif;

if ($this->errorMsg) {
    foreach ($this->errorMsg as $message) {
        echo '<p class="error">' . $message . '</p>';
    }
}
?>

<div id="discuss">ОБСУЖДЕНИЕ</div>
<?php foreach ($this->comments as $comment) : ?>
<div class="comments">
    <table>
        <tr><td><b><?= htmlspecialchars($comment->getUsername()) ?></b></td></tr>
        <tr><td><?= htmlspecialchars($comment->getTextComment()) ?></td></tr>
    </table>
</div>
<?php endforeach; ?>
