<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blacklisted Users List</title>
    @include('asset.css_links')
    <link href="{{ asset('css/user/dashboard_style.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
        @include('user.user_header')
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<table class="table table-striped table-bordered" id="dtblUserList">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center">Sl. No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Mail Address</th>
                            <th class="text-center">User Type</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
			</div>
            
            <!-- Modal -->
            <div id="modaUserDetails" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                <h5 class="modal-title" id="modaUserDetailsHeader"></h5>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" id="frmUserDetails">
                                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                <input type="hidden" class="form-control" name="txtUserId" id="txtUserId" autocomplete="off"/>
                                <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label" for="txtName">Name :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text" class="form-control" name="txtName" id="txtName" placeholder="Enter Full Name" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4  control-label" for="txtEmail">Email :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="text" class="form-control" name="txtEmail" id="txtEmail" placeholder="Enter Mail Address" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="selUserType">User Type :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <select class="form-control" id="selUserType" name="selUserType" placeholder="Select User Type">
                                            <option value="USER">User</option>
                                            <option value="EMPLOYEE">Employee</option>
                                            <option value="ADMIN">Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-info btn-sm" id="btnUpdateUserDetails"><i class="fa fa-edit"></i>&nbsp;Save</button>
                            <button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->
		</div>
    </div>
    @include('asset.js_links')
    <script src="{{ URL::asset('js/admin/black_listed_users.js') }}"></script>
    <script src="{{ URL::asset('js/user/common.js') }}"></script>
</body>
</html>