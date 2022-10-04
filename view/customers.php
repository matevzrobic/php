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

<?php include('resources/fractions/meni.php'); ?>

<div class="container">
    <div class="row">
        <h1>
            Add or modify users
        </h1>
        <br>
    </div>
    <div class="table-striped">
        <table class="table">

            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Adress</th>
                <th>Post</th>
                <th>Status</th>
                <th>Actions</th>
                <th></th>
            </tr>
            <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?php echo $user["id"] ?></td>
                    <td><?php echo $user["firstname"] ?> <?php echo $user["lastname"] ?></td>
                    <td><?php echo $user["email"] ?></td>
                    <td><?php echo $user["street"], ", ",$user["house_number"]?></td>
                    <td><?php echo $user["post_number"], ", ", $user["post"]  ?></td>
                    <td><?php if ($user["isDeleted"] == 0) {echo "ACTIVE";} else {echo "DELETED";} ?> </td>
                    <td>
                        <?php if ($user["isDeleted"] == 0){?>
                        <form action="<?= htmlspecialchars("costumers/activate") ?>" method="post">
                            <input type="hidden" name="id" value="<?php echo $user['id']?>" >
                            <input type="hidden" name="activate" value="<?php echo !$user['isDeleted']?>" >
                            <input type="submit" value="Delete" class="btn btn-danger"/>
                        </form>
                        <?php }else{ ?>
                            <form action="<?= htmlspecialchars("costumers/activate") ?>" method="post">
                                <input type="hidden" name="id" value="<?php echo $user['id']?>" >
                                <input type="hidden" name="activate" value="<?php echo !$user['isDeleted']?>" >
                                <input type="submit" value="Activate" class="btn btn-success"/>
                            </form>
                        <?php } ?>
                    </td>
                    <td>
                        <form action="<?= htmlspecialchars("customers/modify") ?>" method="post">
                            <input type="hidden" name="do" value="add" />
                            <input type="hidden" name="id" value="<?php echo $user["id"]?>" >
                            <input type="submit" value="Modify" class="btn btn-link"/>
                        </form>
                    </td>
                </tr>
            <?php } ?>
            

        </table>
        <a href="customers/modify">
            <button class="btn btn-link"><i class="fa-fw fas fa-plus"></i>&nbsp; Add new customer</button>
        </a>
    </div>
</div>

</body>
