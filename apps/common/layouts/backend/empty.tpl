<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{ get_title() }}
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{ static_url() }}/themes/backend/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ static_url() }}/themes/backend/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ static_url() }}/themes/backend/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ static_url() }}/themes/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ static_url() }}/themes/backend/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ static_url() }}/themes/backend/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="{{ static_url() }}/themes/backend/plugins/iCheck/square/blue.css">

    <script>
        var base_url = '{{ url() }}';
        var backend_url = '{{ url('/' ~ carofw['backendUrl']) }}';
    </script>
    <script src="{{ static_url() }}/themes/backend/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="{{ static_url() }}/themes/backend/ckeditor/ckeditor.js"></script>
    <script src="{{ static_url() }}/themes/backend/js/systemJs.js" type="text/javascript" ></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="{{ static_url() }}/themes/backend/js/html5shiv.min.js"></script>
    <script src="{{ static_url() }}/themes/backend/js/respond.min.js"></script>
    <![endif]-->
</head>

{{ get_content() }}

</html>