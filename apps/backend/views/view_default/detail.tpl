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
    </div>
</div>