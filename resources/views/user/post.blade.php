<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post</title>
    @include('asset.css_links')
    <link href="{{ asset('css/user/dashboard_style.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
        @include('user.user_header')
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" role="form" action="{{url('/')}}/SavePost" method= "post">
                @csrf
                <div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label" for="selCity">Select City :&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
                        <select class="form-control" id="selCity" name="selCity" placeholder="Select City/Town"></select>
                        <span class="text-danger">
                            @error('selCity')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label" for="selArea">Select Area :&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
                        <select class="form-control" id="selArea" name="selArea" placeholder="Select Area"></select>
                        <span class="text-danger">
                            @error('selArea')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label" for="selHouseType">Select Type :&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
                        <select class="form-control" id="selHouseType" name="selHouseType" placeholder="Select House/Commercial Place Type"></select>
                        <span class="text-danger">
                            @error('selHouseType')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label" for="txtAdvance">Advance :&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
                        <input type="text" class="form-control" name="txtAdvance" id="txtAdvance" placeholder="Enter Advance Amount" value="{{old('txtAdvance')}}" autocomplete="off"/>
                        <span class="text-danger">
                            @error('txtAdvance')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label" for="txtRentAmount">Rent :&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
                        <input type="text" class="form-control" name="txtRentAmount" id="txtRentAmount" placeholder="Enter Rent Amount/Month" value="{{old('txtRentAmount')}}" autocomplete="off"/>
                        <span class="text-danger">
                            @error('txtRentAmount')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-5 control-label" for="txtAvailableFromDate">Available From :&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-7">
                        <input type="text" class="form-control" name="txtAvailableFromDate" id="txtAvailableFromDate" placeholder="Pick Available From Date" value="{{old('txtAvailableFromDate')}}" autocomplete="off"/>
                        <span class="text-danger">
                            @error('txtAvailableFromDate')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label" for="txtContactNo">Contact No :&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
                        <input type="text" class="form-control" name="txtContactNo" id="txtContactNo" placeholder="Enter Contact No." value="{{old('txtContactNo')}}" autocomplete="off"/>
                        <span class="text-danger">
                            @error('txtContactNo')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label" for="txtDetailedAddress">Address :&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
                        <textarea type="text" class="form-control" name="txtDetailedAddress" id="txtDetailedAddress" placeholder="Enter Detailed Address" value="{{old('txtDetailedAddress')}}" autocomplete="off" rows="3"></textarea>
                        <span class="text-danger">
                            @error('txtDetailedAddress')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group">
					<label class="col-lg-2 col-md-2 col-sm-2 col-xs-4 control-label" for="filImage">Image :&nbsp;<span class="text-danger">*</span></label>
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
                        <input type="file" class="form-control" name="filImage" id="filImage" accept="image/*" placeholder="Upload Image" value="{{old('filImage')}}" autocomplete="off"/>
                        <span class="text-danger">
                            @error('filImage')
                                {{$message}}
                            @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="submit" id="btnPost" class="btn btn-dark pull-right"><i class="fa fa-upload fa-lg"></i> Post This</button>
                    </div>
                </div>
            </form>
		</div>
    </div>
    @include('asset.js_links')
    <script src="{{ URL::asset('js/user/post.js') }}"></script>
    <script src="{{ URL::asset('js/user/common.js') }}"></script>
</body>
</html>