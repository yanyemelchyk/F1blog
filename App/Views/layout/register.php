<h2>Регистрация</h2>
<p class="error"></p>
<form method="post" action="/user/create">
    <label for="username">Имя пользователя:</label>
    <input type="text" name="username"><br>
    <label for="password1">Пароль:</label>
    <input type="password" name="password1"><br>
    <label for="password2">Подтвердить пароль:</label>
    <input type="password" name="password2"><br>
    <button type="submit" name="submit">Создать аккаунт</button>
</form>

<script>
    $(document).ready(function () {
        $('form').submit(function () {
            $.ajax({
                url: this.action,
                type: this.method,
                dataType: 'json',
                data: $(this).serializeArray()
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
