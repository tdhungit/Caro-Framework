<div class="row">
    <div class="span4">

    </div>

    <div class="span12">
        <div class="box">
            <div class="box-header">
                <i class="icon-list"></i>
                <h5>{{ t._('Settings') }}</h5>
            </div>

            <div class="box-content">
                <div class="btn-group-box">
                    <a href="{{ url('/'~ carofw['backendUrl'] ~'/settings/repair') }}" class="btn">
                        <i class="icon-dashboard icon-large"></i>
                        <br />
                        {{ t._('Repair') }}
                    </a>

                    <a href="{{ url('/'~ carofw['backendUrl'] ~'/settings/mail_config') }}" class="btn">
                        <i class="icon-dashboard icon-large"></i>
                        <br />
                        {{ t._('Mail Config') }}
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>