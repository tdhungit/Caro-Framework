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
                                {{ form('/admin/' ~ controller ~ '/' ~ action, 'class': 'form-list-search') }}
                                    {% if view['search'] is defined and view['search'] %}
                                        <input type="text" name="{{ name }}" placeholder="{{ view['label'] }}" class="list-search" />
                                    {% endif %}
                                {{ end_form() }}
                            </td>
                        {% endfor %}
                        <td></td>
                    </tr>

                    {% for row in data %}
                        <tr>
                            {% for name, view in list_view['fields'] %}
                                <td>
                                    {% if view['link'] is defined and view['link'] %}
                                        <a href="{{ url('/admin/' ~ controller ~ '/' ~ action_detail ~ '/' ~ row.id) }}">{{ row.readAttribute(name) }}</a>
                                    {% else %}
                                        {{ row.readAttribute(name) }}
                                    {% endif %}
                                </td>
                            {% endfor %}

                            <td class="td-actions">
                                <a href="{{ url('/admin/' ~ controller ~ '/' ~ action_edit ~ '/' ~  row.id) }}" class="btn btn-small btn-warning">
                                    <i class="btn-icon-only icon-edit"></i>
                                </a>

                                <a href="{{ url('/admin/' ~ controller ~ '/' ~ action_delete ~ '/' ~  row.id) }}" class="btn btn-small btn-danger">
                                    <i class="btn-icon-only icon-remove"></i>
                                </a>

                            </td>

                        </tr>
                    {% endfor %}
                    </tbody>
                </table>

            </div>

        </div>

        <!-- pagination -->
        <nav class="pagination pagination-centered">
            <ul>
                <li><a href="{{ url('/admin/' ~ controller ~ '/' ~ action) }}">First</a></li>
                <li><a href="{{ url('/admin/' ~ controller ~ '/' ~ action) }}?page={{ page.before }}">Previous</a></li>
                <li>
                    <a href="javascript:;">
                        <select style="margin: 0; width: auto;" onchange="location.href='{{ url('/admin/' ~ controller ~ '/' ~ action) }}?page=' + $(this).val();">
                            {% for i in 1..page.total_pages %}
                                <option{% if page.current == i %} selected{% endif %}>{{ i }}</option>
                            {% endfor %}
                        </select>
                    </a>
                </li>
                <li><a href="{{ url('/admin/' ~ controller ~ '/' ~ action) }}?page={{ page.next }}">Next</a></li>
                <li><a href="{{ url('/admin/' ~ controller ~ '/' ~ action) }}?page={{ page.last }}">Last</a></li>
            </ul>
        </nav>

    </div>

</div>