<h2>Войти</h2>

<?php foreach ($this->errorMsg as $message) : ?>
<p class="error"><?= $message ?></p>
<?php endforeach; ?>

<form method="post" action="/auth/login">
    <fieldset>
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username"><br>
        <label for="password">Пароль:</label>
        <input type="password" name="password">
    </fieldset>
    <input type="submit" value="Войти" name="submit">
</form>
