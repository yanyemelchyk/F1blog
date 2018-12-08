<?php foreach ($this->errors as $error) : ?>
<p class="error"><?= $error ?></p>
<?php endforeach; ?>

<form enctype="multipart/form-data" method="post" action="/article/create">
    <legend>Добавление новой статьи</legend>
    <label for="title">Заголовок статьи:</label>
    <input type="text" id="title" name="title"><br>
    <label for="content">Содержание статьи:</label>
    <textarea id="content" rows="15" cols="50" name="content"></textarea><br>
    <label for="image">Фото:</label>
    <input type="file" id="image" name="image"><br>
    <input type="submit" value="Добавить" name="submit">
</form>
