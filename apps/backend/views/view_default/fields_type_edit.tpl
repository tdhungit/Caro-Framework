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

                {% elseif view['type'] == 'image' %}
                    <div class="caro-image-content" style="padding-bottom: 5px;">
                        {% if data is not null %}<img src="{{ data.readAttribute(name) }}" class="img-thumbnail" style="height: 200px;">{% endif %}
                    </div>
                    <span class="btn btn-default btn-file">
                        Browse <input type="file" class="caro-upload-image" location="images">
                        <input type="hidden" name="{{ name }}" class="caro-value-upload">
                    </span>

                {% elseif view['type'] == 'textarea' %}
                    <textarea name="{{ name }}" rows="4" class="span9" id="editview-{{ name }}">{% if data is not null %}{{ data.readAttribute(name) }}{% endif %}</textarea>
                    <script>CKEDITOR.replace('editview-{{ name }}');</script>

                {% elseif view['type'] == 'customCode' %}
                    {{ row.renderCustomCode(view['customCode']) }}

                {# default | not define type #}
                {% else %}
                    <input id="current-{{ name }}-control" name="{{ name }}" class="span9" type="{{ view['type'] }}" value="{% if data is not null %}{{ data.readAttribute(name) }}{% endif %}" />

            {% endif %}
        </div>
    </div>
{% endfor %}