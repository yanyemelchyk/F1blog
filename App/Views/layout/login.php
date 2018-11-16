<h2>Войти</h2>

<?php
if ($this->errorMsg) {
    foreach ($this->errorMsg as $message) {
        echo '<p class="error">' . $message . '</p>';
    }
}
?>

<form method="post" action="/auth/login">
    <fieldset>
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username"/><br />
        <label for="password">Пароль:</label>
        <input type="password" name="password" />
    </fieldset>
    <input type="submit" value="Войти" name="submit" />
</form>
