<div class="modal-header">
    <h4 class="modal-title">{{ rel_model }}</h4>
</div>

<div class="modal-body">
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
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>