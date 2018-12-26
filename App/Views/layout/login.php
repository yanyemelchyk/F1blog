<h2>Sign in</h2>
<p class="error"></p>
<form method="post" action="/auth/login">
    <fieldset>
        <label for="username">Username:</label>
        <input type="text" name="username"><br>
        <label for="password">Password:</label>
        <input type="password" name="password">
    </fieldset>
    <button type="submit" name="submit">Sign in</button>
</form>

<script>
    $(document).ready(function () {
        $('form').submit(function () {
            $.ajax({
                url: this.action,
                type: this.method,
                data: $(this).serializeArray()
            }).done(function () {
                location.href = '/';
            }).fail(function (jqXHR) {
                let error = JSON.parse(jqXHR.responseText);
                $('p.error').html(error.message);
            });
            return false;
        });
    });
</script>
