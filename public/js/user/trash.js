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
                    return `<button class='btn btn-danger btn-xs action-btn' onclick='DeleteHouse(event)'><i class='fa fa-trash'></i></button>
                    &nbsp; ${val.type.type}
                    <button class='pull-right btn btn-warning btn-xs action-btn' onclick='RestoreHouse(event)'><i class='fa fa-undo'></i></button>`;
                }
            },
            { "data": 'from_date', "name": "from_date", "sWidth": "30%", "className":"text-center" }
        ]
    });
});


function LoadHouseDataTable() {
    $.ajax({
        "url": "GetTrashHouseList",
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


function DeleteHouse(event) {
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
            url: "DeleteHouse",
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

function RestoreHouse(event) {
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
            url: "RestoreHouse",
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
