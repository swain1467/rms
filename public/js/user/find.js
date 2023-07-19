$(document).ready(function () {
    LoadCitySelectize();
    LoadHouseTypeSelectize();
    $("#selCity").change(function () {
        LoadAreaSelectize();
        LoadHouseDataTable();
    });
    $("#selArea").change(function () {
        LoadHouseDataTable();
    });
    $("#selHouseType").change(function () {
        LoadHouseDataTable();
    });
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
                    return `${val.type.type}
                    <button title="See Details" class='pull-right btn btn-success btn-xs action-btn' onclick='SeeHouseDetails(event)'><i class='fa fa-eye'></i></button>`;
                }
            },
            { "data": 'from_date', "name": "from_date", "sWidth": "30%", "className":"text-center" }
        ]
    });
});
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
            toastr.error('Unable to load city selectize');
        }
    });
}
function LoadAreaSelectize() {
    let city_id = $("#selCity").val();
    $.ajax({
        "url": "GetArea",
        type: "get",
        data: { city_id: city_id },
        success: function (response) {
            var $select = $('#selArea').selectize();
            var selectize = $select[0].selectize;
            selectize.clear();
            selectize.clearOptions();
            $.each(response.aaData, function (i, data) {
                if (data.status != 0) {
                    selectize.addOption({ value: data.id, text: data.area_name });
                }
            });
            //This is a conditional selectize
            if ($("#hidArea").val()) {
                $('#selArea').selectize()[0].selectize.setValue($("#hidArea").val());
            }
            $("#hidArea").val('');
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
            var $select = $('#selHouseType').selectize();
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

function LoadHouseDataTable() {
    let city = $("#selCity").val();
    let area = $("#selArea").val();
    let type = $("#selHouseType").val();
    $.ajax({
        "url": "GetAvailableHouseList",
        type: "GET",
        data: { city: city, area: area, type: type },
        success: function (response) {
            var table = $('#dtblHouse').DataTable();
            table.clear().draw();
            table.rows.add(response.aaData).draw();
        },
        error: function () {
            toastr.error('Unable to load table please contact support');
        }
    });
}

function SeeHouseDetails(event) {

    var dtblHouse = $('#dtblHouse').dataTable();
    $(dtblHouse.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;

    $("#modalHouseHeader").html('See Details');
    $("#txtName").html(dtblHouse.fnGetData(row)['user'].name);
    $("#txtCity").html(dtblHouse.fnGetData(row)['city'].city_name);
    $("#txtArea").html(dtblHouse.fnGetData(row)['area'].area_name);
    $("#txtHouseType").html(dtblHouse.fnGetData(row)['type'].type);
    $("#txtAdvance").html(dtblHouse.fnGetData(row)['advance']);
    $("#txtRentAmount").html(dtblHouse.fnGetData(row)['rent']);
    $("#txtAvailableFromDate").html(dtblHouse.fnGetData(row)['from_date']);
    $("#txtContactNo").html(dtblHouse.fnGetData(row)['contact_no']);
    $("#txtDetailedAddress").html(dtblHouse.fnGetData(row)['detailed_address']);
    $('#modalHouse').modal('show');
}