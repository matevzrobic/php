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

<?php if(isset($_SESSION["user"]) && !is_null($_SESSION["user"]["certCN"])) { ?>
    <div class="banner-info"> You are certified as <?php echo $_SESSION["user"]["certCN"] ?> </div>
<?php }?>
<!-- Prebrano iz seje ali iz baze ?   -->
<div class="container">
    <div class="row">
        <h1>Profile info.</h1>
        <br>
    </div>


    <?php if(isset($_SESSION["user"])){ ?>
    <div class = "row">
        <p>Name:  <?php echo $_SESSION["user"]["firstname"] ?></p>
        <p>Surname: <?php echo $_SESSION["user"]["lastname"] ?></p>
        <p>email: <?php echo $_SESSION["user"]["email"] ?></p>
        <br>
        <?php if ($_SESSION["user"]["permission"] == 2) { ?>
        <h4>Adress</h4>
        <p>Street: <?php echo $_SESSION["user"]["street"] ?></p>
        <p>House Number: <?php echo $_SESSION["user"]["house_number"] ?></p>
        <p>Post: <?php echo $_SESSION["user"]["post"] ?></p>
        <p>Post Number: <?php echo $_SESSION["user"]["post_number"] ?></p>
        <?php } ?>
        <hr>
    </div>
    <div class = "row">
        <p>Permissions: <?php echo $_SESSION["user"]["permission"] ?></p> <br>
    </div>
    <?php }else{ ?>
        <p> Please register first </p>
    <?php } ?>

    <a href="profile/update" >
        <button>
            Update user information
        </button>
    </a>
</div>

<!-- END FOR  -->

</body>



</body>
