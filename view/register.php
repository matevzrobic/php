<!doctype html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6Lc2qQoaAAAAAPGDBB8BCK0SShMjr7rX2x5dAoCX"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('6Lc2qQoaAAAAAPGDBB8BCK0SShMjr7rX2x5dAoCX', { action: 'contact' }).then(function (token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>

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
            Thanks for registering with us
        </h1>
        <br>
    </div>
    <hr>
    <div class = "row">
        <h1>Dodajanje</h1>
        <form action="<?= htmlspecialchars("register") ?>" method="post">
            <input type="hidden" name="do" value="add" />
            <label for="firstname">Firstname: </label> <input type="text" name="firstname" ><br />
            <label for="lastname">Lastname: </label> <input type="text" name="lastname" ><br />
            <label for="email">Email:  </label><input type="email" name="email" ><br />
            <label for="password">Password:  </label><input type="password" name="password" ><br />

            <label for="street">Street:  </label><input type="text" name="street" ><br />
            <label for="house_number">House Number:  </label><input type="text" name="house_number" ><br />
            <label for="post">Post: </label> <input type="text" name="post" ><br />
            <label for="post_number">Post Number: </label> <input type="number" name="post_number" ><br />
            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">

            <input type="submit" value="Shrani" />
        </form>
    </div>
</div>

<!-- END FOR  -->

</body>



</body>
