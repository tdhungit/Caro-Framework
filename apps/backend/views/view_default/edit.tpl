<div class="row">
    <div class="span4">
        <div class="blockoff-right">
            <ul class="nav nav-list">
                <li class="nav-header">Action</li>
                {% for l, m in menu %}
                    <li>
                        <a href="{{ url(m) }}">
                            <i class="icon-chevron-right pull-right"></i>
                            {{ l }}
                        </a>
                    </li>
                {% endfor %}
            </ul>
        </div>
    </div>

    <div class="span12">
        {{ form('/admin/' ~ controller ~ '/edit', 'method': 'post', 'class': 'form-horizontal') }}
        <fieldset>
            {% if data is null %}
                <legend class="lead">Create {{ controller }}</legend>
            {% else %}
                <legend class="lead">Edit {{ controller }} {{ data.readAttribute(edit_view['title']) }}</legend>
                <br />
                <input type="hidden" name="id" value="{{ data.id }}" />
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

        <footer id="submit-actions" class="form-actions">
            <button id="submit-button" type="submit" class="btn btn-primary" name="action" value="CONFIRM">Save</button>
            <button type="submit" class="btn" name="action" value="CANCEL">Cancel</button>
        </footer>
        {{ end_form() }}
    </div>
</div>