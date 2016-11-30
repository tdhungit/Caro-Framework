<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ title }}
    </h1>
	<ol class="breadcrumb">
        <li><a href="{{ url('/'~carofw['backendUrl']~'/'~controller) }}">{{ t._('List') }}</a></li>
		<li><a href="{{ url('/'~carofw['backendUrl']~'/'~controller~'/'~action_edit~'/'~data.id) }}">{{ t._('Edit') }}</a></li>
		{% if link_detail %}
			{% for link in link_detail %}
				<li><a href="{{ link['url'] }}">{{ t._(link['label']) }}</a></li>
			{% endfor %}
		{% endif %}
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
            <div class="box">
                <div class="box-content">
                    {% if data is not null %}
                        <table class="table">
                            <tbody>
                            {% for name, view in detail_view['fields'] %}
                                <tr>
                                    <td width="33%"><b>{{ view['label'] }}</b></td>
                                    <td>
                                        {# check type and render with type #}
                                        {% include 'view_default/fields_type_detail.tpl' %}
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
                            <h3 class="box-title">{{ t._(subpanel_def['rel_model']) }}</h3>

                            {% if subpanel_def['buttons'] is defined and subpanel_def['buttons'] %}
                                <div class="box-tools">
                                    <a class="btn btn-box-right" href="javascript:caro_list_relate('{{ subpanel_def['rel_model'] }}', '{{ subpanel_def['current_model'] }}', '{{ data.id }}', '{{ subpanel_name }}')">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            {% endif %}
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
                                            <a href="javascript:caro_remove_relate('{{ subpanel_def['rel_model'] }}', '{{ row.id }}', '{{ subpanel_name }}', '{{ subpanel_def['current_model'] }}', '{{ data.id }}')" class="btn btn-danger btn-xs">
                                                <i class="fa fa-remove"></i>
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
</section>