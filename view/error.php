<!doctype html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include('config/css.php'); ?>
    <?php include('config/setup.php'); ?>
    <title> <?php echo $site_title; ?> ｜ <?= $book["title"] ?> </title>
</head>

<body>
<?php include ('resources/fractions/meni.php'); ?>

<div class="jumbotron text-center">
    <h2 class="text-danger"><?php echo $error; ?></h2>
</div>
</body>
