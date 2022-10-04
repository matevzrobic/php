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
    <div id="main" class="container">
        <form action="<?= htmlspecialchars("sellerModified") ?>" method="post">
            <input type="hidden" name="id"         value="<?php echo $seller["id"]?>"/>
            <input type="hidden" name="permission" value="<?php echo $seller["permission"]?>"/>
            <input type="hidden" name="isDeleted"  value="<?php echo $seller["isDeleted"]?>"/>
            <div class="form-group" style="width:15%">
                <label for="firstname">First name</label>
                <input type="text" class="form-control" id="firstname" name = "firstname" value="<?php echo $seller["firstname"] ?>">
            </div>
            <div class="form-group" style="width:15%">
                <label for="lastname">Last name</label>
                <input type="text" class="form-control" id="lastname" name = "lastname" value="<?php echo $seller["lastname"] ?>">
            </div>
            <div class="form-group" style="width:15%">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name = "email" value="<?php echo $seller["email"] ?>">
            </div>
            <div class="form-group" style="width:15%">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name = "password" placeholder="Change password">
            </div>
            <div class="form-group" style="width:15%">
                <label for="password">Certificate common name</label>
                <input type="text" class="form-control" id="certCN" name = "certCN" value="<?php echo $seller["certCN"] ?>">
            </div>
            <input type="submit" class="btn btn-success" value="Save" />
        </form>
        <br>
        <?php if ($seller["isDeleted"] == 0) { ?>
        <form action="<?= htmlspecialchars("sellerDeleted") ?>" method ="post">
            <input type="hidden" name="id" value="<?php echo $seller["id"]?>"/>
            <input type="submit" class="btn btn-danger" value="Delete seller">
        </form>
        <?php } else { ?>
        <form action="<?= htmlspecialchars("sellerDeleted") ?>" method ="post">
            <input type="hidden" name="id" value="<?php echo $seller["id"]?>"/>
            <input type="submit" class="btn btn-success" value="Activate seller">
        </form>
        <?php } ?>
    </div>
</body>
