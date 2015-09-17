<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    {{ get_title() }}
    <meta name="generator" content="Jacky" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="A Open Source Framework base on Phalcon PHP" />
    <link href="{{ static_url(theme_uri) }}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ static_url(theme_uri) }}/css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ static_url(theme_uri) }}/js/html5.js"></script>
    <![endif]-->
    <link href="{{ static_url(theme_uri) }}/font-awesome/css/font-awesome.css" rel="stylesheet">

    <script src="{{ static_url(theme_uri) }}/js/jquery.min.js"></script>
    <script src="{{ static_url(theme_uri) }}/js/ZeroClipboard/ZeroClipboard.js"></script>
</head>
<body>

    {{ get_content() }}

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