<div class="row">
    <div class="span4">

    </div>

    <div class="span12">
        {{ form('/'~ carofw['backendUrl'] ~'/settings/mail_config', 'method': 'post', 'class': 'form-horizontal', 'id': 'mail-config') }}
            <input type="hidden" name="smtp_test" value="0" id="smtp_test">
            <fieldset>
                <legend class="lead">{{ t._('Mail Config') }}</legend>

                <div class="control-group ">
                    <label class="control-label">{{ t._('From Name') }}</label>
                    <div class="controls">
                        <input type="text" name="from_name" class="span9" value="{% if data.from_name is defined %}{{ data.from_name }}{% endif %}">
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">{{ t._('From Email') }}</label>
                    <div class="controls">
                        <input type="text" name="from_email" class="span9" value="{% if data.from_email is defined %}{{ data.from_email }}{% endif %}">
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">{{ t._('SMTP Server') }}</label>
                    <div class="controls">
                        <input type="text" name="smtp_server" class="span9" value="{% if data.smtp_server is defined %}{{ data.smtp_server }}{% endif %}">
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">{{ t._('SMTP Port') }}</label>
                    <div class="controls">
                        <input type="text" name="smtp_port" class="span9" value="{% if data.smtp_port is defined %}{{ data.smtp_port }}{% endif %}">
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">{{ t._('SMTP Security') }}</label>
                    <div class="controls">
                        <input type="text" name="smtp_security" class="span9" value="{% if data.smtp_security is defined %}{{ data.smtp_security }}{% endif %}">
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">{{ t._('SMTP Username') }}</label>
                    <div class="controls">
                        <input type="text" name="smtp_username" class="span9" value="{% if data.smtp_username is defined %}{{ data.smtp_username }}{% endif %}">
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label">{{ t._('SMTP Password') }}</label>
                    <div class="controls">
                        <input type="password" name="smtp_password" class="span9" value="{% if data.smtp_password is defined %}{{ data.smtp_password }}{% endif %}">
                    </div>
                </div>
            </fieldset>
            <footer id="submit-actions" class="form-actions">
                <button type="submit" class="btn btn-primary" name="action" value="CONFIRM">{{ t._('Save') }}</button>
                <button type="reset" class="btn" name="action" value="CANCEL">{{ t._('Cancel') }}</button>
                <button type="button" class="btn btn-primary" name="send_test" value="CONFIRM" onclick="$('#smtp_test').val('1');$('#mail-config').submit()">{{ t._('Send test') }}</button>
            </footer>
        {{ end_form() }}
    </div>
</div>