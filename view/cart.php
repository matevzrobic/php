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
    <h1>Shoping Cart</h1>
</div>

<?php
/*
var_dump($_SESSION["cart"]);
var_dump($_POST["do"]);
*/
?>
<!-- List of books with prices  -> Preberemo iz seje -->

<?php
$skupna_cena = 0;
if (isset($_SESSION["cart"]) && sizeof($_SESSION["cart"])>0){
    foreach ($_SESSION["cart"] as $knjiga => $stevilo):
    $knjiga = $knjiga-1;
    $skupna_cena += $books[$knjiga]["price"] * $stevilo;
?>
<div class="container">
    <div class="row">
        <div class="col-sm-1">
            <img src="<?= $books[$knjiga]["img"] ?>" width="60" height="90">
        </div>
        <div class="col-sm-5">
            <p>
                <b> <?= $books[$knjiga]["title"] ?> :</b> <?= $books[$knjiga]["description"] ?>
            </p>
        </div>
        <div class="col-sm-3">
            <p>Number: <?= $stevilo ?></p>
            <p>Price: <?= $books[$knjiga]["price"] * $stevilo ?></p>
        </div>
        <div class="col-sm-2">
            <form action="<?= $url . "/update" ?>" method="post">
                <input type="hidden" name="do" value="add_into_cart" />
                <input type="hidden" name="id" value="<?= $books[$knjiga]["id"] ?>" />
                <button type="submit"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </form>
            <form action="<?= $url . "/update" ?>" method="post">
                <input type="hidden" name="do" value="remove_from_cart" />
                <input type="hidden" name="id" value="<?= $books[$knjiga]["id"] ?>" />
                <button type="submit"> <i class="fa fa-minus" aria-hidden="true"></i></button>
            </form>

        </div>
    </div>

    <br>
    <?php
    endforeach;
    ?>
    Total price: <?=$skupna_cena?> €
    <br>


        <?php
        if(isset($_SESSION["user"])){
        ?>
            <a href="<?php echo BASE_URL . "checkout" ?>" >
                <button>BUY DEM BOOKS</button>
            </a>
            <?php
        }
        else {
            echo "<h3>Please login to complete your purchase</h3>";
        }


    }
    else{
        echo "<h1> Kosarica je prazna </h1>";
    }
    ?>


</div>


</body>
