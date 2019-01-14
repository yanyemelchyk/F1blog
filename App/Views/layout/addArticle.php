<p class="error"></p>

<form method="post" action="/article/create">
    <legend>Adding a new article</legend>
    <label for="title">Article title:</label>
    <input type="text" id="title" name="title"><br>

    <label for="content">The content of the article:</label>
    <textarea id="content" rows="15" cols="50" name="content"></textarea><br>

    <label for="image">An image:</label>
    <input type="file" id="image" name="image"><br>

    <button type="submit" name="submit">Add</button>
</form>


<script>
    $(document).ready(function () {
        $('form').submit(function () {
            $.ajax({
                url: this.action,
                type: this.method,
                cache: false,
                contentType: false,
                processData: false,
                data: new FormData(this),
            }).fail(function (jqXHR) {
                let error = JSON.parse(jqXHR.responseText);
                $('p.error').html(error.message);
            }).done(function () {
                location.href = '/';
            });
            return false;
        });
    });
</script>
