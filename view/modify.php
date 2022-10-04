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

<?php



if($book == 0){
    $book1['id'] = "";
    $book1['title'] = "";
    $book1['author'] = "";
    $book1['price'] = "";
    $book1['description'] = "";
    $book1['img'] = "";

    $modify = "new";
}
else{
    $book1 = $book;

    $modify = "modify";
}
?>

<!-- Prebrano iz seje ali iz baze ?   -->
<div class="container">
    <div class="row">
        <h1>
            Add/Modify
        </h1>
        <br>
    </div>
    <hr>
    <div class = "row">
        <form action="<?= htmlspecialchars("modify/add") ?>" method="post">
            <input type="hidden" name="do" value="<?php echo $modify ?>" />
            <input type="hidden" name="id" value="<?php echo $book1['id']?>"  />
            Title: <input type="text" name="title" value="<?php echo $book1['title'] ?>" ><br />
            Author: <input type="text" name="author" value="<?php echo $book1['author'] ?> "><br />
            Price: <input type="number" name="price" value="<?php echo $book1['price'] ?>" ><br />
            Description: <br>
            <textarea rows="8" cols="60" name="description"> <?php echo $book1['description'] ?> </textarea><br/>
            Img Url: <input type="text" name="img" value="<?php echo $book1['img'] ?>" ><br />
            <input type="submit" value="Save" />
        </form>
    </div>
    <hr>
    <div>
        <?php
        if (isset($book1['images'])) {
            foreach ($book1['images'] as $image) {

                echo '<img src="data:image/jpeg;base64,' . base64_encode($image["imgblob"]) . '"/>';
                echo '<form  style="margin: 0; padding: 0;" action="delete-image" method="post"> <p>'
                    . '<input type="hidden" value="' . $image["id"] . '" name="id">'
                    . '<input type="submit" value="Delete">'
                    . '</p> </form>';

            }
        }?>
    </div>
    <hr>
    <div class = "row">
        <form action="<?= htmlspecialchars("image") ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="bookId" value="<?php echo $book1['id']?>"  />
            <label for="myfile">Select an image:  </label>
            <input class="btn btn-info" id="myfile" type="file" name="myfile">
            <br>
            <input type="submit" value="Add selected image" class="btn btn-secondary"/>
        </form>
    </div>


</div>

<!-- END FOR  -->

</body>



</body>
