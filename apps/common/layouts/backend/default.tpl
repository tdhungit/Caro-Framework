<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Admin - Caro Framework</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="layout" content="main"/>

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>

    <script src="{{ static_url() }}/themes/backend/js/jquery/jquery-1.8.2.min.js" type="text/javascript" ></script>
    <link href="{{ static_url() }}/themes/backend/css/customize-template.css" type="text/css" media="screen, projection" rel="stylesheet" />
</head>

<body>

<div id="body-container">
    <div id="body-content">
        <div class="body-nav body-nav-horizontal body-nav-fixed">
            <div class="container">
                <ul>
                    <li>
                        <a href="#">
                            <i class="icon-dashboard icon-large"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-calendar icon-large"></i> Schedule
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-map-marker icon-large"></i> Map It
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-tasks icon-large"></i> Widgets
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-cogs icon-large"></i> Settings
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-list-alt icon-large"></i> Forms
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="icon-bar-chart icon-large"></i> Charts
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <section class="page container">
            {{ flash.output() }}

            {{ get_content() }}
        </section>
    </div>
</div>

<footer class="application-footer">
    <div class="container">
        <p>Admin Page - Caro Framework</p>
        <div class="disclaimer">
            <p>Caro Framework. All right reserved.</p>
            <p>Copyright Jacky 2015</p>
        </div>
    </div>
</footer>

<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-transition.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-alert.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-modal.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-dropdown.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-scrollspy.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-tab.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-tooltip.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-popover.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-button.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-collapse.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-carousel.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-typeahead.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-affix.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-datepicker.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/jquery/jquery-tablesorter.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/jquery/jquery-chosen.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/jquery/virtual-tour.js" type="text/javascript" ></script>
<script type="text/javascript">
    $(function() {
        $('#sample-table').tablesorter();
        $('#datepicker').datepicker();
        $(".chosen").chosen();
    });
</script>

</body>
</html>