{% if view['type'] == 'select' %}
    {% if row.readAttribute(name) %}
        {% set value = carofw['app_list_strings'][view['options']][row.readAttribute(name)] %}
    {% else %}
        {% set value = '' %}
    {% endif %}

{% elseif view['type'] == 'relate' %}
    <?php
        $model_path = '\\Modules\Backend\Models\\' . $view['model'];
        $model = new $model_path();
        if (!empty($row->$name)) {
            $options = $model::findFirst($row->$name);
        }
    ?>

    {% if options is defined %}
        {% set key = model.detail_view['title'] %}
        {% set value = options.readAttribute(key) %}
    {% else %}
        {% set value = '' %}
    {% endif %}

{% elseif view['type'] == 'image' %}
    {% set value = '<img src="'~ row.readAttribute(name) ~'" class="img-thumbnail" style="height: 50px;">' %}

{% elseif view['type'] == 'customCode' %}
    {% set value = row.renderCustomCode(view['customCode']) %}

{% elseif view['type'] == 'hidden' %}
    {% set value = '' %}

{% else %}
    {% set value = row.readAttribute(name) %}
{% endif %}

{% if view['link'] is defined and view['link'] %}
    <a href="{{ url('/'~ carofw['backendUrl'] ~'/' ~ controller ~ '/' ~ action_detail ~ '/' ~ row.id) }}">{{ value }}</a>
{% else %}
    {{ value }}
{% endif %}