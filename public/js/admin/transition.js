$(document).ready(function () {
    LoadCitySelectize();
    LoadHouseTypeSelectize();
    $("#selHDCity").change(function () {
        LoadAreaSelectize();
    });
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
                "defaultContent": `<button class='btn btn-warning btn-sm action-btn' onclick='UpdateHD(event)'><i class='fa fa-edit'></i></button>
                &nbsp; <button class='btn btn-danger btn-sm action-btn' onclick='DeleteHD(event)'><i class='fa fa-trash'></i></button>`
            }
        ],
        buttons: [
            {
                text: `<button id="openExcelModal" class="btn btn-dark btn-sm"><i class="fa fa-upload"></i>&nbsp;Bulk Upload</button>`,
            }
        ]
    });
    $("#btnSaveHD").click(function () {
        $("#btnSaveHD").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Updating...');
        $("#btnSaveHD").attr('disabled', true);

        let _token = $("#_token").val();
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
            url: "UpdateHouseDetails",
            type: "POST",
            data: {
                _token: _token, id: house_id, selCity: city, selArea: area, selHouseType: house_type, txtAdvance: advance
                , txtRentAmount: rent, txtAvailableFromDate: from_date, txtContactNo: contact, txtDetailedAddress: address, hdStatus: hd_status
            },
            success: function (response) {
                if (response.status == 'Success') {
                    dtblHD.ajax.reload();
                    toastr.success(response.message);
                    $("#btnSaveHD").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveHD").removeAttr('disabled');
                    $('#modalHD').modal('hide');
                } else if (response.status == 'Error') {
                    $("#btnSaveHD").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveHD").removeAttr('disabled');
                    toastr.warning(response.message);
                } else {
                    $("#btnSaveHD").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveHD").removeAttr('disabled');
                    toastr.error(response.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
    // Excel Upload starts here
    $("#openExcelModal").click(function () {
		$('#fileUpload').val('');
		$('#DivHideShow').hide();
        $('#ModalExcelUpload').modal('show');
    });
    // Template Download
    $("#btnExcelDownload").click(function () {
		window.location.href = "ExcelTemplateDownload";
    });
    // Reference Download
    $("#btnReferenceDownload").click(function () {
		window.location.href = "ExcelReferenceDownload";
    });
    // Excel Preview
    $("#btnExcelPreview").click(function () {
		var excel_file = $("#fileUpload").val();
        if (excel_file == "") {
            $("#fileUpload").focus();
            toastr.warning("Sorry! Please choose downloaded excel file.");
        }else{
            var formData = new FormData();
            formData.append("_token", $("#csrf_token").val());
            formData.append("fileUpload", $("#fileUpload")[0].files[0]);
            $.ajax({
                url: "ExcelPreview",
                type: "post",
                data: formData,
                contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
                processData: false, // NEEDED, DON'T OMIT THIS
                success: function (response) {
                    if (response.status == "Success") {
                        dtblHD.ajax.reload();
                        toastr.success(response.message);
                        $('#ModalExcelUpload').modal('hide');
                    } else if (response.status == "Failure") {
                        toastr.error(response.message);;
                        $("#fileUpload").val("");
                        // $("#DivHideShow").hide();
                    }
                },
                error: function (responsedata) {},
            });
        }
    });
});
function LoadCitySelectize() {
    $.ajax({
        url: "GetCity",
        type: "GET",
        success: function (response) {
            var $select = $('#selHDCity').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            $.each(response.aaData, function (i, data) {
                selectize.addOption({ value: data.id, text: data.city_name });
            });
        },
        error: function () {
            toastr.error('Unable to load city selectize');
        }
    });
}
function LoadAreaSelectize() {
    let city_id = $("#selHDCity").val();
    $.ajax({
        "url": "GetArea",
        type: "get",
        data: { city_id: city_id },
        success: function (response) {
            var $select = $('#selHDArea').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            $.each(response.aaData, function (i, data) {
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
            toastr.error('Unable to load area selectize');
        }
    });
}
function LoadHouseTypeSelectize() {
    $.ajax({
        url: "GetType",
        type: "GET",
        success: function (response) {
            var $select = $('#selHDHouseType').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            $.each(response.aaData, function (i, data) {
                if (data.status != 0) {
                    selectize.addOption({ value: data.id, text: data.type });
                }
            });
        },
        error: function () {
            toastr.error('Unable to load Type selectize');
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
    $('#selHDCity').selectize()[0].selectize.setValue(dtblHD.fnGetData(row)['city_id']);
    $("#hidHDArea").val(dtblHD.fnGetData(row)['area_id']);
    $('#selHDHouseType').selectize()[0].selectize.setValue(dtblHD.fnGetData(row)['type_id']);
    $("#txtHDAdvance").val(dtblHD.fnGetData(row)['advance']);
    $("#txtHDRentAmount").val(dtblHD.fnGetData(row)['rent']);
    $("#txtHDAvailableFromDate").val(dtblHD.fnGetData(row)['from_date']);
    $("#txtHDContactNo").val(dtblHD.fnGetData(row)['contact_no']);
    $("#txtHDDetailedAddress").val(dtblHD.fnGetData(row)['detailed_address']);

    if (dtblHD.fnGetData(row)['status']) {
        $("#txtHDActive").prop("checked", true);
    } else {
        $("#txtHDInactive").prop("checked", true);
    }
    $('#modalHD').modal('show');
}

function DeleteHD(event) {
    var dtblHD = $('#dtblHD').dataTable();
    $(dtblHD.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;
    var id = dtblHD.fnGetData(row)['id'];
    swal({
        title: 'Are you sure to delete ?',
        text: "You can not reverse this.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes',
        animation: false
    }).then(function () {
        $.ajax({
            url: "DeleteHD",
            type: "GET",
            data: { id: id },
            success: function (response) {
                if (response.status == 'Success') {
                    $('#dtblHD').DataTable().ajax.reload();
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function () {
                toastr.error('Unable to process please contact support');
            }
        });
    }, function (dismiss) { }).done();
}
// Excel File
function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls");/*, ".csv"*/
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      	toastr.error("Invalid file selected, valid files are of " + validExts.toString() + " types.");
      	sender.value = '';
      	return false;
    }
    else return true;
}