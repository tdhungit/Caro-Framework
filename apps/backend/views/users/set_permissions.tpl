<div class="row">
    <div class="span4">

    </div>

    <div class="span12">
        <div class="box">
            <div class="box-header">
                <i class="icon-list"></i>
                <h5>Set permissions for Role: {{ role_id }}</h5>
            </div>

            <div class="box-content box-table">
                {{ form('/admin/users/set_permissions', 'method': 'post') }}
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
                            <td>{{ resource }}</td>
                            <td>
                                {% for method, is_access in access %}
                                    <div>
                                        <input type="checkbox" name="resources[{{ resource }}][{{ method }}]" value="1" {% if is_access == 1 %}checked{% endif %}>
                                        {{ method }}
                                    </div>
                                {% endfor %}
                            </td>
                        </tr>
                    {% endfor %}
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" value="{{ t._('Save') }}"></td>
                    </tr>
                    </tbody>
                </table>
                {{ end_form() }}
            </div>
        </div>
    </div>
</div>