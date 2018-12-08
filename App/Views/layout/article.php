<div class="newsPage">
    <h2><?= htmlspecialchars($this->article->getTitle()) ?></h2>
    <p class="date"><?= $this->article->getDate() ?></p>
    <img src= "<?= UPLOAD_PATH . $this->article->getImage() ?>" title="<?= htmlspecialchars($this->article->getTitle()) ?>">
    <p><?= htmlspecialchars($this->article->getContent()) ?></p>
</div>

<?php foreach ($this->errors as $error) : ?>
<p class="error"><?= $error ?></p>
<?php endforeach; ?>

<div id="results"></div>

<?php if (isset($_SESSION['user'])) : ?>
<div class="comment">
    <form id="addComment "name="comment" action="/comment/create" method="post">
        <legend>Ваше мнение, <?= $this->user->getUsername() ?>?</legend>
        <input type="hidden" name="username" value="<?= $this->user->getUsername() ?>" />
        <input id="articleId" type="hidden" name="articleId" value="<?= $this->article->getId() ?>" />
        <textarea rows="4" cols="75" name="textComment"></textarea>
        <input type="submit" value="Добавить">
    </form>
</div>
<?php else : ?>
<p>Чтобы оставить комментарий Вам необходимо <a href="<?= $this->url->to('auth/login') ?>">войти</a> или <a href="<?= $this->url->to('user/create') ?>">зарегистрироваться</a></p>
<?php endif; ?>

<div id="discuss">ОБСУЖДЕНИЕ</div>
<div id="commentsContainer"></div>
<?= $this->message ?? ''; ?>

<script>
    $(document).ready(function () {
        show();
        setInterval("show()", 10000);
        $('form').submit(function () {
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                dataType: 'json',
                data: $(this).serializeArray()
            }).done(function (json) {
                $('#results').html(json.message);
                if (json.success) {
                    $('textarea').val('');
                }
            });
            return false;
        });
    });

    function show()
    {
        var articleId = $('#articleId').val();
        var excludeIds = $('#commentsContainer div').map(function () {
            return $(this).attr('id');
        }).get();

        $.ajax({
            url: '/comment/show',
            dataType: 'json',
            data: { articleId: articleId, excludeIds: excludeIds },
            type: 'POST'
        }).done(function (json) {
            $.each(json.comments, function () {
                $('#commentsContainer').append('<div id="'+this.id+'"><p>'+this.username+'</p><p>'+this.textComment+'</p></div>');
            });
        });
    }
</script>
