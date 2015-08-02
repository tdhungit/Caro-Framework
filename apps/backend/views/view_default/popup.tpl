<div class="modal-header">
    <h4 class="modal-title">{{ title }}</h4>
</div>

<div class="modal-body">
    <div class="box-content box-table">
        {{ form(current_uri, 'method' : 'get', 'class': 'form-list-search', 'onsubmit': 'caro_popup_search($(this)); return false;') }}
        <table class="table table-hover tablesorter">
            <thead>
            <tr>
                {% for name, view in list_view['fields'] %}
                    <th class="header">{{ view['label'] }}</th>
                {% endfor %}
            </tr>
            </thead>

            <tbody>

            <!-- search -->
            <tr>
                {% for name, view in list_view['fields'] %}
                    <td>
                        {% if view['search'] is defined and view['search'] %}
                            <input type="text" name="{{ name }}" placeholder="{{ view['label'] }}" value="{% if search[name] is defined %}{{ search[name] }}{% endif %}" class="list-search" />
                        {% endif %}
                    </td>
                {% endfor %}
            </tr>

            {% for row in data %}
                <tr>
                    {% for name, view in list_view['fields'] %}
                        <td>
                            <a href="javascript:caro_save_relate('{{ rel_model }}', '{{ row.id }}', '{{ subpanel_name }}', '{{ current_model }}', '{{ current_id }}')">
                                {{ row.readAttribute(name) }}
                            </a>
                        </td>
                    {% endfor %}
                </tr>
            {% endfor %}
            </tbody>
        </table>
        {{ end_form() }}
    </div>

    <!-- pagination -->
    <nav class="pagination pagination-centered">
        <ul>
            <li><a href="javascript:;" onclick="caro_pagination_popup('{{ current_url }}&page={{ page.before }}')">First</a></li>
            <li><a href="javascript:;" onclick="caro_pagination_popup('{{ current_url }}&page={{ page.before }}')">Previous</a></li>
            <li>
                <a href="javascript:;">
                    <select style="margin: 0; width: auto;" onchange="caro_pagination_popup('{{ current_url }}&page=' + $(this).val())">
                        {% for i in 1..page.total_pages %}
                            <option{% if page.current == i %} selected{% endif %}>{{ i }}</option>
                        {% endfor %}
                    </select>
                </a>
            </li>
            <li><a href="javascript:;" onclick="caro_pagination_popup('{{ current_url }}&page={{ page.next }}')">Next</a></li>
            <li><a href="javascript:;" onclick="caro_pagination_popup('{{ current_url }}&page={{ page.last }}')">Last</a></li>
        </ul>
    </nav>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ t._('Close') }}</button>
</div>