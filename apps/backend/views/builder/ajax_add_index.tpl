<tr id="indexes-tr-{{ number }}">
    <td>
        <input type="text" name="indexes[{{ number }}][name]" id="index_name{{ number }}" value="">
    </td>
    <td>
        {{ select('indexes['~ number ~'][type]', ['Index':'Index', 'Unique':'Unique'], 'class': 'form-control') }}
    </td>
    <td>
        <div id="value-field_name{{ number }}"></div>
        {{ select('draft-fields', fields, 'class': 'form-control', 'id': 'draft-field_name'~number, 'useEmpty': true, 'onchange': "selectedField('"~ number ~"', this)") }}
        <input type="hidden" name="indexes[{{ number }}][fields]" value="" id="add-fields-{{ number }}">
        <i class="fa fa-fw fa-remove" style="float: right; padding-top: 4px; cursor: pointer;" onclick="deleteIndex('{{ number }}')"></i>
    </td>
</tr>