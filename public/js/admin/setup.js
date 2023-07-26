$(document).ready(function () {
    // City Tab-1 Start
    let dtblCity = $('#dtblCity').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: true,//server side pagination
        bServerSide: true,//server side pagination
        ajax: {
            "url": "GetCityList",
            "type": "GET"
        },
        bStateSave: false,
        bPaginate: true,
        bLengthChange: true,
        bFilter: true,
        bSort: false,
        bInfo: true,
        bAutoWidth: false,
        bDestroy: true,
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5'B><'col-lg-3 col-md-3 col-sm-3'l><'col-lg-4 col-md-4 col-sm-4'f>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9'i><'col-lg-3 col-md-3 col-sm-3'p>>",
        "aoColumns": [
            { "data": 'sl_no', "name": "sl_no", "sWidth": "15%", "className": "text-center" },
            { "data": 'city_name', "name": "city_name", "sWidth": "50%" },
            {
                "data": 'status', "name": "status", "sWidth": "15%", "className": "text-center",
                mRender: function (data, type, val) {
                    if (val.status) {
                        return `<i class='fa fa-check' style='color:green; font-weight:bolder'></i>`;
                    }
                    else {
                        return `<i class='fa fa-times' style='color:red; font-weight:bolder'></i>`;
                    }
                }
            },
            {
                "data": null, "name": "action", "sWidth": "20%", "className": "text-center",
                "defaultContent": `<button class='btn btn-warning btn-sm action-btn' onclick='UpdateCity(event)'><i class='fa fa-edit'></i></button>`
            }
        ],
        buttons: [{
            text: '<button id="addCity" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>',
        }
        ]
    });
    $("#addCity").click(function () {
        $("#modalCityHeader").html('Add City/Town');
        $("#txtCityId").val('');
        $("#txtCityName").val('');
        $("#txtCityActive").prop("checked", true);
        $("#btnSaveCity").html('<i class="fa fa-save"></i>&nbsp;Save');
        $("#btnSaveCity").removeAttr('disabled');
        $('#modalCity').modal('show');
    });
    $("#btnSaveCity").click(function () {
        $("#btnSaveCity").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Saving...');
        $("#btnSaveCity").attr('disabled', true);

        let _token = $("#_token").val();
        let city_id = $("#txtCityId").val();
        let city_name = $("#txtCityName").val();
        let city_status = 0
        if ($("#txtCityActive").prop("checked")) {
            city_status = 1
        }
        $.ajax({
            url: "SaveCity",
            type: "POST",
            data: {
                _token: _token, city_id: city_id, city_name: city_name, city_status: city_status
            },
            success: function (response) {
                if (response.status == 'Success') {
                    $("#btnSaveCity").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveCity").removeAttr('disabled');
                    $('#modalCity').modal('hide');
                    LoadCitySelectize();
                    dtblCity.ajax.reload();
                    toastr.success(response.message);
                } else if (response.status == 'Error') {
                    $("#btnSaveCity").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveCity").removeAttr('disabled');
                    toastr.warning(response.message);
                } else {
                    $("#btnSaveCity").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveCity").removeAttr('disabled');
                    toastr.error(response.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
    //Area Tab-2 Start
    LoadCitySelectize();
    $("#selCity").change(function () {
        LoadAreaDataTable();
    });
    let dtblArea = $('#dtblArea').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: false,//server side pagination
        bServerSide: false,//server side pagination
        bStateSave: false,
        bPaginate: true,
        bLengthChange: true,
        bFilter: true,
        bSort: false,
        bInfo: true,
        bAutoWidth: false,
        bDestroy: true,
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5'B><'col-lg-3 col-md-3 col-sm-3'l><'col-lg-4 col-md-4 col-sm-4'f>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9'i><'col-lg-3 col-md-3 col-sm-3'p>>",
        "aoColumns": [
            { "data": 'sl_no', "name": "sl_no", "sWidth": "10%", "className": "text-center" },
            { "data": 'city.city_name', "name": "city.city_name", "sWidth": "35%" },
            { "data": 'area_name', "name": "area_name", "sWidth": "40%" },
            {
                "data": 'status', "name": "status", "sWidth": "5%", "className": "text-center",
                mRender: function (data, type, val) {
                    if (val.status) {
                        return `<i class='fa fa-check' style='color:green; font-weight:bolder'></i>`;
                    }
                    else {
                        return `<i class='fa fa-times' style='color:red; font-weight:bolder'></i>`;
                    }
                }
            },
            {
                "data": null, "name": "action", "sWidth": "10%", "className": "text-center",
                "defaultContent": `<button class='btn btn-warning btn-sm action-btn' onclick='UpdateArea(event)'><i class='fa fa-edit'></i></button>`
            }
        ],
        buttons: [{
            text: '<button id="addArea" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>',
        }
        ]
    });
    $("#addArea").click(function () {
        if ($('#selCity').val() == '') {
            toastr.error('Please Select a City/Town');
        } else {
            $("#modalAreaHeader").html('Add Area');
            $("#txtAreaId").val('');
            $("#txtAreaName").val('');
            $("#txtAreaActive").prop("checked", true);
            $("#btnSaveArea").html('<i class="fa fa-save"></i>&nbsp;Save');
            $("#btnSaveArea").removeAttr('disabled');
            $('#modalArea').modal('show');
        }
    });
    $("#btnSaveArea").click(function () {
        $("#btnSaveArea").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Saving...');
        $("#btnSaveArea").attr('disabled', true);

        let _token = $("#_token").val();
        let area_id = $("#txtAreaId").val();
        let area_name = $("#txtAreaName").val();
        let city_id = $("#selCity").val();
        let area_status = 0
        if ($("#txtAreaActive").prop("checked")) {
            area_status = 1
        }
        $.ajax({
            url: "SaveArea",
            type: "POST",
            data: {
                _token: _token, area_id: area_id, area_name: area_name, city_id: city_id, area_status: area_status
            },
            success: function (response) {
                if (response.status == 'Success') {
                    $("#btnSaveArea").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveArea").removeAttr('disabled');
                    $('#modalArea').modal('hide');
                    LoadAreaDataTable()
                    toastr.success(response.message);
                } else if (response.status == 'Error') {
                    $("#btnSaveArea").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveArea").removeAttr('disabled');
                    toastr.warning(response.message);
                } else {
                    $("#btnSaveArea").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveArea").removeAttr('disabled');
                    toastr.error(response.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    })
    // House Type Tab-3 Start
    LoadHouseTypeDataTable();
    let dtblHouseType = $('#dtblHouseType').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: false,//server side pagination
        bServerSide: false,//server side pagination
        bStateSave: false,
        bPaginate: true,
        bLengthChange: true,
        bFilter: true,
        bSort: false,
        bInfo: true,
        bAutoWidth: false,
        bDestroy: true,
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5'B><'col-lg-3 col-md-3 col-sm-3'l><'col-lg-4 col-md-4 col-sm-4'f>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9'i><'col-lg-3 col-md-3 col-sm-3'p>>",
        "aoColumns": [
            { "data": 'sl_no', "name": "sl_no", "sWidth": "10%", "className": "text-center" },
            { "data": 'type', "name": "type", "sWidth": "70%" },
            {
                "data": 'status', "name": "status", "sWidth": "10%", "className": "text-center",
                mRender: function (data, type, val) {
                    if (val.status) {
                        return `<i class='fa fa-check' style='color:green; font-weight:bolder'></i>`;
                    }
                    else {
                        return `<i class='fa fa-times' style='color:red; font-weight:bolder'></i>`;
                    }
                }
            },
            {
                "data": null, "name": "action", "sWidth": "10%", "className": "text-center",
                "defaultContent": `<button class='btn btn-warning btn-sm action-btn' onclick='UpdateHouseType(event)'><i class='fa fa-edit'></i></button>`
            }
        ],
        buttons: [{
            text: '<button id="addHouseType" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>',
        }
        ]
    });
    $("#addHouseType").click(function () {
        $("#modalHouseTypeHeader").html('Add HouseType');
        $("#txtHouseTypeId").val('');
        $("#txtHouseTypeName").val('');
        $("#txtHouseTypeActive").prop("checked", true);
        $("#btnSaveHouseType").html('<i class="fa fa-save"></i>&nbsp;Save');
        $("#btnSaveHouseType").removeAttr('disabled');
        $('#modalHouseType').modal('show');
    });
    $("#btnSaveHouseType").click(function () {
        $("#btnSaveHouseType").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Saving...');
        $("#btnSaveHouseType").attr('disabled', true);

        let _token = $("#_token").val();
        let id = $("#txtHouseTypeId").val();
        let type = $("#txtHouseTypeName").val();
        let type_status = 0
        if ($("#txtHouseTypeActive").prop("checked")) {
            type_status = 1
        }
        $.ajax({
            url: "SaveHouseType",
            type: "POST",
            data: {
                _token: _token, id: id, type: type, type_status: type_status
            },
            success: function (response) {
                if (response.status == 'Success') {
                    $("#btnSaveHouseType").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveHouseType").removeAttr('disabled');
                    $('#modalHouseType').modal('hide');
                    LoadHouseTypeDataTable()
                    toastr.success(response.message);
                } else if (response.status == 'Error') {
                    $("#btnSaveHouseType").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveHouseType").removeAttr('disabled');
                    toastr.warning(response.message);
                } else {
                    $("#btnSaveHouseType").html('<i class="fa fa-save"></i>&nbsp;Save');
                    $("#btnSaveHouseType").removeAttr('disabled');
                    toastr.error(response.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    })
});
// City Tab-1 Start
function UpdateCity(event) {
    var dtblCity = $('#dtblCity').dataTable();
    $(dtblCity.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalCityHeader").html('Update City/Town');
    $("#btnSaveCity").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveCity").removeAttr('disabled');

    $("#txtCityId").val(dtblCity.fnGetData(row)['id']);
    $("#txtCityName").val(dtblCity.fnGetData(row)['city_name']);
    if (dtblCity.fnGetData(row)['status']) {
        $("#txtCityActive").prop("checked", true);
    } else {
        $("#txtCityInactive").prop("checked", true);
    }
    $('#modalCity').modal('show');
}
// Area Tab-2 Start
function LoadCitySelectize() {
    $.ajax({
        url: "GetCity",
        type: "GET",
        success: function (response) {
            var $select = $('#selCity').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            $.each(response.aaData, function (i, data) {
                selectize.addOption({ value: data.id, text: data.city_name });
            });
        },
        error: function () {
            toastr.error('Unable to load location selectize');
        }
    });
}
function LoadAreaDataTable() {
    let city_id = $("#selCity").val();
    $.ajax({
        "url": "GetAreaList",
        type: "get",
        data: { city_id: city_id },
        success: function (response) {
            var table = $('#dtblArea').DataTable();
            table.clear().draw();
            table.rows.add(response.aaData).draw();
        },
        error: function () {
            toastr.error('Unable to table please contact support');
        }
    });
}
function UpdateArea(event) {
    var dtblArea = $('#dtblArea').dataTable();
    $(dtblArea.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalAreaHeader").html('Update Area');
    $("#btnSaveArea").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveArea").removeAttr('disabled');

    $("#txtAreaId").val(dtblArea.fnGetData(row)['id']);
    $("#txtAreaName").val(dtblArea.fnGetData(row)['area_name']);
    if (dtblArea.fnGetData(row)['status']) {
        $("#txtAreaActive").prop("checked", true);
    } else {
        $("#txtAreaInactive").prop("checked", true);
    }
    $('#modalArea').modal('show');
}

// House Type Tab-3 Start
function LoadHouseTypeDataTable() {
    $.ajax({
        "url": "GetHouseTypeList",
        type: "get",
        success: function (response) {
            var table = $('#dtblHouseType').DataTable();
            table.clear().draw();
            table.rows.add(response.aaData).draw();
        },
        error: function () {
            toastr.error('Unable to table please contact support');
        }
    });
}

function UpdateHouseType(event) {
    var dtblHouseType = $('#dtblHouseType').dataTable();
    $(dtblHouseType.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalHouseTypeHeader").html('Update House Type');
    $("#btnSaveHouseType").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveHouseType").removeAttr('disabled');

    $("#txtHouseTypeId").val(dtblHouseType.fnGetData(row)['id']);
    $("#txtHouseTypeName").val(dtblHouseType.fnGetData(row)['type']);
    if (dtblHouseType.fnGetData(row)['status']) {
        $("#txtHouseTypeActive").prop("checked", true);
    } else {
        $("#txtHouseTypeInactive").prop("checked", true);
    }
    $('#modalHouseType').modal('show');
}