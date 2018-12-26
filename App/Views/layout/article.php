<div id="<?= $this->article->getId() ?>" class="newsPage">
    <h2><?= htmlspecialchars($this->article->getTitle()) ?></h2>
    <p class="date"><?= $this->article->getDate() ?></p>
    <img src= "<?= '/' . UPLOAD_PATH . '/' . $this->article->getImage() ?>" title="<?= htmlspecialchars($this->article->getTitle()) ?>">
    <p><?= htmlspecialchars($this->article->getContent()) ?></p>
</div>
<p class="error"></p>

<?php if ($this->user) : ?>
    <div class="comment">
        <form action="/comment/create" method="post">
            <legend>What do you think, <?= $this->user->getUsername() ?>?</legend>
            <input type="hidden" name="username" value="<?= $this->user->getUsername() ?>">
            <input type="hidden" name="articleId" value="<?= $this->article->getId() ?>">
            <textarea rows="4" cols="75" name="textComment"></textarea>
            <button type="submit">Add</button>
        </form>
    </div>
<?php else : ?>
    <p><a href="<?= $this->router->getUrl('authMain') ?>">Sign in</a></p>
<?php endif; ?>

<div id="discuss">DISCUSSION</div>
<div id="commentsContainer"></div>

<script>
    $(document).ready(function () {
        show();
        setInterval("show()", 10000);
        $('form').submit(function () {
            $.ajax({
                url: this.action,
                type: this.method,
                data: $(this).serializeArray()
            }).done(function () {
                $('textarea').val('');
                $('p.error').html('');
            }).fail(function (jqXHR) {
                let error = JSON.parse(jqXHR.responseText);
                $('p.error').html(error.message);
            });
            return false;
        });
    });

    function show()
    {
        let articleId = $('.newsPage').attr('id');
        let excludeIds = $('#commentsContainer div').map(function () {
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
