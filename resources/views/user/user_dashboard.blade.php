<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    @include('asset.css_links')
    <link href="{{ asset('css/user/dashboard_style.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container">
        @include('user.user_header')
        <div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="card bg-primary">
					<a href="{{route('find_hc')}}">
						<b>
                            <i class = "fa fa-home" style="opacity: 0.5;"></i><br>
                            <span class = "nav-item">Find A House</span><br><br>
                            <span class = "nav-item">Or</span><br>
                            <i class = "fa fa-building" style="opacity: 0.5;"></i><br>
                            <span class = "nav-item">Commercial Place</span><br><br>
                        </b>
					</a>
				</div>
			</div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="card bg-success">
                    <a href="{{route('post_hc')}}">
                        <b>
                            <i class = "fa fa-home" style="opacity: 0.5;"></i><br>
                            <span class = "nav-item">Post A House</span><br><br>
                            <span class = "nav-item">Or</span><br>
                            <i class = "fa fa-building" style="opacity: 0.5;"></i><br>
                            <span class = "nav-item">Commercial Place</span><br><br>
                        </b>
					</a>
				</div>
			</div>
		</div>
    </div>
    @include('asset.js_links')
    <script src="{{ URL::asset('js/user/user_dashboard.js') }}"></script>
    <script src="{{ URL::asset('js/user/common.js') }}"></script>
</body>
</html>