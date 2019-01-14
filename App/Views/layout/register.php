<h2>Register</h2>
<p class="error"></p>
<form method="post" action="/user/create">
    <label for="username">Username:</label>
    <input type="text" name="username"><br>
    <label for="password1">Password:</label>
    <input type="password" name="password1"><br>
    <label for="password2">Password confirmation:</label>
    <input type="password" name="password2"><br>
    <button type="submit" name="submit">Create an account</button>
</form>

<script>
    $(document).ready(function () {
        $('form').submit(function () {
            $.ajax({
                url: this.action,
                type: this.method,
                data: $(this).serializeArray()
            }).fail(function (jqXHR) {
                let error = JSON.parse(jqXHR.responseText);
                $('p.error').html(error.message);
            }).done(function () {
                location.href = '/auth/index';
            });
            return false;
        });
    });
</script>
