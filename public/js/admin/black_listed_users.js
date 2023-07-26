$(document).ready(function () {
    $("#btnSignOut").click(function () {
        let text = 'Are you sure? want to logout.'
        if (confirm(text) == true) {
            window.open("../User/SignOut", "_self");
        }
    });
    let dtblUserList = $('#dtblUserList').DataTable({
        lengthMenu: [
            [10, 25, 50, 100, 200, 500, 1000],
            [10, 25, 50, 100, 200, 500, 1000],
        ],
        pageLength: 10,
        bProcessing: true,//server side pagination
        bServerSide: true,//server side pagination
        ajax: {
            "url": "GetBlackListUsersList",
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
        "sDom": "<'row'<'col-lg-5 col-md-5 col-sm-5 col-xs-5'><'col-lg-3 col-md-3 col-sm-3 col-xs-3' l><'col-lg-4 col-md-4 col-sm-4 col-xs-4' f>>" +
            "<'row'<'col-lg-12 col-md-12 col-sm-12 col-xs-12'tr>>" +
            "<'row'<'col-lg-9 col-md-9 col-sm-9 col-xs-9'i><'col-lg-3 col-md-3 col-sm-3 col-xs-3'p>>",
        "aoColumns": [
            { "data": 'sl_no', "name": "sl_no", "sWidth": "10%", "className": "text-center" },
            { "data": 'name', "name": "name", "sWidth": "30%" },
            { "data": 'email', "name": "email", "sWidth": "30%" },
            { "data": 'user_type', "name": "user_type", "sWidth": "15%", "className": "text-center",
            mRender: function (data, type, val) {
                    if (val.user_type=='ADMIN') {
                        return `<b><span class="text-danger">Admin</span></b>`;
                    }
                    else if(val.user_type =='EMPLOYEE'){
                        return `<b><span class="text-warning">Employee</span></b>`;
                    }else{
                        return `<b><span class="text-success">User</span></b>`;
                    }
                }
            },
            {
                "data": null, "name": "action", "sWidth": "15%", "className": "text-center",
                "defaultContent": `<button class='btn btn-success btn-sm action-btn' onclick='WhiteListUser(event)'><i class='fa fa-check'></i></button>
                &nbsp;<button class='btn btn-danger btn-sm action-btn' onclick='DeleteUser(event)'><i class='fa fa-trash'></i></button>`
            }
        ]
    });

    $("#btnUpdateUserDetails").click(function () {
        $("#btnUpdateUserDetails").html('<i class="fa fa-gear fa-spin"></i>&nbsp;Updating...');
        $("#btnUpdateUserDetails").attr('disabled', true);

        let _token = $("#_token").val();
        let id = $("#txtUserId").val();
        let name = $("#txtName").val();
        let email = $("#txtEmail").val();
        let user_type = $("#selUserType").val();
       
        $.ajax({
            url: "UpdateUserDetails",
            type: "POST",
            data: {
                _token:_token, id: id, name: name, email: email, user_type: user_type
            },
            success: function (response) {
                if (response.status == 'Success') {
                    dtblUserList.ajax.reload();
                    toastr.success(response.message);
                    $("#btnUpdateUserDetails").html('<i class="fa fa-edit"></i> Update');
                    $("#btnUpdateUserDetails").removeAttr('disabled');
                    $('#modaUserDetails').modal('hide');
                } else if (response.status == 'Error') {
                    $("#btnUpdateUserDetails").html('<i class="fa fa-edit"></i> Update');
                    $("#btnUpdateUserDetails").removeAttr('disabled');
                    toastr.warning(response.message);
                } else {
                    $("#btnUpdateUserDetails").html('<i class="fa fa-edit"></i> Update');
                    $("#btnUpdateUserDetails").removeAttr('disabled');
                    toastr.error(response.message);
                }
            },
            error: function (response) {
                toastr.error('Sorry! Something Went Wrong!!!');
            }
        });
    });
});
function WhiteListUser(event) {
    var dtblUserList = $('#dtblUserList').dataTable();
    $(dtblUserList.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;
    var id = dtblUserList.fnGetData(row)['id'];
    swal({
        title: 'Are you sure to white list this user ?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes',
        animation: false
    }).then(function () {
        $.ajax({
            url: "WhiteListUser",
            type: "GET",
            data: { id: id },
            success: function (response) {
                if (response.status == 'Success') {
                    $('#dtblUserList').DataTable().ajax.reload();
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
function DeleteUser(event) {
    var dtblUserList = $('#dtblUserList').dataTable();
    $(dtblUserList.fnSettings().aoData).each(function () {
        $(this.nTr).removeClass('success');
    });
    var row;
    if (event.target.tagName == "BUTTON" || event.target.tagName == "A")
        row = event.target.parentNode.parentNode;
    else if (event.target.tagName == "I")
        row = event.target.parentNode.parentNode.parentNode;
    var id = dtblUserList.fnGetData(row)['id'];
    swal({
        title: 'Are you sure to delete this user?',
        text: "You can not reverse this.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes',
        animation: false
    }).then(function () {
        $.ajax({
            url: "DeleteUser",
            type: "GET",
            data: { id: id },
            success: function (response) {
                if (response.status == 'Success') {
                    $('#dtblUserList').DataTable().ajax.reload();
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