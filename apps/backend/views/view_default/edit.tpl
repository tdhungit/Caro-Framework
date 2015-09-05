<div class="row">
    <div class="span4">
        <div class="blockoff-right">
            <ul class="nav nav-list">
                <li class="nav-header">{{ t._('Action') }}</li>
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
        {{ form('/'~ carofw['backendUrl'] ~'/' ~ controller ~ '/save', 'method': 'post', 'class': 'form-horizontal') }}
        <input type="hidden" name="model_name" value="{{ model_name }}">
        <input type="hidden" name="action_detail" value="{{ action_detail }}">

        <fieldset>
            {% if data is null %}
                <legend class="lead">{{ title }}</legend>
            {% else %}
                <legend class="lead">{{ title }}</legend>
                <br />
                <input type="hidden" name="id" value="{{ data.id }}" />
            {% endif %}

            {# check type and render with type #}
            {% include 'view_default/fields_type_edit.tpl' %}
        </fieldset>

        <footer id="submit-actions" class="form-actions">
            <button id="submit-button" type="submit" class="btn btn-primary" name="action" value="CONFIRM">Save</button>
            <button type="submit" class="btn" name="action" value="CANCEL">Cancel</button>
        </footer>
        {{ end_form() }}
    </div>
</div>