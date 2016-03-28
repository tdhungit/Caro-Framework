<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ title }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/'~carofw['backendUrl']~'/'~controller~'/'~action_edit) }}">{{ t._('Create') }}</a></li>
        {% if extra_view_menus is defined %}
            {% for m in extra_view_menus %}
                <li><a href="{{ url('/'~carofw['backendUrl']~m['url']) }}">{{ t._(m['label']) }}</a></li>
            {% endfor %}
        {% endif %}
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-default">
                {{ form('/'~ carofw['backendUrl'] ~'/' ~ controller ~ '/' ~ action, 'method' : 'get', 'class': 'form-list-search') }}
                    <div class="box-body">
                        <div class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-hover dataTable">
                                        <thead>
                                            <tr role="row">
                                                {% for name, view in list_view['fields'] %}
                                                    <th class="header">{{ view['label'] }}</th>
                                                {% endfor %}
                                                <th class="header">{{ t._('Action') }}</th>
                                            </tr>
                                            <!-- search -->
                                            <tr>
                                                {% for name, view in list_view['fields'] %}
                                                    <td>
                                                        {% if view['search'] is defined and view['search'] %}
                                                            {% if search[name] is defined %}{% set search_value = search[name] %}{% else %}{% set search_value = '' %}{% endif %}
                                                            {% if view['type'] == 'select' %}
                                                                {{ select(name, carofw['app_list_strings'][view['options']], 'using': ['id', 'name'], 'value': search_value, 'useEmpty': true, 'emptyText': view['label'], 'emptyValue': '', 'class': 'form-control') }}
                                                            {% elseif view['type'] == 'relate' %}
                                                                <?php
                                                                    $model_path = '\\Modules\Backend\Models\\' . $view['model'];
                                                                    $model = new $model_path();
                                                                    $options = $model::find(array('conditions' => 'deleted = 0'));
                                                                ?>
                                                                {{ select(name, options, 'using': ['id', 'name'], 'value': search_value, 'class': 'form-control', 'useEmpty': true) }}
                                                            {% else %}
                                                                <input type="{{ view['type'] }}" name="{{ name }}" placeholder="{{ view['label'] }}" value="{{ search_value }}" class="form-control" />
                                                            {% endif %}
                                                        {% endif %}
                                                    </td>
                                                {% endfor %}
                                                <td><input type="submit" name="submit" class="btn btn-info" value="{{ t._('Search') }}"></td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            {% for row in data %}
                                                <tr>
                                                    {% for name, view in list_view['fields'] %}
                                                        <td>
                                                            {# check type and render with type #}
                                                            {% include 'view_default/fields_type_list.tpl' %}
                                                        </td>
                                                    {% endfor %}

                                                    <td class="td-actions">
                                                        {% if link_action is null %}
                                                            <a href="{{ url('/'~ carofw['backendUrl'] ~'/' ~ controller ~ '/' ~ action_edit ~ '/' ~  row.id) }}" class="btn btn-warning btn-xs" title="{{ t._('Edit') }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a href="{{ url('/'~ carofw['backendUrl'] ~'/' ~ controller ~ '/' ~ action_delete ~ '/' ~  row.id ~ '/' ~ model_name) }}?return={{ controller }}/{{ action }}" class="btn btn-danger btn-xs" title="{{ t._('Delete') }}">
                                                                <i class="fa fa-remove"></i>
                                                            </a>
                                                        {% else %}
                                                            {% for a in link_action %}
                                                                <a href="<?php echo str_replace('<ID>', $row->id, $a['link']) ?>" class="btn btn-warning btn-xs" title="{{ a['label'] }}">
                                                                    <i class="fa {% if a['icon'] is defined %}{{ a['icon'] }}{% else %}fa-cog{% endif %}"></i>
                                                                </a>
                                                            {% endfor %}
                                                        {% endif %}

                                                    </td>

                                                </tr>
                                            {% endfor %}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- pagination -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="dataTables_info">
                                        <ul class="pagination">
                                            <li class="paginate_button previous"><a href="{{ current_url }}">First</a></li>
                                            <li class="paginate_button previous"><a href="{{ current_url }}&page={{ page.before }}">Previous</a></li>
                                            <li class="paginate_button">
                                                <a href="javascript:;" style="padding: 5px 10px;">
                                                    <select style="margin: 0; width: auto;" onchange="location.href='{{ current_url }}&page=' + $(this).val();">
                                                        {% for i in 1..page.total_pages %}
                                                            <option{% if page.current == i %} selected{% endif %}>{{ i }}</option>
                                                        {% endfor %}
                                                    </select>
                                                </a>
                                            </li>
                                            <li class="paginate_button next"><a href="{{ current_url }}&page={{ page.next }}">Next</a></li>
                                            <li class="paginate_button next"><a href="{{ current_url }}&page={{ page.last }}">Last</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                {{ end_form() }}
            </div>
        </div>
    </div>
</section>