<!doctype html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport"
         content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Dekanat</title>
</head>
<body>
<header>
   <style>
      body {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
      }

      header {
         background-color: #343434;
      }

      a {
         text-decoration: none;
      }

      nav a {
         color: #fff;
      }

      nav {
         display: flex;
         align-items: center;
         justify-content: space-between;
         height: 70px;
      }

      .container {
        margin-left: 200px; /* Отступ слева */
        margin-right: 200px; /* Отступ справа */
      }

      .Logo {
         font-size: 36px;
         color: #fff;
      }

      .nav-links {
         display: flex;
         gap: 80px;
         font-size: 20px;
      }

      .account {
         padding-left: 200px;
         font-size: 20px;
      }

      .account span {
         color: #fff;
      }

      footer {
         background: #343434;
         height: 110px;
         position: absolute;
         left: 0;
         bottom: 0;
         width: 100%; 
      }
   </style>
   <nav class="container">
      <div class="Logo"><p>DekanatPro</p></div>
      <div class="nav-links">
       <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
       </div>
       <div class="account">
       <?php
       if (!app()->auth::check()):
           ?>
           <a href="<?= app()->route->getUrl('/login') ?>">Войти в аккаунт</a>
           <span> | </span>
           <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация</a>
       <?php
else:
           ?>
            
           <a href="<?= app()->route->getUrl('/logout') ?>">Выйти из аккаунта(<?= app()->auth::user()->name ?>)</a>
       <?php
       endif;
       ?>
   </div>
   </nav>
</header>
<main class="container">
   <?= $content ?? '' ?>
</main>

<footer>

</footer>

</body>
</html>