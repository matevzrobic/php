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

<!-- Prebrano iz seje ali iz baze ?   -->
<div class="container">
    <div class="row">
        <h1>Update Profile</h1>
        <br>
    </div>
    <div class = "row">
        <form action="<?= htmlspecialchars("update") ?>" method="post">
            <input type="hidden" name="do" value="add" />
            <input type="hidden" name="isConfirmed" value="<?php echo $_SESSION["user"]["isConfirmed"]?>">
            <input type="hidden" name="id" value="<?php echo $_SESSION["user"]["id"] ?>" ><br />
            Firstname: <input type="text" name="firstname" value="<?php echo $_SESSION["user"]["firstname"] ?>" ><br />
            Lastname: <input type="text" name="lastname" value="<?php echo $_SESSION["user"]["lastname"] ?>" ><br />
            Email: <input type="email" name="email" value="<?php echo $_SESSION["user"]["email"] ?>" ><br />
            Password: <input type="password" name="password" placeholder="Change password" ><br />
            <br>
            <?php if ($_SESSION["user"]["permission"] == 2) { ?>
            Street: <input type="text" name="street" value="<?php echo $_SESSION["user"]["street"] ?>" ><br />
            House Number: <input type="text" name="house_number" value="<?php echo $_SESSION["user"]["house_number"] ?>" ><br />
            Post: <input type="text" name="post" value="<?php echo $_SESSION["user"]["post"] ?>" ><br />
            Post Number: <input type="number" name="post_number" value="<?php echo $_SESSION["user"]["post_number"] ?>" ><br />
            <?php } else {?>
            <input type="hidden" name="street" value="">
            <input type="hidden" name="house_number" value="">
            <input type="hidden" name="post" value="">
            <input type="hidden" name="post_number" value="">
            <?php } ?>
            <input type="submit" value="Shrani" />
        </form>
    </div>
</div>

<!-- END FOR  -->

</body>



</body>
