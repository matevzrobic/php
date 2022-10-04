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



<!-- FOR ZANKA VEN IZ BAZE  -->


<div class="container">
    <div class="row">
        <form action="<?= htmlspecialchars(BASE_URL . "login") ?>" method="post">
            <input type="hidden" name="do" value="login" />
            Email: <input type="text" name="email" ><br />
            Password: <input type="password" name="password" ><br />
            <input type="submit" value="Shrani" />
            <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
        </form>
        <span class="text-danger"><?php echo $msg ?></span>
    </div>

    <div class="row">
        <?php if(!isset($_SERVER["HTTPS"])) {?>
        <a href='<?php echo "https://localhost/_GIT/EP_seminar/index.php/login" ?>'> Switch to HTTPS and apply certificate. </a>
        <?php } else {?>
            <p class="text-info"> You are on secure connection.</p>
        <?php } ?>
    </div>

</div>





</body>
