<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ t._('Mail Config') }}
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                {{ form('/'~ carofw['backendUrl'] ~'/settings/mail_config', 'method': 'post', 'class': 'form-horizontal', 'id': 'mail-config') }}
                    <div class="box-body">
                        <input type="hidden" name="smtp_test" value="0" id="smtp_test">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ t._('From Name') }}</label>
                            <div class="col-sm-10">
                                <input type="text" name="from_name" class="form-control" value="{% if data.from_name is defined %}{{ data.from_name }}{% endif %}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ t._('From Email') }}</label>
                            <div class="col-sm-10">
                                <input type="text" name="from_email" class="form-control" value="{% if data.from_email is defined %}{{ data.from_email }}{% endif %}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ t._('SMTP Server') }}</label>
                            <div class="col-sm-10">
                                <input type="text" name="smtp_server" class="form-control" value="{% if data.smtp_server is defined %}{{ data.smtp_server }}{% endif %}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ t._('SMTP Port') }}</label>
                            <div class="col-sm-10">
                                <input type="text" name="smtp_port" class="form-control" value="{% if data.smtp_port is defined %}{{ data.smtp_port }}{% endif %}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ t._('SMTP Security') }}</label>
                            <div class="col-sm-10">
                                <input type="text" name="smtp_security" class="form-control" value="{% if data.smtp_security is defined %}{{ data.smtp_security }}{% endif %}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ t._('SMTP Username') }}</label>
                            <div class="col-sm-10">
                                <input type="text" name="smtp_username" class="form-control" value="{% if data.smtp_username is defined %}{{ data.smtp_username }}{% endif %}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ t._('SMTP Password') }}</label>
                            <div class="col-sm-10">
                                <input type="password" name="smtp_password" class="form-control" value="{% if data.smtp_password is defined %}{{ data.smtp_password }}{% endif %}">
                            </div>
                        </div>

                        <div class="box-footer">
                            <button type="button" class="btn btn-info pull-right" name="send_test" value="CONFIRM" onclick="$('#smtp_test').val('1');$('#mail-config').submit()">{{ t._('Send test') }}</button>
                            <button type="reset" class="btn btn-default pull-right" name="action" value="CANCEL" style="margin: 0 5px;">{{ t._('Cancel') }}</button>
                            <button type="submit" class="btn btn-info pull-right" name="action" value="CONFIRM">{{ t._('Save') }}</button>
                        </div>
                    </div>
                {{ end_form() }}
            </div>
        </div>
    </div>
</section>