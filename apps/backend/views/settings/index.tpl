<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <i class="fa fa-cog"></i>
                    <h3 class="box-title">{{ t._('Settings') }}</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <a href="{{ url('/'~ carofw['backendUrl'] ~'/settings/repair') }}" class="btn btn-app">
                        <i class="fa fa-database"></i> {{ t._('Repair Database') }}
                    </a>

                    <a href="{{ url('/'~ carofw['backendUrl'] ~'/settings/rebuild_resources') }}" class="btn btn-app">
                        <i class="fa fa-wrench"></i> {{ t._('Rebuild ACL Resource') }}
                    </a>

                    <a href="{{ url('/'~ carofw['backendUrl'] ~'/settings/mail_config') }}" class="btn btn-app">
                        <i class="fa fa-envelope"></i> {{ t._('Mail Config') }}
                    </a>

                    <a href="{{ url('/'~ carofw['backendUrl'] ~'/users/register_roles') }}" class="btn btn-app">
                        <i class="fa fa-users"></i> {{ t._('Register Roles') }}
                    </a>


                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>