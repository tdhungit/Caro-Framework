<div class="row">
    <div class="span4">
        <div class="blockoff-right">
            <ul class="nav nav-list">
                <li class="nav-header">Action</li>
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
                    <legend class="lead" style="border: none">No Data</legend>
                {% else %}
                    <legend class="lead" style="border: none">{{ data.readAttribute(detail_view['title']) }}</legend>
                    <table class="table">
                        <tbody>
                        {% for field, field_opt in detail_view['fields'] %}
                            <tr>
                                <td><b>{{ field_opt['label'] }}</b></td>
                                <td>{{ data.readAttribute(field) }}</td>
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
                        <h5>User Groups</h5>
                    </div>
                    <div class="box-content box-table">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                {% for name, view in subpanel_def['list'] %}
                                    <th class="header">{{ view['label'] }}</th>
                                {% endfor %}
                            </tr>
                            </thead>

                            <tbody>
                            {% for row in subpanels[subpanel_name] %}
                                <tr>
                                    {% for name, view in subpanel_def['list'] %}
                                        <td>{{ row.readAttribute(name) }}</td>
                                    {% endfor %}
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