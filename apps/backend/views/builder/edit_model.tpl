<section class="content-header">
    <h1>
        {{ t._('Edit Model') }}: {{ model_name }}
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-body">
                    <div class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-md-12">
                                {{ form('/'~carofw['backendUrl']~'/builder/update_fields/', 'class': 'form-horizontal') }}
                                    <input type="hidden" name="model" value="{{ model_name }}">
                                    <div style="padding-bottom: 10px">
                                        <input name="add_field_name" id="add_field_name" class="form-control" type="text" value="" placeholder="{{ t._('Field Name') }}" />
                                        &nbsp;&nbsp;{{ t._('Field Type') }}: {{ select('add_field_type', types, 'class': 'form-control') }}
                                        <input name="add_field_size" id="add_field_size" class="form-control" type="text" value="" placeholder="{{ t._('Field Size') }}" />
                                        &nbsp;&nbsp;{{ t._('Not Null') }}: {{ select('add_notnull', [0, 1], 'class': 'form-control', 'id': 'add_notnull') }}
                                        &nbsp;&nbsp;<button type="button" class="btn btn-info" onclick="addField()">{{ t._('Add') }}</button>
                                    </div>

                                    <table class="table table-bordered table-hover dataTable">
                                        <thead>
                                            <tr role="row">
                                                <th class="header">Field Name</th>
                                                <th class="header">Field Type</th>
                                                <th class="header">Field Size</th>
                                                <th class="header">Not Null</th>
                                            </tr>
                                        </thead>
                                        <tbody id="fields-options">
                                            {% for field_name, field in table['fields'] %}
                                                <tr id="tr-{{ field_name }}">
                                                    <td>
                                                        <span class="field_detail fname">{{ field_name }}</span>
                                                        <span class="field_edit">
                                                            <input name="fields[{{ field_name }}][name]" class="form-control fname" type="text" value="{{ field_name }}" />
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="field_detail ftype">{{ types[field['type']] }}</span>
                                                        <span class="field_edit">
                                                            {{ select('fields['~field_name~'][type]', types, 'class': 'form-control ftype', 'value': field['type']) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="field_detail fsize">{% if field['size'] is defined %}{{ field['size'] }}{% endif %}</span>
                                                        <span class="field_edit">
                                                            <input name="fields[{{ field_name }}][size]" class="form-control fsize" type="text" value="{% if field['size'] is defined %}{{ field['size'] }}{% endif %}" />
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="field_detail fnotnull">
                                                            <span>{% if field['notNull'] is defined %}{{ field['notNull'] }}{% endif %}</span>
                                                            <i class="fa fa-fw fa-remove" style="float: right; padding-top: 4px; cursor: pointer;" onclick="deleteField('{{ field_name }}')"></i>
                                                            <i class="fa fa-fw fa-edit" style="float: right; padding-top: 5px; cursor: pointer;" onclick="editField('{{ field_name }}')"></i>
                                                        </span>
                                                        <span class="field_edit">
                                                            {{ select('fields['~field_name~'][notnull]', [0, 1], 'class': 'form-control fnotnull', 'value': field['notNull']) }}
                                                            <i class="fa fa-fw fa-check" style="float: right; padding-top: 5px; cursor: pointer;" onclick="doneField('{{ field_name }}')"></i>
                                                        </span>
                                                    </td>
                                                </tr>
                                            {% endfor %}
                                        </tbody>
                                    </table>

                                    <h3>
                                        {{ t._('Indexes') }}
                                        <i class="fa fa-fw fa-plus" style="cursor: pointer" onclick="addIndex('{{ model_name }}');"></i>
                                        <input type="hidden" name="index_number" id="index_number" value="1">
                                    </h3>
                                    <table class="table table-bordered table-hover dataTable">
                                        <thead>
                                            <tr role="row">
                                                <th class="header">Index Name</th>
                                                <th class="header">Index Type</th>
                                                <th class="header">Index Fields</th>
                                            </tr>
                                        </thead>
                                        <tbody id="indexes-options">
                                            {% for index_name, index in table['indexes'] %}
                                                <tr id="indexes-tr-{{ index_name }}">
                                                    <td>
                                                        {{ index_name }}
                                                        <input type="hidden" name="indexes[{{ index_name }}][name]" value="{{ index_name }}">
                                                    </td>
                                                    <td>
                                                        {{ index['type'] }}
                                                        <input type="hidden" name="indexes[{{ index_name }}][type]" value="{{ index['type'] }}">
                                                    </td>
                                                    <td>
                                                        {{ index['fields'] | join(", ") }}
                                                        <input type="hidden" name="indexes[{{ index_name }}][fields]" value="{{ index['fields'] | join(",") }}">
                                                        <i class="fa fa-fw fa-remove" style="float: right; padding-top: 4px; cursor: pointer;" onclick="deleteIndex('{{ index_name }}')"></i>
                                                    </td>
                                                </tr>
                                            {% endfor %}
                                        </tbody>
                                    </table>

                                    <button type="submit" class="btn btn-info pull-right">{{ t._('Save') }}</button>
                                {{ end_form() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .field_edit {display: none}
</style>

<script>
    function editField(field_name) {
        $('#tr-'+field_name+' .field_detail').hide();
        $('#tr-'+field_name+' .field_edit').show();
    }

    function deleteField(field_name) {
        $('#tr-'+field_name).remove();
    }

    function doneField(field_name) {
        var detail = '#tr-'+field_name+' .field_detail';
        var edit = '#tr-'+field_name+' .field_edit';

        $(detail+'.fname').html($(edit+ ' .fname').val());
        $(detail+'.ftype').html($(edit+ ' .ftype option:selected').text());
        $(detail+'.fsize').html($(edit+ ' .fsize').val());
        $(detail+'.fnotnull span').html($(edit+ ' .fnotnull option:selected').text());

        $(detail).show();
        $(edit).hide();
    }

    function addField() {
        var name = $('#add_field_name').val();
        var type = $('#add_field_type').val();
        var field_size = $('#add_field_size').val();
        var notnull = $('#add_notnull').val();
        var aurl = '{{ url('/'~carofw['backendUrl']~'/builder/') }}ajax_add_field/' + name + '/' + type + '/' + field_size + '/' + notnull;
        $.get(aurl, function(data) {
            $('#fields-options').append(data);
        });
    }

    function addIndex(model) {
        var number = $('#index_number').val();
        $('#index_number').val(parseInt(number) + 1);
        var aurl = '{{ url('/'~carofw['backendUrl']~'/builder/') }}ajax_add_index/' + model + '/' + number;
        $.get(aurl, function(data) {
            $('#indexes-options').append(data);
        });
    }

    function selectedField(number, o) {
        var field = $(o).val();
        var current = $('#add-fields-'+ number).val();
        var current_show = $('#value-field_name'+number).html();
        var fields = '';
        var fields_show = '';
        if (current) {
            fields = current + ',' + field;
            fields_show  = current_show + ', ' + field;
        } else {
            fields = field;
            fields_show = field;
        }
        $('#add-fields-'+ number).val(fields);
        $('#value-field_name'+number).html(fields_show);
    }

    function deleteIndex(index_name) {
        $('#indexes-tr-'+index_name).remove();
    }
</script>