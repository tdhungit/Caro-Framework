<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>{{ title }}</h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                {{ form('/'~ carofw['backendUrl'] ~'/builder/import_csv', 'method': 'post', 'class': 'form-horizontal') }}
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">{{ t._('Model import') }}<span class="required">*</span></label>
                        <div class="col-sm-10">
                            {{ select('model', models, 'using': ['name', 'name'], 'class': 'form-control', 'useEmpty': true, 'id': 'model-import') }}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">{{ t._('CSV File') }}<span class="required">*</span></label>

                        <div class="col-sm-10">
                            <div class="caro-csv-name" style="padding-bottom: 5px;"></div>
                            <span class="btn btn-default btn-file">
                                Browse <input type="file" id="caro-upload-csv" location="csv">
                                <input type="hidden" name="csv_file" class="caro-value-upload" value="">
                            </span>
                        </div>
                    </div>

                    <div id="map-fields-content"></div>

                    <div class="form-group" id="button-next-step" style="display: none;">
                        <label class="col-sm-2 control-label"></label>
                        <div class="col-sm-10">
                            <input type="hidden" name="full_path_csv_file" id="full-path-csv-file" value="">
                            <button type="button" class="btn btn-info">{{ t._('Next') }}</button>
                        </div>
                    </div>

                    <div class="box-footer" id="button-import-csv" style="display: none">
                        <button type="reset" class="btn pull-right" name="action" onclick="location.reload();">{{ t._('Cancel') }}</button>
                        <button id="submit-button" type="submit" class="btn btn-info pull-right" name="action" style="margin-right: 5px;">{{ t._('Save') }}</button>
                    </div>
                </div>
                {{ end_form() }}
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function () {
        $('#caro-upload-csv').change(function () {
            $this = $(this);
            var formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            formData.append('location', $(this).attr('location'));
            $.ajax({
                type: "POST",
                url: backend_url + "/index/upload",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (json) {
                    $this.siblings('.caro-value-upload').val(json.data[0].path);
                    $this.parent().siblings('.caro-csv-name').html(json.data[0].name);
                    $('#full-path-csv-file').val(json.data[0].folder + json.data[0].name);
                    $('#button-next-step').show();
                }
            });
        });

        $('#button-next-step').click(function () {
            $.post(backend_url + "/builder/load_csv_import", {
                csv_file: $('#full-path-csv-file').val(),
                model: $('#model-import').val()
            }, function (data) {
                $('#map-fields-content').html(data);
                $('#button-next-step').hide();
                $('#button-import-csv').show();
            });
        });
    });
</script>