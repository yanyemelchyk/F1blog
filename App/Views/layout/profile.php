<table>
    <tr><td class="label">Логин:</td><td><?= htmlspecialchars($this->user->getUsername()) ?></td></tr>
    <tr><td class="label">Фамилия:</td><td><?= htmlspecialchars($this->user->getLastName()) ?></td></tr>
    <tr><td class="label">Имя:</td><td><?= htmlspecialchars($this->user->getFirstName()) ?></td></tr>
    <?php if ($this->user->getPicture() !== NULL): ?>
    <tr><td class="label">Фото профиля:</td><td><img src="<?= UPLOAD_PATH . $this->user->getPicture(); ?>" alt="Фото профиля" /></td></tr>
    <?php endif ?>
</table>