<div class="row">
    <div class="span4">
        <div class="blockoff-right">
            <ul class="nav nav-list">
                <li class="nav-header">Action</li>
                <li>
                    <a href="{{ url('/admin') }}/{{ controller }}/list">
                        <i class="icon-chevron-right pull-right"></i>
                        View Users
                    </a>
                </li>
                <li{% if data is null %} class="active"{% endif %}>
                    <a href="{{ url('/admin') }}/{{ controller }}/edit">
                        <i class="icon-chevron-right pull-right"></i>
                        Create User
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="span12">
        {{ form('/admin/users/edit', 'method': 'post', 'class': 'form-horizontal') }}
        <fieldset>
            {% if data is null %}
                <legend class="lead">Create {{ controller }}</legend>
            {% else %}
                <legend class="lead">Edit {{ controller }} {{ data.readAttribute(edit_view['title']) }}</legend>
                <br />
            {% endif %}

            {% for field, field_opt in edit_view['fields'] %}
                <div class="control-group ">
                    <label class="control-label">{{ field_opt['label'] }} {% if field_opt['required'] is defined and field_opt['required'] %}<span class="required">*</span>{% endif %}</label>
                    <div class="controls">
                        <input id="current-{{ field }}-control" name="{{ field }}" class="span9" type="{{ field_opt['type'] }}" value="{% if data is not null %}{{ data.readAttribute(field) }}{% endif %}" />
                    </div>
                </div>
            {% endfor %}
        </fieldset>
        {{ end_form() }}

        <footer id="submit-actions" class="form-actions">
            <button id="submit-button" type="submit" class="btn btn-primary" name="action" value="CONFIRM">Save</button>
            <button type="submit" class="btn" name="action" value="CANCEL">Cancel</button>
        </footer>
    </div>
</div>