<h2>Войти</h2>

<?php
//todo if u know  that errors always exist and it is array u can skip if - perform refactoring in all view files.
//if u dont know exist it or not do this
/*
 * if (!isset($this->errorMsg)) {
 *      $this->errorMsg = [];
 * }
 *
 */



//if ($this->errorMsg) {
    foreach ($this->errorMsg as $message) {
        echo '<p class="error">' . $message . '</p>';
    }
//}
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
