<!doctype html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include('config/css.php'); ?>
    <?php include('config/setup.php'); ?>
    <title> <?php echo $site_title; ?> ｜ <?php echo $page_title; ?> </title>
</head>


<body>

<?php include ('resources/fractions/meni.php'); ?>



<div class="jumbotron text-center">
    <h1>FRIDING</h1>
    <p>Buy the best books for the best prices !</p>
</div>
<!-- FOR ZANKA VEN IZ BAZE  -->


<?php
$vrstica = 0;

function button1() {
    echo "This is Button1 that is selected";
}

?>


<div class="container">
    <?php
    foreach ($books as $book):
    if (!$book["isDeleted"]):


    if($vrstica%4==0): ?>
        <div class="row">
    <?php endif; ?>

            <a href=<?php echo BASE_URL . "/article?id=". $book["id"]?>>
                <div class="col-sm-3">
                <h3><?= $book["title"] ?></h3>
                <p>Author: <?= $book["author"] ?> </p>
                <p class="show-one-line"><?= $book["description"] ?></p>
                <img src="<?= $book["img"] ?>" width="200" height="280">
                <p><b>Price: <?= $book["price"] ?></b></p>
            </a>

        </div>
    <?php if($vrstica%4==3): ?>
        </div>
    <?php
        endif;
        $vrstica++
    ?>
    <?php
    endif;
    endforeach;
    ?>

<?php

$method = filter_input(INPUT_SERVER, "REQUEST_METHOD", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($method == "POST") {
        $validationRules = [
            'do' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => [
                    // dopustne vrednosti spremenljivke do, popravi po potrebi
                    "regexp" => "/^(add_into_cart)$/"
                ]
            ],
            'id' => [
                'filter' => FILTER_VALIDATE_INT,
                'options' => ['min_range' => 0]
            ]
        ];

        $post = filter_input_array(INPUT_POST, $validationRules);

        if ($post["do"] == "add_into_cart") {
            try {
                $id = $post["id"];

                if (isset($_SESSION["cart"][$id])) {
                    $_SESSION["cart"][$id]++;
                } else {
                    $_SESSION["cart"][$id] = 1;
                }
            } catch (Exception $exc) {
                die($exc->getMessage());
            }

        }
    }
    ?>
</div>



</body>
