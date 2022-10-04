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
            Add or modify book
        </h1>
        <br>
    </div>

    <div class="table-striped">
        <table class="table">

            <tr>
                <th>Picture</th>
                <th>Title</th>
                <th>Author</th>
                <th>Description</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

        <?php
            foreach ($books as $book){

        ?>

            <tr>
                <td> <img src="<?php echo $book["img"]?>" width="50" height="70" >  </td>
                <td><?php echo $book["title"] ?></td>
                <td><?php echo $book["author"] ?></td>
                <td><?php echo $book["description"] ?></td>
                <td><?php echo $book["price"] ?></td>

      <!--          <td><?php //echo $book["status"] ?></td> -->
                <td>
                    <form action="<?= htmlspecialchars("managment/modify") ?>" method="post">

                        <input type="hidden" name="do" value="deactivate" />
                        <input type="hidden" name="id" value="<?php echo $book['id']?>" >
                        <input type="hidden" name="delete" value="<?php echo !$book['isDeleted']?>" />
                        <?php
                        if($book['isDeleted']) {
                            echo '<input type="submit" value="Activate" />';
                        }
                        else{
                            echo '<input type="submit" value="Deactivate" />';
                        }
                        ?>


                    </form>
                </td>
                <td>
                <form action="<?= htmlspecialchars("managment/modify") ?>" method="post">
                    <input type="hidden" name="do" value="modify" />
                    <input type="hidden" name="id" value="<?php echo $book['id']?>" >
                    <input type="submit" value="Modify" />
                </form>
                </td>
            </tr>

        <?php
            }

        ?>
        </table>
    </div>
<a href="managment/modify">
    <button><i class="fas fa-plus"></i>Add new book</button>
</a>

</div>

<!-- END FOR  -->

</body>



</body>
