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
    <h1><h3><?= $book["title"] ?></h3></h1>
</div>
<!-- FOR ZANKA VEN IZ BAZE  -->

<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <img src="<?= $book["img"]?>" width="200" height="280">
            </div>
            <br>
            <div class="row">
                <form action="<?= htmlspecialchars(BASE_URL . "/cart/update") ?>" method="post">
                    <input type="hidden" name="do" value="add_into_cart" />
                    <input type="hidden" name="id" value="<?= $book["id"] ?>" />
                    <input class="btn btn-info" type="submit" value="Add to cart" />
                </form>
            </div>
        </div>
        <div class="col-sm-8">
            <ul>
                <li>Title: <?= $book["title"] ?> </li>
                <li>Author: <?= $book["author"] ?></li>
                <li>Description: <?= $book["description"] ?></li>
                <li>Price: <?= $book["price"] ?></li>
                <li>Customer rating: <?php if($rating["rating"] > 0) echo sprintf("%.1f", $rating["rating"]); else echo "No customer has rated this product yet"; ?>
                <hr/>
                <?php if ( isset($_SESSION["user"]["permission"]) && $_SESSION["user"]["permission"] == 2) { ?>
                <div>
                    <form action="<?= htmlspecialchars(BASE_URL . "rate") ?>" method="post">
                        <input type="hidden" name="bookid" value="<?= $book["id"] ?>" >
                        <input type="hidden" name="userid" value="<?= $_SESSION["user"]["id"] ?>" >
                        <label for="rating">Rate the product</label>
                        <select name="rating">
                            <option value="1" selected>1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        <button type="submit" >Rate!</button>
                    </form>
                </div>
                <?php } ?>
                <hr>
                <div>
                    <?php
                    foreach ($book['images'] as $image) {

                        echo '<img src="data:image/jpeg;base64,'.base64_encode( $image["imgblob"] ).'"/>';
                    } ?>
                </div>
                <hr>
            </ul>
        </div>
    </div>

</div>



</body>
