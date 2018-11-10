<h2>Войти</h2>

<?= '<p class="error">' . $this->errorMsg . '</p>' ?>

<?php if (empty($_SESSION['userId'])): ?>

<form method="post" action="/auth/login">
    <fieldset>
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username"/><br />
        <label for="password">Пароль:</label>
        <input type="password" name="password" />
    </fieldset>
    <input type="submit" value="Войти" name="submit" />
</form>

<?php else: ?>
<p class="login">Вы вошли как <?= $_SESSION['username'] ?></p>
<?php endif ?>