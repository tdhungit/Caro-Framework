<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{ title }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/'~carofw['backendUrl']~'/'~controller) }}">{{ t._('List') }}</a></li>
        {% if extra_view_menus is defined %}
            {% for m in extra_view_menus %}
                <li><a href="{{ url('/'~carofw['backendUrl']~m['url']) }}">{{ t._(m['label']) }}</a></li>
            {% endfor %}
        {% endif %}
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                {{ form('/'~ carofw['backendUrl'] ~'/' ~ controller ~ '/save', 'method': 'post', 'class': 'form-horizontal') }}
                    <div class="box-body">
                        <input type="hidden" name="model_name" value="{{ model_name }}">
                        <input type="hidden" name="action_detail" value="{{ action_detail }}">

                        {% if data is not null %}
                            <input type="hidden" name="id" value="{{ data.id }}" />
                        {% endif %}

                        {# check type and render with type #}
                        {% include 'view_default/fields_type_edit.tpl' %}

                        <div class="box-footer">
                            <button type="reset" class="btn pull-right" name="action">{{ t._('Cancel') }}</button>
                            <button id="submit-button" type="submit" class="btn btn-info pull-right" name="action" style="margin-right: 5px;">{{ t._('Save') }}</button>
                        </div>
                    </div>
                {{ end_form() }}
            </div>
        </div>
    </div>
</section>