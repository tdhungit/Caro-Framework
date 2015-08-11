<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    {{ get_title() }}
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="layout" content="main"/>

    <script>
        var base_url = '{{ url() }}';
    </script>
    <script src="{{ static_url() }}/themes/backend/js/jquery/jquery-1.8.2.min.js" type="text/javascript" ></script>
    <script src="{{ static_url() }}/themes/backend/js/systemJs.js" type="text/javascript" ></script>

    <link href="{{ static_url() }}/themes/backend/css/bootstrap-dialog.min.css" type="text/css" media="screen, projection" rel="stylesheet" />
    <link href="{{ static_url() }}/themes/backend/css/customize-template.css" type="text/css" media="screen, projection" rel="stylesheet" />
</head>

<body>

<div id="body-container">
    <div id="body-content">
        <div class="body-nav body-nav-horizontal body-nav-fixed">
            <div class="container">
                <ul>
                    <li>
                        <a href="{{ url('/admin/dashboard') }}">
                            <i class="icon-dashboard icon-large"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/organizations') }}">
                            <i class="icon-organization icon-large"></i> Organizations
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/courses') }}">
                            <i class="icon-course icon-large"></i> Courses
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/categories') }}">
                            <i class="icon-qrcode icon-large"></i> Categories
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/teachers') }}">
                            <i class="icon-user icon-large"></i> Teachers
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/users') }}">
                            <i class="icon-user icon-large"></i> Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/settings') }}">
                            <i class="icon-cogs icon-large"></i> Settings
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

<!-- Model -->
<div class="modal fade" id="systemModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="systemModalContent"></div>
    </div>
</div>
<!-- End Model -->

<footer class="application-footer">
    <div class="container">
        <div class="disclaimer">
            <p>iEureka. All right reserved.</p>
            <p>Copyright iEureka 2015</p>
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
<script src="{{ static_url() }}/themes/backend/js/bootstrap/bootstrap-dialog.min.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/jquery/jquery-tablesorter.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/jquery/jquery-chosen.js" type="text/javascript" ></script>
<script src="{{ static_url() }}/themes/backend/js/jquery/virtual-tour.js" type="text/javascript" ></script>
<script type="text/javascript">
    $(function() {
        $('.sorter-table').tablesorter();
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });
        $(".chosen").chosen();
    });
</script>

</body>
</html>