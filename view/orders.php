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
        <h1>
            All orders
        </h1>
        <!--        Note:-->
        <!--        <ul>-->
        <!--            <li> New orders can be rejected or confirmed</li>-->
        <!--            <li> Confirmed orders can be cancelled</li>-->
        <!--        </ul>-->
        <br>
    </div>

    <div class="table-striped">
        <table class="table">

            <tr>
                <th>Date</th>
                <th>User id</th>
                <th>Order id</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($orders as $order){ ?>
                <tr>
                    <td><?php echo $order["date"] ?></td>
                    <td><?php echo $order["userid"] ?></td>
                    <td><?php echo $order["id"] ?></td>
                    <!-- fancy SQL ki nam da skupno ceno ven -->
                    <?php
                    $parameters = [
                        "id" => $order["id"]
                    ];
                    $price = 0;
                    $items = StoreDB::getOrderDetails($parameters);
                    //var_dump($items);
                    foreach ($items as $item){
                        $price = $price + $item["price"]*$item["quantity"];
                    }
                    echo "<td>". $price . "</td>"
                    ?>

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

                    <td>
                        <?php if($order["status"] == 0){ ?>
                                <form style ='float: left; padding: 5px;' action="<?= htmlspecialchars("orders/activate") ?>" method="post">
                                    <input type="hidden" name="do" value="2" />
                                    <input type="hidden" name="id" value="<?php echo $order['id']?>" >
                                    <input type="submit" value="Confirm" />
                                </form>

                                <form style ='float: left; padding: 5px;' action="<?= htmlspecialchars("orders/activate") ?>" method="post">
                                    <input type="hidden" name="do" value="1" />
                                    <input type="hidden" name="id" value="<?php echo $order['id']?>" >
                                    <input type="submit" value="Reject" />
                                </form>
                        <?php }
                        elseif($order["status"] == 1){
                                echo 'No possible actions';
                        }
                        elseif($order["status"] == 2){ ?>
                            <form action="<?= htmlspecialchars("orders/activate") ?>" method="post">
                                <input type="hidden" name="do" value= "3" />
                                <input type="hidden" name="id" value="<?php echo $order['id']?>" >
                                <input type="submit" value="Cancel" />
                            </form>
                        <?php }
                        else{
                            echo 'No possible actions';
                        } ?>
                    </td>
                </tr>
                <?php } ?>
        </table>
    </div>

</div>

<!-- END FOR  -->

</body>



</body>
