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
        <div class="box">
            <div class="box-content">
                {% if data is null %}
                    <legend class="lead" style="border: none">{{ t._('No Data') }}</legend>
                {% else %}
                    <legend class="lead" style="border: none">{{ title }}</legend>
                    <table class="table">
                        <tbody>
                        {% for name, view in detail_view['fields'] %}
                            <tr>
                                <td><b>{{ view['label'] }}</b></td>
                                <td>
                                    {% if view['type'] == 'select' %}
                                        {% set value = carofw['app_list_strings'][view['options']][data.readAttribute(name)] %}

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
                                            {% set value = options.readAttribute(key) %}
                                        {% else %}
                                            {% set value = '' %}
                                        {% endif %}

                                    {% else %}
                                        {% set value = data.readAttribute(name) %}

                                    {% endif %}

                                    {{ value }}
                                </td>
                            </tr>
                        {% endfor %}
                        </tbody>
                    </table>
                {% endif %}
            </div>
        </div>

        {% if detail_view['subpanels'] is defined %}
            {% for subpanel_name, subpanel_def in detail_view['subpanels'] %}
                <div class="box">
                    <div class="box-header">
                        <h5>{{ t._(subpanel_def['rel_model']) }}</h5>

                        <a class="btn btn-box-right" href="javascript:caro_list_relate('{{ subpanel_def['rel_model'] }}', '{{ subpanel_def['current_model'] }}', '{{ data.id }}', '{{ subpanel_name }}')">
                            <i class="icon-plus"></i>
                        </a>
                    </div>
                    <div class="box-content box-table">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                {% for name, view in subpanel_def['list'] %}
                                    <th class="header">{{ view['label'] }}</th>
                                {% endfor %}
                                <th class="header">{{ t._('Action') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            {% for row in subpanels[subpanel_name] %}
                                <tr>
                                    {% for name, view in subpanel_def['list'] %}
                                        <td>{{ row.readAttribute(name) }}</td>
                                    {% endfor %}
                                    <td class="td-actions">
                                        <a href="javascript:caro_remove_relate('{{ subpanel_def['rel_model'] }}', '{{ row.id }}', '{{ subpanel_name }}', '{{ subpanel_def['current_model'] }}', '{{ data.id }}')" class="btn btn-small btn-danger">
                                            <i class="btn-icon-only icon-remove"></i>
                                        </a>
                                    </td>
                                </tr>
                            {% endfor %}
                            </tbody>
                        </table>
                    </div>
                </div>
            {% endfor %}
        {% endif %}
    </div>
</div>