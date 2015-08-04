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
        {{ form('/admin/' ~ controller ~ '/' ~ action, 'method': 'post', 'class': 'form-horizontal') }}
        <fieldset>
            {% if data is null %}
                <legend class="lead">{{ title }}</legend>
            {% else %}
                <legend class="lead">{{ title }}</legend>
                <br />
                <input type="hidden" name="id" value="{{ data.id }}" />
            {% endif %}

            {% for name, view in edit_view['fields'] %}
                <div class="control-group ">
                    <label class="control-label">{{ view['label'] }} {% if view['required'] is defined and view['required'] %}<span class="required">*</span>{% endif %}</label>
                    <div class="controls">
                        {% if view['type'] == 'select' %}
                            {% if data is not null %}
                                {{ select(name, carofw['app_list_strings'][view['options']], 'using': ['id', 'name'], 'value': data.readAttribute(name), 'class': 'span9') }}
                            {% else %}
                                {{ select(name, carofw['app_list_strings'][view['options']], 'using': ['id', 'name'], 'class': 'span9') }}
                            {% endif %}

                        {% elseif view['type'] == 'relate' %}
                            <?php
                                $model_path = '\\Modules\Backend\Models\\' . $view['model'];
                                $model = new $model_path();
                                $options = $model::find()
                            ?>

                            {% if data is not null %}
                                {{ select(name, options, 'using': ['id', 'name'], 'value': data.readAttribute(name), 'class': 'span9', 'useEmpty': true) }}
                            {% else %}
                                {{ select(name, options, 'using': ['id', 'name'], 'class': 'span9', 'useEmpty': true) }}
                            {% endif %}

                        {% elseif view['type'] == 'textarea' %}
                            <textarea rows="4" class="span9">{% if data is not null %}{{ data.readAttribute(name) }}{% endif %}</textarea>

                        {% else %}
                            <input id="current-{{ name }}-control" name="{{ name }}" class="span9" type="{{ view['type'] }}" value="{% if data is not null %}{{ data.readAttribute(name) }}{% endif %}" />

                        {% endif %}
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