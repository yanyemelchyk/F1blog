<?php foreach ($this->articles as $article) : ?>
<article>
    <img src= "<?= '/' . UPLOAD_PATH . '/' . $article->getImage() ?>" title="<?= htmlspecialchars($article->getTitle()) ?>">
    <h2><a href="<?= $this->router->getUrl('article', ['id' => $article->getId()]) ?>"><?= htmlspecialchars($article->getTitle()) ?></a></h2>
    <p class="date"><?= $article->getDate() ?></p>
    <p class="preview"><?= htmlspecialchars(mb_substr($article->getContent(), 0, 200)) ?>...</p>
</article>
<?php endforeach ?>
