<table>
    <tr><td class="label">Username:</td><td><?= htmlspecialchars($this->user->getUsername()) ?></td></tr>
    <tr><td class="label">Last name:</td><td><?= htmlspecialchars($this->user->getLastName()) ?></td></tr>
    <tr><td class="label">First name:</td><td><?= htmlspecialchars($this->user->getFirstName()) ?></td></tr>
    <?php if ($this->user->getPicture() !== NULL): ?>
    <tr><td class="label">Profile picture:</td><td><img src="<?= UPLOAD_PATH . $this->user->getPicture(); ?>" alt="Фото профиля" /></td></tr>
    <?php endif ?>
</table>
