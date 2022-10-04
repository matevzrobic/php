<!doctype html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include('config/css.php'); ?>
    <?php include('config/setup.php'); ?>
    <title> <?php echo $site_title; ?> ď˝ś <?php echo $page_title; ?> </title>


</head>

<body>
<?php include ('resources/fractions/meni.php'); ?>

<div class="container">
    <div class="row">
        <h1>
            My book orders
        </h1>
        <br>
    </div>
    <div class="table-striped">
        <table class="table">
            <tr>
                <th>Date</th>
                <th>Order id</th>
                <th>Status</th>
            </tr>
            <?php foreach ($orders as $order){ ?>
                <tr>
                    <td><?php echo $order["date"] ?></td>
                    <td><?php echo $order["id"] ?></td>
                    <?php
                    if($order["status"] == 0){
                        echo '<td>New order</td>';
                    }
                    elseif($order["status"] == 1){
                        echo '<td>Rejected</td>';
                    }
                    elseif($order["status"] == 2){
                        echo '<td>Confirmed</td>';
                    }
                    else{
                        echo '<td>Cancelled</td>';
                    }
                    ?>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>