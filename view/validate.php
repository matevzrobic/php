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
    <div>
        <?php

        $encrypted_string = openssl_encrypt($id,"AES-128-ECB","123gesloidkvseenmije");

        $to = $email;
        $subject = 'Verification email';
        $header = 'From: frieading@gmail.com';
        $message = '

Thank you for signing up!
Your account has been created, the next step is to verify your email!
Verify your email here: http://localhost:8012' . BASE_URL . 'validate/?hash=' . $encrypted_string;



        if (mail($to, $subject, $message, $header)) {
            echo "Verification mail sent to $to.";
        } else {
            echo "Unvalid email adress";
        } ?>
    </div>
</body>
