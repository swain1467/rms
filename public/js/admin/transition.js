$(document).ready(function () {
    // LoadCitySelectize();
    // LoadHouseTypeSelectize();
    // $("#selHDCity").change(function () {
    //     LoadAreaSelectize();
    // });
    $('#txtAvailableFromDate').datepicker({
        format: "dd-M-yyyy",
        todayHighlight: true,
        autoclose: true,
        startDate: '+1d',
        endDate: '+30d'
    });
    $('#txtAvailableFromDate').keydown(function (e) {
        e.preventDefault();
        return false;
    });

    let dtblHD = $('#dtblHD').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: true,//server side pagination
        bServerSide: true,//server side pagination
        ajax: {
            "url": "GetHouseDetailsList",
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
            { "data": 'sl_no', "name": "sl_no", "sWidth": "10%", "className": "text-center" },
            { "data": 'user.email', "name": "user.email", "sWidth": "15%" },
            { "data": 'contact_no', "name": "contact_no", "sWidth": "10%", "className": "text-center" },
            { "data": 'from_date', "name": "from_date", "sWidth": "10%", "className": "text-center" },
            { "data": 'type.type', "name": "type.type", "sWidth": "10%" },
            { "data": 'area.area_name', "name": "area.area_name", "sWidth": "15%" },
            { "data": 'city.city_name', "name": "city.city_name", "sWidth": "15%" },
            {
                "data": null, "name": "action", "sWidth": "15%", "className": "text-center",
                "defaultContent": `<button class='btn btn-warning btn-sm action-btn' onclick='UpdateHD(event)'><i class='fa fa-edit'></i></button>`
            }
        ],
        buttons: [{
            text: `<button id="addCity" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>
            &nbsp; <button id="addCity" class="btn btn-dark btn-sm"><i class="fa fa-upload"></i>&nbsp;Bulk Upload</button>`,
        }
        ]
    });

    $("#btnSaveHD").click(function () {
        $("#btnSaveHD").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Updating...');
        $("#btnSaveHD").attr('disabled', true);

        let house_id = $("#txtHDId").val();
        let city = $("#selHDCity").val();
        let area = $("#selHDArea").val();
        let house_type = $("#selHDHouseType").val();
        let advance = $("#txtHDAdvance").val();
        let rent = $("#txtHDRentAmount").val();
        let from_date = $("#txtHDAvailableFromDate").val();
        let address = $("#txtHDDetailedAddress").val();
        var contact = $("#txtHDContactNo").val();
        let hd_status = 0
        if ($("#txtHDActive").prop("checked")) {
            hd_status = 1
        }
        $.ajax({
            url: "../api/AdminTransition?action=UpdateHouseDetails",
            type: "POST",
            data: {
                house_id: house_id, city: city, area: area, house_type: house_type, advance: advance,
                rent: rent, from_date: from_date, contact: contact, address: address, hd_status: hd_status
            },
            success: function (response) {
                var res = jQuery.parseJSON(response);
                if (res.status == 'Success') {
                    dtblHD.ajax.reload();
                    toastr.success(res.message);
                    $("#btnSaveHD").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveHD").removeAttr('disabled');
                    $('#modalHD').modal('hide');
                } else if (res.status == 'Error') {
                    $("#btnSaveHD").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveHD").removeAttr('disabled');
                    toastr.warning(res.message);
                } else {
                    $("#btnSaveHD").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveHD").removeAttr('disabled');
                    toastr.error(res.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
});
function LoadCitySelectize() {
    $.ajax({
        url: "../api/AdminSetup?action=GetCity",
        type: "GET",
        success: function (response) {
            var $select = $('#selHDCity').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            var res1 = JSON.parse(response);
            $.each(res1.aaData, function (i, data) {
                selectize.addOption({ value: data.city_id, text: data.city_name });
            });
        },
        error: function () {
            toastr.error('Unable to load location selectize');
        }
    });
}
function LoadAreaSelectize() {
    let city_id = $("#selHDCity").val();
    $.ajax({
        "url": "../api/AdminSetup?action=GetAreaList",
        type: "get",
        data: { city_id: city_id },
        success: function (response) {
            var $select = $('#selHDArea').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            var res1 = JSON.parse(response);
            $.each(res1.aaData, function (i, data) {
                if (data.status != 0) {
                    selectize.addOption({ value: data.id, text: data.area_name });
                }
            });
            //This is a conditional selectize
            if ($("#hidHDArea").val()) {
                $('#selHDArea').selectize()[0].selectize.setValue($("#hidHDArea").val());
            }
            $("#hidHDArea").val('');
        },
        error: function () {
            toastr.error('Unable to Area selectize');
        }
    });
}
function LoadHouseTypeSelectize() {
    $.ajax({
        url: "../api/AdminSetup?action=GetHouseTypeList",
        type: "GET",
        success: function (response) {
            var $select = $('#selHDHouseType').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            var res1 = JSON.parse(response);
            $.each(res1.aaData, function (i, data) {
                if (data.status != 0) {
                    selectize.addOption({ value: data.id, text: data.house_type });
                }
            });
        },
        error: function () {
            toastr.error('Unable to load House Type selectize');
        }
    });
}
function UpdateHD(event) {
    var dtblHD = $('#dtblHD').dataTable();
    $(dtblHD.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalHDHeader").html('Update House Details');
    $("#btnSaveHD").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveHD").removeAttr('disabled');

    $("#txtHDId").val(dtblHD.fnGetData(row)['id']);
    $("#txtHDCode").val(dtblHD.fnGetData(row)['code']);
    $("#txtHDCode").attr('disabled', true);
    $("#txtHDMailAddress").val(dtblHD.fnGetData(row)['mail_address']);
    $("#txtHDMailAddress").attr('disabled', true);
    $('#selHDCity').selectize()[0].selectize.setValue(dtblHD.fnGetData(row)['city']);
    $("#hidHDArea").val(dtblHD.fnGetData(row)['area']);
    $('#selHDHouseType').selectize()[0].selectize.setValue(dtblHD.fnGetData(row)['house_type']);
    $("#txtHDAdvance").val(dtblHD.fnGetData(row)['advance']);
    $("#txtHDRentAmount").val(dtblHD.fnGetData(row)['rent_per_month']);
    $("#txtHDAvailableFromDate").val(dtblHD.fnGetData(row)['available_from']);
    $("#txtHDContactNo").val(dtblHD.fnGetData(row)['contact_no']);
    $("#txtHDDetailedAddress").val(dtblHD.fnGetData(row)['detailed_address']);

    if (dtblHD.fnGetData(row)['status']) {
        $("#txtHDActive").prop("checked", true);
    } else {
        $("#txtHDInactive").prop("checked", true);
    }
    $('#modalHD').modal('show');
}
