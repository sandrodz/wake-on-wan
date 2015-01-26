<?php

    include("wow.class.php");

    $WoW = new WoW("wow.example.com","xx:xx:xx:xx:xx:xx","xxxx");
    $status = $WoW->wake_on_wan();

?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>

        <p><?php echo $status; ?></p>

    </body>
</html>