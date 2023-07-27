<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Up</title>
    @include('asset.css_links')
    <link href="{{ asset('css/user/dashboard_style.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
        @include('user.user_header')
        <div class="row">
			<div class="nav-tabs-custom">
				<b>
                    <ul class="nav nav-tabs bg-dark">
					<li class="active"><a href="#tabCity" data-toggle="tab">City/Town</a></li>
					<li><a href="#tabArea" data-toggle="tab">Area</a></li>
					<li><a href="#tabHouseType" data-toggle="tab">House Type</a></li>
                    </ul>
                </b>
            </div>
			<div class="tab-content">
                <!--City Tab-1 Start-->
				<div class="tab-pane active" id="tabCity"><br>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-bordered" id="dtblCity">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl.No</th>
                                        <th class="text-center">City/Town</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
						<div id="modalCity" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
											<h5 class="modal-title" id="modalCityHeader"></h5>
										</div>
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" role="form" id="frmCity">
                                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
											<input type="hidden" class="form-control" name="txtCityId" id="txtCityId" autocomplete="off"/>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtCityName">City/Town :&nbsp;<span class="text-danger">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="text" class="form-control" name="txtCityName" id="txtCityName" placeholder="Enter City/Town" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtCityStatus">Status :&nbsp;<span class="text-danger">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="radio" value="1" id="txtCityActive" name="txtCityStatus"/><i class='fa fa-check' style='color:green; font-weight:bolder'></i>
													&ensp;&ensp;&ensp;
													<input type="radio" value="0" id="txtCityInactive" name="txtCityStatus"/><i class='fa fa-times' style='color:red; font-weight:bolder'></i>
												</div>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button class="btn btn-info btn-sm" id="btnSaveCity"><i class="fa fa-save"></i>&nbsp;Save</button>
										<button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
									</div>
								</div>
							</div>
            			</div>
                    </div>
                </div>
                <!--City Tab-1 End-->
                <!--Area Tab-2 Start-->
				<div class="tab-pane" id="tabArea"><br>
                    <div class="row">
                        <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right" for="selCity">City/Town :&nbsp;<span class="text-danger">*</span></label>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-8">
                            <select class="form-control" id="selCity" name="selCity" placeholder="Select City/Town"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-bordered" id="dtblArea">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl.No</th>
                                        <th class="text-center">City/Town</th>
                                        <th class="text-center">Area</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
						<div id="modalArea" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
											<h5 class="modal-title" id="modalAreaHeader"></h5>
										</div>
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" role="form" id="frmArea">
                                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
											<input type="hidden" class="form-control" name="txtAreaId" id="txtAreaId" autocomplete="off"/>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtAreaName">Area :&nbsp;<span class="text-danger">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="text" class="form-control" name="txtAreaName" id="txtAreaName" placeholder="Enter Area" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtAreaStatus">Status :&nbsp;<span class="text-danger">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="radio" value="1" id="txtAreaActive" name="txtAreaStatus"/><i class='fa fa-check' style='color:green; font-weight:bolder'></i>
													&ensp;&ensp;&ensp;
													<input type="radio" value="0" id="txtAreaInactive" name="txtAreaStatus"/><i class='fa fa-times' style='color:red; font-weight:bolder'></i>
												</div>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button class="btn btn-info btn-sm" id="btnSaveArea"><i class="fa fa-save"></i>&nbsp;Save</button>
										<button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
									</div>
								</div>
							</div>
            			</div>
                    </div>
                </div>
                <!--Area Tab-2 End-->
                <!--House Type Tab-3 Start-->
				<div class="tab-pane" id="tabHouseType"><br>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table table-striped table-bordered" id="dtblHouseType">
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center">Sl.No</th>
                                        <th class="text-center">House Type</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
						<div id="modalHouseType" class="modal fade" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
											<h5 class="modal-title" id="modalHouseTypeHeader"></h5>
										</div>
										<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
										</div>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" role="form" id="frmHouseType">
                                            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
											<input type="hidden" class="form-control" name="txtHouseTypeId" id="txtHouseTypeId" autocomplete="off"/>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtHouseTypeName">House Type :&nbsp;<span class="text-danger">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="text" class="form-control" name="txtHouseTypeName" id="txtHouseTypeName" placeholder="Enter House Type" autocomplete="off"/>
												</div>
											</div>
											<div class="form-group">
												<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtHouseTypeStatus">Status :&nbsp;<span class="text-danger">*</span></label>
												<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
													<input type="radio" value="1" id="txtHouseTypeActive" name="txtHouseTypeStatus"/><i class='fa fa-check' style='color:green; font-weight:bolder'></i>
													&ensp;&ensp;&ensp;
													<input type="radio" value="0" id="txtHouseTypeInactive" name="txtHouseTypeStatus"/><i class='fa fa-times' style='color:red; font-weight:bolder'></i>
												</div>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button class="btn btn-info btn-sm" id="btnSaveHouseType"><i class="fa fa-save"></i>&nbsp;Save</button>
										<button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
									</div>
								</div>
							</div>
            			</div>
                    </div>
                </div>
                <!--House Type Tab-3 End-->
            </div>
        </div>
    </div>
    @include('asset.js_links')
    <script src="{{ URL::asset('js/admin/setup.js') }}"></script>
    <script src="{{ URL::asset('js/user/common.js') }}"></script>
</body>
</html>