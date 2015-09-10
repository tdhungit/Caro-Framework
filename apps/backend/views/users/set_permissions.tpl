<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ t._('Set permissions for Role') }}: {{ role.name }}
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-content box-table">
                    {{ form('/'~ carofw['backendUrl'] ~'/users/set_permissions', 'method': 'post') }}
                        <input type="hidden" name="role_id" value="{{ role_id }}">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>{{ t._('Resources') }}</td>
                                <td>{{ t._('Access') }}</td>
                            </tr>
                            </thead>

                            <tbody>
                            {% for resource, access in resources %}
                                <tr>
                                    <td width="20%"><input type="checkbox" class="check-all-{{ resource }}"> {{ resource }}</td>
                                    <td class="check-all-content-{{ resource }}">
                                        {% for method, is_access in access %}
                                            <div style="width: 150px; display: inline-block">
                                                <input type="checkbox" name="resources[{{ resource }}][{{ method }}]" value="1" {% if is_access == 1 %}checked{% endif %}>
                                                <span {% if is_access == 1 %}style="font-weight: 700; color: #3c8dbc"{% endif %}>{{ method }}</span>
                                            </div>
                                        {% endfor %}
                                        <script>
                                            $(".check-all-{{ resource }}").change(function () {
                                                $(".check-all-content-{{ resource }} input:checkbox").prop('checked', $(this).prop("checked"));
                                            });
                                        </script>
                                    </td>
                                </tr>
                            {% endfor %}
                            <tr>
                                <td></td>
                                <td><input type="submit" name="submit" value="{{ t._('Save') }}" class="btn btn-primary"></td>
                            </tr>
                            </tbody>
                        </table>
                    {{ end_form() }}
                </div>
            </div>
        </div>
    </div>
</section>