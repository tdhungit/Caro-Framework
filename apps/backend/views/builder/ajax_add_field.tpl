<tr id="tr-{{ field_name }}">
    <td>
        <span class="field_detail fname">{{ field_name }}</span>
        <span class="field_edit">
            <input name="field_name[]" class="form-control fname"
                   type="text" value="{{ field_name }}"/>
        </span>
    </td>
    <td>
        <span class="field_detail ftype">{{ types[field_type] }}</span>
        <span class="field_edit">
            {{ select('field_type[]', types, 'class': 'form-control ftype', 'value': field_type) }}
        </span>
    </td>
    <td>
        <span class="field_detail fsize">{{ field_size }}</span>
        <span class="field_edit">
            <input name="field_size[]" class="form-control fsize"
                   type="text"
                   value="{{ field_size }}"/>
        </span>
    </td>
    <td>
        <span class="field_detail fnotnull">
            <span>{{ notnull }}</span>
            <i class="fa fa-fw fa-edit"
               style="float: right; padding-top: 5px; cursor: pointer;"
               onclick="editField('{{ field_name }}')"></i>
        </span>
        <span class="field_edit">
            {{ select('notnull[]', [0, 1], 'class': 'form-control fnotnull', 'value': notnull) }}
            <i class="fa fa-fw fa-check"
               style="float: right; padding-top: 5px; cursor: pointer;"
               onclick="doneField('{{ field_name }}')"></i>
        </span>
    </td>
</tr>