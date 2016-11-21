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
            $dv = $model->detail_view;
            $key = $dv['title'];
        }
    ?>

    {% if options is defined %}
        {{ options.readAttribute(key) }}
    {% endif %}

    <?php
        unset($model);
        unset($options);
    ?>

{% elseif view['type'] == 'image' %}
    <img src="{{ data.readAttribute(name) }}" class="img-thumbnail" style="height: 200px;">

{% elseif view['type'] == 'multiimage' %}
    <?php
        if (!empty($data)) {
            $multiimages = explode(',', $data->$name);
        }
    ?>
    {% for img in multiimages %}
        <img src="{{ img }}" class="img-thumbnail" style="height: 200px;">
    {% endfor %}

{% elseif view['type'] == 'customCode' %}
    {{ data.renderCustomCode(view['customCode']) }}

{% elseif view['type'] == 'hidden' %}

{% else %}
    {{ data.readAttribute(name) }}
{% endif %}