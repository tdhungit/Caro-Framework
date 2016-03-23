{% for name, view in edit_view['fields'] %}
    {% if view['type'] != 'hidden' %}
        <div class="form-group">
            <label class="col-sm-2 control-label">{{ view['label'] }} {% if view['required'] is defined and view['required'] %}<span class="required">*</span>{% endif %}</label>
            <div class="col-sm-10">
                {% if view['type'] == 'select' %}
                    {% if data is not null %}
                        {{ select(name, carofw['app_list_strings'][view['options']], 'using': ['id', 'name'], 'value': data.readAttribute(name), 'class': 'form-control') }}
                    {% else %}
                        {{ select(name, carofw['app_list_strings'][view['options']], 'using': ['id', 'name'], 'class': 'form-control') }}
                    {% endif %}

                    {% elseif view['type'] == 'relate' %}
                        <?php
                            $model_path = '\\Modules\Backend\Models\\' . $view['model'];
                            $model = new $model_path();
                            $options = $model::find(array('conditions' => 'deleted = 0'));
                        ?>

						{% if data is not null %}
							{{ select(name, options, 'using': ['id', 'name'], 'value': data.readAttribute(name), 'class': 'form-control', 'useEmpty': true) }}
						{% else %}
							{% if view['default'] is defined %}
								{% if view['default'] == 'session' %}
									{{ select(name, options, 'using': ['id', 'name'], 'value': session.get('auth')['id'], 'class': 'form-control', 'useEmpty': true) }}
								{% else %}
									{{ select(name, options, 'using': ['id', 'name'], 'value': view['default'], 'class': 'form-control', 'useEmpty': true) }}
								{% endif %}
							{% else %}
								{{ select(name, options, 'using': ['id', 'name'], 'class': 'form-control', 'useEmpty': true) }}
							{% endif %}
						{% endif %}

                    {% elseif view['type'] == 'image' %}
                        <div class="caro-image-content" style="padding-bottom: 5px;">
                            {% if data is not null %}<img src="{{ data.readAttribute(name) }}" class="img-thumbnail" style="height: 200px;">{% endif %}
                        </div>
                        <span class="btn btn-default btn-file">
                            Browse <input type="file" class="caro-upload-image" location="images">
                            <input type="hidden" name="{{ name }}" class="caro-value-upload" value="{% if data is not null %}{{ data.readAttribute(name) }}{% endif %}">
                        </span>

                    {% elseif view['type'] == 'textarea' %}
                        <textarea name="{{ name }}" rows="4" class="span9" id="editview-{{ name }}">{% if data is not null %}{{ data.readAttribute(name) }}{% endif %}</textarea>
                        <script>CKEDITOR.replace('editview-{{ name }}');</script>

                    {% elseif view['type'] == 'note' %}
                        <textarea name="{{ name }}" rows="4" class="span9">{% if data is not null %}{{ data.readAttribute(name) }}{% endif %}</textarea>

                    {% elseif view['type'] == 'customCode' %}
                        {% if data is not null %}
							{{ data.renderCustomCode(view['customCode']) }}
						{% else %}
							{{ model.renderCustomCode(view['customCode']) }}
						{% endif %}

                    {# default | not define type #}
                    {% else %}
                        <input id="current-{{ name }}-control" name="{{ name }}" class="form-control" type="{{ view['type'] }}" value="{% if data is not null %}{{ data.readAttribute(name) }}{% endif %}" />

                {% endif %}
            </div>
        </div>
    {% endif %}
{% endfor %}