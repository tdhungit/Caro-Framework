<h2>{{ t._('Mapping fields') }}</h2>

{% for h in header %}
<div class="form-group">
    <label class="col-sm-2 control-label">{{ h }}</label>
    <div class="col-sm-10">
        {{ select('change_fields['~h~']', fields, 'using': ['id', 'name'], 'class': 'form-control', 'useEmpty': true) }}
    </div>
</div>
{% endfor %}