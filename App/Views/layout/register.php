<h2>Регистрация</h2>

<?php
if ($this->errorMsg) {
    foreach ($this->errorMsg as $message) {
        echo '<p class="error">' . $message . '</p>';
    }
}
?>

<form method="post" action="/register">
    <label for="username">Имя пользователя:</label>
    <input type="text" name="username" /><br />
    <label for="password1">Пароль:</label>
    <input type="password" name="password1" /><br />
    <label for="password2">Подтвердить пароль:</label>
    <input type="password" name="password2" /><br />
    <input type="submit" value="Создать аккаунт" name="submit" />
</form>
