<div class="row">
    <div class="span4">
        <div class="blockoff-right">
            <ul class="nav nav-list">
                <li class="nav-header">Action</li>
                <li>
                    <a href="{{ url('/admin') }}/{{ controller }}/list">
                        <i class="icon-chevron-right pull-right"></i>
                        View Users
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin') }}/{{ controller }}/edit">
                        <i class="icon-chevron-right pull-right"></i>
                        Create User
                    </a>
                </li>
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