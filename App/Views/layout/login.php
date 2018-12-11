<h2>Войти</h2>
<p class="error"></p>
<form method="post" action="/auth/login">
    <fieldset>
        <label for="username">Имя пользователя:</label>
        <input type="text" name="username"><br>
        <label for="password">Пароль:</label>
        <input type="password" name="password">
    </fieldset>
    <button type="submit" name="submit">Войти</button>
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
                if (json.redirect) {
                    location.href = json.redirect;
                }
            });
            return false;
        });
    });
</script>
