$(document).ready(function () {
    LoadCitySelectize();
    LoadHouseTypeSelectize();
    $("#selCity").change(function () {
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