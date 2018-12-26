<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset= "utf-8" />
    <title><?= $this->title ?></title>
    <script
            src="http://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" type = "text/css" href="/style.css" />
</head>

<body>
<div id="allcontent">
    <header>
        <h1><a href="<?= $this->router->getUrl('home') ?>">F1 <span class="title">blog</span></a></h1>
    </header>
    <section>
        <?php include "./../App/Views/layout/$this->template" ?>
    </section>
    <aside>
        <ul>
            <?php if ($this->user): ?>
            <li><a href="<?= $this->router->getUrl('logout') ?>">Sign out</a></li>
            <?php else: ?>
            <li><a href="<?= $this->router->getUrl('authMain') ?>">Sign in</a></li>
            <li><a href="<?= $this->router->getUrl('createUser') ?>">Register</a></li>
            <?php endif ?>
            <li><a href="<?= $this->router->getUrl('createArticle') ?>">Add an article</a></li>
            <li><a href="<?= $this->router->getUrl('showProfile') ?>">My profile</a></li>
        </ul>
    </aside>

    <footer>
        <p>Formula 1 <span class="title">blog</span></p>
    </footer>
</div>
</body>
</html>
