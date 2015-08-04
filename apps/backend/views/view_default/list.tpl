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
            <div class="box-header">
                <i class="icon-list icon-large"></i>
                <h5>{{ title }}</h5>
            </div>

            <div class="box-content box-table">
                {{ form('/admin/' ~ controller ~ '/' ~ action, 'method' : 'get', 'class': 'form-list-search') }}
                <table class="table table-hover tablesorter">
                    <thead>
                    <tr>
                        {% for name, view in list_view['fields'] %}
                            <th class="header">{{ view['label'] }}</th>
                        {% endfor %}
                        <th class="header">{{ t._('Action') }}</th>
                    </tr>
                    </thead>

                    <tbody>

                    <!-- search -->
                    <tr>
                        {% for name, view in list_view['fields'] %}
                            <td>
                                {% if view['search'] is defined and view['search'] %}
                                    {% if search[name] is defined %}{% set search_value = search[name] %}{% else %}{% set search_value = '' %}{% endif %}
                                    {% if view['type'] == 'select' %}
                                        {{ select(name, carofw['app_list_strings'][view['options']], 'using': ['id', 'name'], 'value': search_value, 'useEmpty': true, 'emptyText': view['label'], 'emptyValue': '', 'class': 'list-search') }}
                                    {% else %}
                                        <input type="{{ view['type'] }}" name="{{ name }}" placeholder="{{ view['label'] }}" value="{{ search_value }}" class="list-search" />
                                    {% endif %}
                                {% endif %}
                            </td>
                        {% endfor %}
                        <td><input type="submit" name="submit" class="btn" value="{{ t._('Search') }}"></td>
                    </tr>

                    {% for row in data %}
                        <tr>
                            {% for name, view in list_view['fields'] %}
                                <td>
                                    {% if view['type'] == 'select' %}
                                        {% set value = carofw['app_list_strings'][view['options'][row.readAttribute(name)]] %}
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

                                    {% else %}
                                        {% set value = row.readAttribute(name) %}
                                    {% endif %}

                                    {% if view['link'] is defined and view['link'] %}
                                        <a href="{{ url('/admin/' ~ controller ~ '/' ~ action_detail ~ '/' ~ row.id) }}">{{ value }}</a>
                                    {% else %}
                                        {{ value }}
                                    {% endif %}
                                </td>
                            {% endfor %}

                            <td class="td-actions">
                                <a href="{{ url('/admin/' ~ controller ~ '/' ~ action_edit ~ '/' ~  row.id) }}" class="btn btn-small btn-warning">
                                    <i class="btn-icon-only icon-edit"></i>
                                </a>

                                <a href="{{ url('/admin/' ~ controller ~ '/' ~ action_delete ~ '/' ~  row.id) }}" class="btn btn-small btn-danger delete-record">
                                    <i class="btn-icon-only icon-remove"></i>
                                </a>

                            </td>

                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
                {{ end_form() }}

            </div>

        </div>

        <!-- pagination -->
        <nav class="pagination pagination-centered">
            <ul>
                <li><a href="{{ current_url }}">First</a></li>
                <li><a href="{{ current_url }}&page={{ page.before }}">Previous</a></li>
                <li>
                    <a href="javascript:;">
                        <select style="margin: 0; width: auto;" onchange="location.href='{{ current_url }}&page=' + $(this).val();">
                            {% for i in 1..page.total_pages %}
                                <option{% if page.current == i %} selected{% endif %}>{{ i }}</option>
                            {% endfor %}
                        </select>
                    </a>
                </li>
                <li><a href="{{ current_url }}&page={{ page.next }}">Next</a></li>
                <li><a href="{{ current_url }}&page={{ page.last }}">Last</a></li>
            </ul>
        </nav>

    </div>

</div>