$(document).ready(function () {
    LoadHouseDataTable();
    let dtblHouse = $('#dtblHouse').DataTable({
        bPaginate: false,
        bDestroy: true,
        "sDom": "<'row'<'col-lg-3 col-md-3 col-sm-3'l>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9'i><'col-lg-3 col-md-3 col-sm-3'p>>",
        "aoColumns": [
            {
                "data": 'type.type', "name": "type.type", "sWidth": "70%",
                mRender: function (data, type, val) {
                    if(val.status){
                        return `<button class='btn btn-warning btn-xs action-btn' onclick='MoveToTrash(event)'><i class='fa fa-trash'></i></button>
                        &nbsp; ${val.type.type}
                        <button class='pull-right btn btn-success btn-xs action-btn' onclick='UpdateHouse(event)'><i class='fa fa-edit'></i></button>`;
                    }else{
                        return `<button class='btn btn-warning btn-xs action-btn' onclick='MoveToTrash(event)'><i class='fa fa-trash'></i></button>
                        &nbsp; <b><span class="text-danger" title="This record has been black listed by the admin">${val.type.type}</span></b>
                        <button class='pull-right btn btn-success btn-xs action-btn' onclick='UpdateHouse(event)'><i class='fa fa-edit'></i></button>`;
                    }
                }
            },
            { "data": 'from_date', "name": "from_date", "sWidth": "30%", "className":"text-center",
                mRender: function (data, type, val) {
                    if(val.status){
                        return `${val.from_date}`;
                    }else{
                        return `<b><span class="text-danger" title="This record has been black listed by the admin">${val.from_date}</span></b>`;
                    }
                }
            }
        ]
    });

    $("#btnSaveHouse").click(function () {
        $("#btnSaveHouse").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Updating...');
        $("#btnSaveHouse").attr('disabled', true);

        let _token = $("#_token").val();
        let house_id = $("#txtHouseId").val();
        let city = $("#selCity").val();
        let area = $("#selArea").val();
        let house_type = $("#selHouseType").val();
        let advance = $("#txtAdvance").val();
        let rent = $("#txtRentAmount").val();
        let from_date = $("#txtAvailableFromDate").val();
        let address = $("#txtDetailedAddress").val();
        var contact = $("#txtContactNo").val();
        $.ajax({
            url: "UpdateHouse",
            type: "POST",
            data: {
                _token: _token, id: house_id, selCity: city, selArea: area, selHouseType: house_type, txtAdvance: advance
                , txtRentAmount: rent, txtAvailableFromDate: from_date, txtContactNo: contact, txtDetailedAddress: address
            },
            success: function (response) {
                if (response.status == 'Success') {
                    LoadHouseDataTable();
                    toastr.success(response.message);
                    $("#btnSaveHouse").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveHouse").removeAttr('disabled');
                    $('#modalHouse').modal('hide');
                } else if (response.status == 'Error') {
                    $("#btnSaveHouse").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveHouse").removeAttr('disabled');
                    toastr.warning(response.message);
                } else {
                    $("#btnSaveHouse").html('<i class="fa fa-edit"></i> Update');
                    $("#btnSaveHouse").removeAttr('disabled');
                    toastr.error(response.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
});


function LoadHouseDataTable() {
    $.ajax({
        "url": "GetHouseList",
        type: "GET",
        success: function (response) {
            // var res = JSON.parse(response);
            var table = $('#dtblHouse').DataTable();
            table.clear().draw();
            table.rows.add(response.aaData).draw();
        },
        error: function () {
            toastr.error('Unable to load table please contact support');
        }
    });
}


function MoveToTrash(event) {
    var dtblHouse = $('#dtblHouse').dataTable();
    $(dtblHouse.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;
    var id = dtblHouse.fnGetData(row)['id'];
    swal({
        title: 'Are you sure to move this to trash ?',
        text: "It will not visible to any tenant",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes',
        animation: false
    }).then(function () {
        $.ajax({
            url: "MoveToTrash",
            type: "GET",
            data: { id: id },
            success: function (response) {
                if (response.status == 'Success') {
                    LoadHouseDataTable();
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

function UpdateHouse(event) {
    var dtblHouse = $('#dtblHouse').dataTable();
    $(dtblHouse.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalHouseHeader").html('Update House/Commercial Place Details');
    $("#btnSaveHouse").html('<i class="fa fa-edit"></i>&nbsp;Update');
    $("#btnSaveHouse").removeAttr('disabled');
    $("#txtHouseId").val(dtblHouse.fnGetData(row)['id']);
    $("#txtHouseCode").attr('disabled', true);
    $('#selCity').selectize()[0].selectize.setValue(dtblHouse.fnGetData(row)['city'].id);
    $("#hidArea").val(dtblHouse.fnGetData(row)['area'].id);
    $('#selHouseType').selectize()[0].selectize.setValue(dtblHouse.fnGetData(row)['type'].id);
    $("#txtAdvance").val(dtblHouse.fnGetData(row)['advance']);
    $("#txtRentAmount").val(dtblHouse.fnGetData(row)['rent']);
    $("#txtAvailableFromDate").val(dtblHouse.fnGetData(row)['from_date']);
    $("#txtContactNo").val(dtblHouse.fnGetData(row)['contact_no']);
    $("#txtDetailedAddress").val(dtblHouse.fnGetData(row)['detailed_address']);
    $('#modalHouse').modal('show');
}
