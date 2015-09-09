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
                        <i class="fa fa-database"></i> {{ t._('Repair') }}
                    </a>

                    <a href="{{ url('/'~ carofw['backendUrl'] ~'/settings/mail_config') }}" class="btn btn-app">
                        <i class="fa fa-envelope"></i> {{ t._('Mail Config') }}
                    </a>

                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>