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
<?php
    if($user == 0){
    $user_input['id'] = "";
    $user_input['firstname'] = "";
    $user_input['lastname'] = "";
    $user_input['email'] = "";
    $user_input['permission'] = 2;
    $user_input['adress'] = "";
    $user_input['isDeleted'] = 0;
    $user_input['password'] = "";
    $user_input['adress'] = "";
    $user_input['street'] = "";
    $user_input['house_number'] = "";
    $user_input['post'] = "";
    $user_input['post_number'] = "";
    $user_input['isConfirmed'] = "1";


        $modify = "new";
    }
    else{
    $user_input = $user;

    $modify = "modify";
    }
    ?>
<body>
<?php include ('resources/fractions/meni.php'); ?>
<div id="main" class="container">
    <div class="row">
        <div class="col-sm-6">
            <form action="<?= htmlspecialchars("modify/add") ?>" method="post">
                <input type="hidden" name="origin" value="seller" />
                <input type="hidden" name="do" value="<?php echo $modify ?>" />
                <input type="hidden" name="id"         value="<?php echo $user_input["id"]?>"/>
                <input type="hidden" name="permission" value="<?php echo $user_input["permission"]?>"/>
                <input type="hidden" name="isDeleted"  value="<?php echo $user_input["isDeleted"]?>"/>
                <input type="hidden" name="isConfirmed"  value="<?php echo $user_input["isConfirmed"]?>"/>
                Firstname: <input type="text" name="firstname" value="<?php echo $user_input["firstname"]?>"><br />
                Lastname: <input type="text" name="lastname" value="<?php echo $user_input["lastname"]?>"><br />
                Email: <input type="email" name="email" value="<?php echo $user_input["email"]?>"><br />
                Password: <input type="password" name="password" placeholder="Update password"><br />

                <input type="hidden" name="adressId" value="<?=$user_input["adress"]?>">
                Street: <input type="text" name="street" value="<?php echo $user_input["street"]?>"><br />
                House Number: <input type="text" name="house_number" value="<?php echo $user_input["house_number"]?>"><br />
                Post:   &nbsp; &nbsp; <input type="text" name="post" value="<?php echo $user_input["post"]?>"><br />
                Post Number: <input type="number" name="post_number" value="<?php echo $user_input["post_number"]?>"><br />
                <input type="submit" class="btn btn-success" value="Save" />
            </form>
            <br>
            <div>
                <a href="<?php echo BASE_URL . "customers" ?>">Cancel and go back</a>
            </div>
        </div>
    </div>




</div>
</body>
