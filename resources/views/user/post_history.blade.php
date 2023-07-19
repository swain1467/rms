<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post History</title>
    @include('asset.css_links')
    <link href="{{ asset('css/user/dashboard_style.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
        @include('user.user_header')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table table-striped table-bordered" id="dtblHouse">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center" title="House/Commercial Place">Type</th>
                            <th class="text-center" title="Available From">Avl From</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div id="modalHouse" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                <h5 class="modal-title" id="modalHouseHeader"></h5>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" role="form" id="frmHouse">
                                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                                <input type="hidden" class="form-control" name="txtHouseId" id="txtHouseId" autocomplete="off"/>
                                <input type="hidden" class="form-control" name="hidArea" id="hidArea" autocomplete="off"/>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="selCity">City/Town :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control" id="selCity" name="selCity" placeholder="Select City/Town"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="selArea">Area :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control" id="selArea" name="selArea" placeholder="Select Area"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="selHouseType">Type :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select class="form-control" id="selHouseType" name="selHouseType" placeholder="Select House/Commercial Place Type"></select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtAdvance">Advance Amount :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" name="txtAdvance" id="txtAdvance" placeholder="Enter Advance Amount" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtRentAmount">Rent Amount/Month :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" name="txtRentAmount" id="txtRentAmount" placeholder="Enter Rent Amount/Month" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtAvailableFromDate">Available From Date :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" name="txtAvailableFromDate" id="txtAvailableFromDate" placeholder="Enter Available From Date" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtContactNo">Contact Number :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" name="txtContactNo" id="txtContactNo" placeholder="Enter Contact No." autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtDetailedAddress">Detailed Address :&nbsp;<span class="text-danger">*</span></label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <textarea type="text" class="form-control" name="txtDetailedAddress" id="txtDetailedAddress" placeholder="Enter Detailed Address" autocomplete="off" rows="3"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-info btn-sm" id="btnSaveHouse"><i class="fa fa-save"></i>&nbsp;Save</button>
                            <button class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-close"></i>&nbsp;Close</button>
                        </div>
                    </div>
                </div>
            </div>
		</div>
    </div>
    @include('asset.js_links')
    <script src="{{ URL::asset('js/user/post_history.js') }}"></script>
    <script src="{{ URL::asset('js/user/post.js') }}"></script>
    <script src="{{ URL::asset('js/user/common.js') }}"></script>
</body>
</html>