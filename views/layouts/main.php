<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Facebook</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">SystemTest</a>
        <ul class="navbar-nav me-auto mb-4 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/">Home</a>
            </li>
            <?php

            use app\core\Application;

            if (!Application::$app->isGuest()): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/crypto">Crypto</a>
                </li>
            <?php
            endif; ?>
        </ul>
        <?php

        if (Application::$app->isGuest()): ?>
        <ul class="navbar-nav me-2 mb-4 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/login">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="/register">Register</a>
            </li>
            <?php
            else: ?>
            <ul class="navbar-nav me-2 mb-4 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="/logout">Log Out</a>
                </li>
                <?php
                endif; ?>

    </div>
</nav>
<div class="container" style="max-width: 600px; width: 100%; margin-top: 50px;">
    {{content}}
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
</body>
</html>