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
    <style>
        * {
            font-family: "Gotham Rounded A","Gotham Rounded B","Helvetica Neue",Helvetica,Arial,sans-serif,"Helvetica Neue","Helvetica","Roboto","Arial",sans-serif;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            {{ get_content() }}
        </div>

        <div class="col-md-4">
            <p class="leader">{{ t._('Table Of Contents') }}</p>
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav in" id="side-menu">
                    <li>
                        <a href="index.html" class="active">
                            <i class="fa fa-dashboard fa-fw"></i> Dashboard
                        </a>
                    </li>
                    <li class="">
                        <a href="#">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Charts
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                            <li><a href="flot.html">Flot Charts</a></li>
                            <li><a href="morris.html">Morris.js Charts</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
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

<script src="{{ static_url(theme_uri) }}/js/jquery.min.js"></script>
<script src="{{ static_url(theme_uri) }}/js/bootstrap.min.js"></script>
<script src="{{ static_url(theme_uri) }}/js/metisMenu.min.js"></script>
<script>
    $(function() {
        $('#side-menu').metisMenu();
    });
</script>

</body>
</html>