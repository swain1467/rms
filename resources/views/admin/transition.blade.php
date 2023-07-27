<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transition</title>
    @include('asset.css_links')
    <link href="{{ asset('css/user/dashboard_style.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
        @include('user.user_header')
        <div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<table class="table table-striped table-bordered" id="dtblHD">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center">Sl.No</th>
                            <th class="text-center">User's Mail</th>
                            <th class="text-center">Contact No</th>
                            <th class="text-center" title="Available From">Avl From</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Area</th>
                            <th class="text-center">City</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
			</div>
            {{-- Edit Modal --}}
            <div id="modalHD" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                <h5 class="modal-title" id="modalHDHeader"></h5>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" id="frmHD">
                                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                <input type="hidden" class="form-control" name="txtHDId" id="txtHDId" autocomplete="off"/>
                                <input type="hidden" class="form-control" name="hidHDArea" id="hidHDArea" autocomplete="off"/>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="selHDCity">City/Town :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control" id="selHDCity" name="selHDCity" placeholder="Select City/Town"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="selHDArea">Area :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control" id="selHDArea" name="selHDArea" placeholder="Select Area"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="selHDHouseType">Type :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control" id="selHDHouseType" name="selHDHouseType" placeholder="Select House/Commercial Place Type"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtHDAdvance">Advance Amount :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" name="txtHDAdvance" id="txtHDAdvance" placeholder="Enter Advance Amount" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtHDRentAmount">Rent Amount/Month :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" name="txtHDRentAmount" id="txtHDRentAmount" placeholder="Enter Rent Amount/Month" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtHDAvailableFromDate">Available From Date :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" name="txtHDAvailableFromDate" id="txtHDAvailableFromDate" placeholder="Enter Available From Date" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtHDContactNo">Contact Number :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" name="txtHDContactNo" id="txtHDContactNo" placeholder="Enter Contact No." autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtHDDetailedAddress">Detailed Address :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <textarea type="text" class="form-control" name="txtHDDetailedAddress" id="txtHDDetailedAddress" placeholder="Enter Detailed Address" autocomplete="off" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="txtHDStatus">Status :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <input type="radio" value="1" id="txtHDActive" name="txtHDStatus"/><i class='fa fa-check' style='color:green; font-weight:bolder'></i>
                                        &ensp;&ensp;&ensp;
                                        <input type="radio" value="0" id="txtHDInactive" name="txtHDStatus"/><i class='fa fa-times' style='color:red; font-weight:bolder'></i>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-info btn-sm" id="btnSaveHD"><i class="fa fa-save"></i>&nbsp;Save</button>
                            <button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Excel Modal --}}
            <div id="ModalExcelUpload" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                <h5 class="modal-title" id="modalHDHeader">Browse Excel To Upload Data</h5>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <form method="post" action="" class="form-horizontal" id="excel" name="excel" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                                            <fieldset class="fieldset-bordered">
                                                Step 1. Download: <button type="button" class="btn btn-info btn-xs" id="btnExcelDownload"><i class="fa fa-download"></i> Template</button><br>
                                                Step 2. Fill the data in the downloaded excel file.<br>
                                                Step 3. Browse and upload.
                                                <div class="form-group">
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <input type="file" id="fileUpload" name="fileUpload" class="form-control" onchange="checkfile(this);" required="" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"/>
                                                    </div>
                                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                        <button type="button" id="btnExcelPreview" class="btn btn-primary"><i class="fa fa-eye"></i>&nbsp;&nbsp;Preview</button>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </form>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <fieldset class="fieldset-bordered" id="DivHideShow">
                                            <b><h3>Data to Upload</h3></b>
                                            <div class="col-lg-12 col-sm-12 col-md-12">
                                                <form method="post" class="form-horizontal" id="excelExportForm" enctype="multipart/form-data">
                                                </form>
                                            </div>
                                            <input type="hidden" id="csrf_token" value="{{ csrf_token() }}" />
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
            </div>
		</div>
    </div>
    @include('asset.js_links')
    <script src="{{ URL::asset('js/admin/transition.js') }}"></script>
    <script src="{{ URL::asset('js/user/common.js') }}"></script>
</body>
</html>