<div class="row">
    <div class="span4">
        <div class="blockoff-right">
            <ul class="nav nav-list">
                <li class="nav-header">Action</li>
                <li class="active">
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
            <div class="box-header">
                <i class="icon-user icon-large"></i>
                <h5>Users</h5>
            </div>

            <div class="box-content box-table">
                <table class="table table-hover tablesorter">
                    <thead>
                    <tr>
                        {% for name, view in list_view %}
                            <th class="header">{{ view['label'] }}</th>
                        {% endfor %}
                    </tr>
                    </thead>

                    <tbody>
                    {% for row in data %}
                        <tr>
                            {% for name, view in list_view %}
                                <td>
                                    {% if view['link'] is defined and view['link'] %}
                                        <a href="{{ url('/admin') }}/{{ controller }}/detail/{{ row.id }}">{{ row.readAttribute(name) }}</a>
                                    {% else %}
                                        {{ row.readAttribute(name) }}
                                    {% endif %}
                                </td>
                            {% endfor %}
                        </tr>
                    {% endfor %}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>