{% if view['type'] == 'select' %}
    {% if data.readAttribute(name) %}
        {{ carofw['app_list_strings'][view['options']][data.readAttribute(name)] }}
    {% endif %}

{% elseif view['type'] == 'relate' %}
    <?php
        $model_path = '\\Modules\Backend\Models\\' . $view['model'];
        $model = new $model_path();
        if (!empty($data->$name)) {
            $options = $model::findFirst($data->$name);
        }
    ?>

    {% if options is defined %}
        {% set key = model.detail_view['title'] %}
        {{ options.readAttribute(key) }}
    {% endif %}

{% elseif view['type'] == 'image' %}
    <img src="{{ data.readAttribute(name) }}" class="img-thumbnail" style="height: 200px;">

{% elseif view['type'] == 'customCode' %}
    {{ row.renderCustomCode(view['customCode']) }}

{% elseif view['type'] == 'hidden' %}

{% else %}
    {{ data.readAttribute(name) }}
{% endif %}