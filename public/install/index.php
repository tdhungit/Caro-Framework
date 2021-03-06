<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 8/11/2015
 * Time: 3:47 PM
 * Project: carofw
 * File: index.php
 */

define('APP_PATH', str_replace('public', '', realpath('..')));

if (!empty($_POST)) {
    $db_host = $_POST['dbhost'];
    $db_user = $_POST['dbusername'];
    $db_pwd = $_POST['dbpassword'];
    $db_name = $_POST['dbname'];

    $user_name = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    $user_password2 = $_POST['password2'];

    $baseurl = $_POST['baseurl'];
    $backendprefix = $_POST['backendprefix'];
    $pagetitle = $_POST['pagetitle'];

    //print_r($_POST);

    if ($db_host && $db_user && $db_name
        && $user_name && $user_email && $user_password && $user_password2
        && $baseurl && $backendprefix && $pagetitle
    ) {
        if ($user_password == $user_password2) {
            // Create connection
            $conn = new mysqli($db_host, $db_user, $db_pwd, $db_name);
            // Check connection
            if ($conn->connect_error) {
                echo "Connection database failed: " . $conn->connect_error;
            } else {
                $sql = file_get_contents('sql');
                $sql .= "
                    insert  into `users`(`id`,`created`,`user_created_id`,`deleted`,`username`,`email`,`password`,`name`,`status`)
                    values (1,NOW(),1,0,'$user_name','$user_email','". md5($user_password) ."','Admin','Active');
                ";

                if ($conn->multi_query($sql) === TRUE) {
                    $caro_db = "adapter = Mysql\n";
                    $caro_db .= "host = {$db_host}\n";
                    $caro_db .= "username = {$db_user}\n";
                    $caro_db .= "password = {$db_pwd}\n";
                    $caro_db .= "name = {$db_name}";
                    $file = fopen(APP_PATH . "apps/config/database.ini", 'w');
                    fwrite($file, $caro_db);
                    fclose($file);

                    $caro_config = "[application]\n";
                    $caro_config .= "baseUrl = {$baseurl}\n";
                    $caro_config .= "backendUrl = {$backendprefix}\n";
                    $caro_config .= "title = {$pagetitle}\n";
                    $caro_config .= "theme = caro";
                    $file = fopen(APP_PATH . "apps/config/config.ini", 'w');
                    fwrite($file, $caro_config);
                    fclose($file);

                    header('Location: ../../admin');

                } else {
                    echo "Error database." . $db_name . "<br>" . $conn->error;
                }

                $conn->close();

            }
        } else {
            echo 'Password again incorrect!';
        }
    } else {
        echo 'Data is empty!';
    }
}

$current_url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$current_url = str_replace('/public/install/', '', $current_url);

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Caro Framework Installation</title>
    <meta name="generator" content="Jacky" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="A Open Source Framework base on Phalcon PHP" />
    <link href="../themes/caro/css/bootstrap.min.css" rel="stylesheet">
    <link href="../themes/caro/css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="../themes/caro/js/html5.js"></script>
    <![endif]-->
    <link href="../themes/caro/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
</head>
<body>

<div class="container-full">
    <div style="width: 960px; margin: 0 auto">
        <div class="text-center">
            <h1>Caro Framework</h1>
            <p class="lead">A Open Source Framework base on Phalcon PHP</p>
        </div>

        <p class="lead">Caro Framework Config</p>
        <p style="font-style: italic">We will override info database in apps/config/database.php</p>

        <form action="index.php" method="post" class="form-horizontal" style="padding: 20px; padding-top: 30px; border: 1px solid #fff;">
            <div class="row">
                <div class="col-xs-6">
                    <h4 style="text-align: center">Database Config</h4>

                    <div class="form-group">
                        <label for="dbhost" class="col-sm-4 control-label">DB Host</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="dbhost" name="dbhost" value="localhost" placeholder="DB Host" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dbusername" class="col-sm-4 control-label">DB User</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="dbusername" name="dbusername" value="root" placeholder="DB User" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dbpassword" class="col-sm-4 control-label">DB Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="dbpassword" name="dbpassword" placeholder="DB Password">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="dbname" class="col-sm-4 control-label">DB Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="dbname" name="dbname" value="caroframework" placeholder="DB Name" required>
                        </div>
                    </div>


                </div>

                <div class="col-xs-6">
                    <h4 style="text-align: center">User Admin Config</h4>

                    <div class="form-group">
                        <label for="username" class="col-sm-4 control-label">Username</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="username" name="username" value="admin" placeholder="Username" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="col-sm-4 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" id="email" name="email" value="support@carodev.com" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-sm-4 control-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password2" class="col-sm-4 control-label">Password Again</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password2" name="password2" placeholder="Password Again" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="margin: 20px 0; border-top: 1px solid #fff">
                <div class="col-xs-12">
                    <h4 style="text-align: center">Page Config</h4>

                    <div class="form-group">
                        <label for="username" class="col-sm-4 control-label">Base Url</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="baseurl" name="baseurl" value="http://<?php echo $current_url ?>" placeholder="Base Url" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username" class="col-sm-4 control-label">Backend prefix</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="backendprefix" name="backendprefix" value="admin" placeholder="Backend prefix" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username" class="col-sm-4 control-label">Page title</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pagetitle" name="pagetitle" value="CaroFramework" placeholder="Page title" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-6"></div>
                <div class="col-xs-6">
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Install</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <br><br>
            <p class="pull-right">
                ©Copyright 2015 Jacky - CaroCRM<sup>TM</sup>. &nbsp;
                <a href="http://www.bootply.com">Template from Bootply</a>
            </p>
            <br><br>
        </div>
    </div>
</div>

</body>
</html>
