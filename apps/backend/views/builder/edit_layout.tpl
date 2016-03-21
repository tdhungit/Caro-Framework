<section class="content-header">
    <h1>
        {{ t._('Edit Layout') }}: {{ model_name }}
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ t._('Choose Fields') }}</h3>
                </div>
                <div class="box-body">
                    {{ form('/'~carofw['backendUrl']~'/builder/edit_layout/', 'class': 'form-horizontal') }}
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="hidden" name="model_name" value="{{ model_name }}">
                                <table class="table table-bordered table-hover dataTable">
                                    <tr>
                                        <th class="header">{{ t._('Field') }}</th>
                                        <th class="header">{{ t._('Type') }}</th>
                                        <th class="header">{{ t._('Label') }}</th>
                                        <th class="header">{{ t._('Options') }}</th>
                                        <th class="header">{{ t._('Relate') }}</th>
                                        <th class="header">{{ t._('Search') }}</th>
                                        <th class="header">{{ t._('Layout') }}</th>
                                    </tr>
                                    {% for field, options in fields %}
                                        <tr>
                                            <td>{{ field }}</td>
                                            <td>
                                                {% set value = '' %}
                                                {% if  list_fields['fields'][field]['type'] is defined %}
                                                    {% set value = list_fields['fields'][field]['type']  %}
                                                {% endif %}
                                                {{ select('fields['~ field ~'][type]', types, 'class': 'form-control input-sm', 'useEmpty': true, 'value': value) }}
                                            </td>
                                            <td>
                                                {% set value = '' %}
                                                {% if  list_fields['fields'][field]['label'] is defined %}
                                                    {% set value = list_fields['fields'][field]['label']  %}
                                                {% endif %}
                                                <input type="text" name="fields[{{ field }}][label]" class="form-control input-sm" value="{{ value }}">
                                            </td>
                                            <td>
                                                {% set value = '' %}
                                                {% if  list_fields['fields'][field]['options'] is defined %}
                                                    {% set value = list_fields['fields'][field]['options']  %}
                                                {% endif %}
                                                {{ select('fields['~ field ~'][options]', all_lists, 'class': 'form-control input-sm', 'useEmpty': true, 'value': value) }}
                                            </td>
                                            <td>
                                                {% set value = '' %}
                                                {% if  list_fields['fields'][field]['model'] is defined %}
                                                    {% set value = list_fields['fields'][field]['model']  %}
                                                {% endif %}
                                                {{ select('fields['~ field ~'][model]', all_models, 'class': 'form-control input-sm', 'useEmpty': true, 'value': value) }}
                                            </td>
                                            <td>
                                                {% set value = '' %}
                                                {% if  list_fields['fields'][field]['search'] is defined %}
                                                    {% set value = list_fields['fields'][field]['search']  %}
                                                {% endif %}
                                                <select name="fields[{{ field }}][search]" class="form-control input-sm">
                                                    <option value="0">False</option>
                                                    <option value="1" {% if value %}selected{% endif %}>True</option>
                                                </select>
                                            </td>
                                            <td>
                                                {% set c_list_view = 'checked' %}
                                                {% set c_edit_view = 'checked' %}
                                                {% set c_detail_view = 'checked' %}
                                                {% if list_fields['fields'][field]['list'] is not defined and list_fields['fields'][field]['type'] is defined %}
                                                    {% set c_list_view = '' %}
                                                {% endif %}
                                                {% if list_fields['fields'][field]['edit'] is not defined and list_fields['fields'][field]['type'] is defined %}
                                                    {% set c_edit_view = '' %}
                                                {% endif %}
                                                {% if list_fields['fields'][field]['detail'] is not defined and list_fields['fields'][field]['type'] is defined %}
                                                    {% set c_detail_view = '' %}
                                                {% endif %}
                                                <input type="checkbox" name="fields[{{ field }}][list]" {{ c_list_view }}> L |
                                                <input type="checkbox" name="fields[{{ field }}][edit]" {{ c_edit_view }}> E |
                                                <input type="checkbox" name="fields[{{ field }}][detail]" {{ c_detail_view }}> D
                                            </td>
                                        </tr>
                                    {% endfor %}
                                </table>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-info pull-right">{{ t._('Save') }}</button>
                    {{ end_form() }}
                </div>
            </div>
        </div>
    </div>
</section>