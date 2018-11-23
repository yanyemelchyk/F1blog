<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset= "utf-8" />
    <title>
        <?= $this->title ?>
    </title>
    <link rel="stylesheet" type = "text/css" href="/style.css" />
</head>

<body>
<div id="allcontent">
    <header>
        <h1><a href="<?= $this->url->to('article') ?>" title="F1 blog | На главную">F1 <span class="title">blog</span></a></h1>
    </header>

    <section>

        <?php include "./../App/Views/layout/$this->template" ?>

    </section>

    <aside>
        <ul>
            <?php if (isset($_SESSION['user'])): ?>
            <li><a href="<?= $this->url->to('auth/logout') ?>">Выйти</a></li>
            <?php else: ?>
            <li><a href="<?= $this->url->to('auth/login') ?>">Уже есть аккаунт? Войти</a></li>
            <li><a href="<?= $this->url->to('user/create') ?>">Регистрация</a></li>
            <?php endif ?>
            <li><a href="<?= $this->url->to('article/create') ?>">Добавить статью</a></li>
            <li><a href="<?= $this->url->to('user/show') ?>">Просмотреть профиль</a></li>
        </ul>
    </aside>

    <footer>
        <p>Formula 1 <span class="title">blog</span></p>
    </footer>
</div>
</body>
</html>
