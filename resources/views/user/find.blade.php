<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find</title>
    @include('asset.css_links')
    <link href="{{ asset('css/user/dashboard_style.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
        @include('user.user_header')
        <div class="row">

            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label" for="selCity">Select City :&nbsp;<span class="text-danger">*</span></label>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
                    <select class="form-control" id="selCity" name="selCity" placeholder="Select City/Town"></select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label" for="selArea">Select Area :</label>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
                    <select class="form-control" id="selArea" name="selArea" placeholder="Select Area"></select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label" for="selHouseType">Select Type :</label>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
                    <select class="form-control" id="selHouseType" name="selHouseType" placeholder="Select Type"></select>
                </div>
            </div>
        </div>
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
                                <div class="form-group">
                                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="txtName">Name :&nbsp;<label id="txtName"></label></span>
                                </div>
                                <div class="form-group">
                                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">City/Town :&nbsp;<label id="txtCity"></label></span>
                                </div>
                                <div class="form-group">
                                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Area :&nbsp;<label id="txtArea"></label></span>
                                </div>
                                <div class="form-group">
                                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">House/Commercial Place Type :&nbsp;<label id="txtHouseType"></label></span>
                                </div>
                                <div class="form-group">
                                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Advance Amount :&nbsp;<label id="txtAdvance"></label></span>
                                </div>
                                <div class="form-group">
                                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Rent Amount/Month :&nbsp;<label id="txtRentAmount"></label></span>
                                </div>
                                <div class="form-group">
                                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Available From Date :&nbsp;<label id="txtAvailableFromDate"></label></span>
                                </div>
                                <div class="form-group">
                                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Contact Number :&nbsp;<label id="txtContactNo"></label></span>
                                </div>
                                <div class="form-group">
                                    <span class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Detailed Address :&nbsp;<label id="txtDetailedAddress"></label></span>
                                </div>
                            </form>
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
    <script src="{{ URL::asset('js/user/find.js') }}"></script>
    <script src="{{ URL::asset('js/user/common.js') }}"></script>
</body>
</html>