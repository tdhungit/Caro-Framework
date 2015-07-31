<div class="modal-header">
    <h4 class="modal-title">{{ title }}</h4>
</div>

<div class="modal-body">
    <div class="box-content box-table">
        <table class="table table-hover tablesorter">
            <thead>
            <tr>
                {% for name, view in list_view['fields'] %}
                    <th class="header">{{ view['label'] }}</th>
                {% endfor %}
            </tr>
            </thead>

            <tbody>
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
    </div>

    <!-- pagination -->
    <nav class="pagination pagination-centered">
        {% set popupurl = url('/admin/' ~ controller ~ '/' ~ action ~ '/' ~ rel_model ~ '/' ~ current_model ~ '/' ~ current_id ~ '/' ~ subpanel_name) %}
        <ul>
            <li><a href="javascript:;" onclick="caro_pagination_popup('{{ popupurl }}?page={{ page.before }}')">First</a></li>
            <li><a href="javascript:;" onclick="caro_pagination_popup('{{ popupurl }}?page={{ page.before }}')">Previous</a></li>
            <li>
                <a href="javascript:;">
                    <select style="margin: 0; width: auto;" onchange="caro_pagination_popup('{{ popupurl }}?page=' + $(this).val())">
                        {% for i in 1..page.total_pages %}
                            <option{% if page.current == i %} selected{% endif %}>{{ i }}</option>
                        {% endfor %}
                    </select>
                </a>
            </li>
            <li><a href="javascript:;" onclick="caro_pagination_popup('{{ popupurl }}?page={{ page.next }}')">Next</a></li>
            <li><a href="javascript:;" onclick="caro_pagination_popup('{{ popupurl }}?page={{ page.last }}')">Last</a></li>
        </ul>
    </nav>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ t._('Close') }}</button>
</div>