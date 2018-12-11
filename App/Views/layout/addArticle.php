<p class="error"></p>
<form enctype="multipart/form-data" method="post" action="/article/create">
    <legend>Добавление новой статьи</legend>
    <label for="title">Заголовок статьи:</label>
    <input type="text" id="title" name="title"><br>
    <label for="content">Содержание статьи:</label>
    <textarea id="content" rows="15" cols="50" name="content"></textarea><br>
    <label for="image">Фото:</label>
    <input type="file" id="image" name="image"><br>
    <button type="submit" name="submit">Добавить</button>
</form>

<script>
    $(document).ready(function () {
        $('form').submit(function () {
            var data = new FormData();
            var fileData = $('#image').files[0];
            data.append('image', fileData);
            $.ajax({
                url: this.action,
                type: this.method,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                data: data
            }).done(function (json) {
                $('p.error').html(json.message);
                if (json.success) {
                    $('input').val('');
                }
            });
            return false;
        });
    });
</script>
