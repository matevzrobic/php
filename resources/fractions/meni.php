<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo BASE_URL . "home" ?>"><i class="fas fa-atlas fa-fw"></i>FRIDING</a>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="<?php echo BASE_URL . "home" ?>">Home <span class="sr-only">(current)</span></a></li>
                <!-- IF OSEBA JE ADMIN ALI UPRAVLJALEC -->
                <?php if(isset($_SESSION["user"]) && $_SESSION["user"]["permission"] == 0) {?>
                    <li><a href="<?php echo BASE_URL . "admin" ?>">Admin</a></li>
                <?php } if(isset($_SESSION["user"]) && $_SESSION["user"]["permission"] <= 1) {?>
                    <li><a href="<?php echo BASE_URL . "managment" ?>">Managment</a></li>
                    <li><a href="<?php echo BASE_URL . "customers" ?>">Customers</a></li>
                    <li><a href="<?php echo BASE_URL . "orders" ?>">Orders</a></li>
                <?php } if(isset($_SESSION["user"]) && $_SESSION["user"]["permission"] <= 2) {?>
                    <li><a href="<?php echo BASE_URL . "my-orders" ?>">My orders</a></li>
                <?php } ?>
                <!-- ENDIF -->
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li>
                <form class="form-inline" action="<?= htmlspecialchars(BASE_URL . "search/") ?>" method="get">
                    <input class="form-control" type="search"
                           <?php if (isset($searchString)) { ?>value="<?=$searchString?>" <?php } else { ?> placeholder="Search" <?php } ?>
                           name="searchString" aria-label="Search" style="margin-top: 4%; width:200%; margin-left:-120%">
                    <button class="btn btn-outline-success" type="submit" style="display: none;">Search</button>
                </form>
                </li>
                <?php if(isset($_SESSION["user"]) && $_SESSION["user"]["permission"] <= 2) {?>
                    <li><a href="<?php echo BASE_URL . "cart" ?>">Shooping Cart <i class="fa fa-cart-plus" aria-hidden="true"></i></a></li>
                <?php } ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $user_name ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo BASE_URL . "profile" ?>">View Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <?php
                            if($user_name != "Guest"){
                                echo '<li><a href='. (BASE_URL . "logout"). '>Log out</a></li>';
                            }
                            else{
                                echo '<li><a href='. (BASE_URL . "login"). '>Log in</a></li>';
                                echo '<li><a href='. (BASE_URL . "register"). '>Register</a></li>';
                            }
                        ?>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>