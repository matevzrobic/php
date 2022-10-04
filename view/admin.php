<!doctype html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include('config/css.php'); ?>
    <?php include('config/setup.php'); ?>
    <title>  echo $site_title; ?> ｜ <?php echo $page_title; ?> </title>
    <script src="../resources/js/admin.js"></script>
</head>

<body>
    <?php include ('resources/fractions/meni.php'); ?>

    <div id="main" class="container">
        <h1>
            Add or modify sellers
        </h1>
        <br>
        <div class="table">
            <table class="table table-striped center" style="margin-left: auto; margin-right: auto">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email adress</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                <?php foreach ($sellers as $seller) { ?>
                <tr>
                    <td><?php echo $seller["id"] ?></td>
                    <td><?php echo $seller["firstname"] ?> <?php echo $seller["lastname"] ?></td>
                    <td><?php echo $seller["email"] ?></td>
                    <td><?php if ($seller["isDeleted"] == 0) {echo "ACTIVE";} else {echo "DELETED";} ?> </td>
                    <td><form action="<?= htmlspecialchars("admin/modifySeller") ?>" method="post">
                        <input type="hidden" name="id" value="<?php echo $seller['id']?>" >
                        <input type="submit" value="Edit seller" class="btn btn-info"/>
                        </form></td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <button id="blockHide" onclick="openTable()" class="btn btn-dark float-right" style=" margin: 30px;margin-right: 70px">Add seller</button>
        <table class="table table-striped table-responsive" style="width: 90%; margin: 30px; display:none" id="openTable">
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Certificate</th>
                <th></th>
            </tr>
            <form method="post" action="" id="addSeller">
                <tr>
                    <td><input type="text" name="firstname" class="form-control form-control-sm"></td>
                    <td><input type="text" name="lastname" class="form-control form-control-sm"></td>
                    <td><input type="text" name="email" class="form-control form-control-sm"></td>
                    <td><input type="text" name="password" class="form-control form-control-sm"</td>
                    <td><input type="text" name="certCN" class="form-control form-control-sm"</td>
                    <input type="hidden" name="permission" value="1">
                    <input type="hidden" name="isDeleted" value="0">
                    <td><input  type="submit" class="btn btn-success" value="Add seller"></td>
                </tr>
            </form>
        </table>
    </div>
</body>