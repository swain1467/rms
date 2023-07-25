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
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<div class="card bg-success">
					<a href="{{route('active_users')}}">
						<i class = "fa fa-users"></i><br>
						<span class = "text-item">Active Users List</span>
					</a>
				</div>
			</div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<div class="card bg-danger">
					<a href="{{route('black_listed_users')}}">
						<i class = "fa fa-users"></i><br>
						<span class = "nav-item">Black Listed Users List</span>
					</a>
				</div>
			</div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<div class="card bg-primary">
					<a href="{{route('setup')}}">
						<i class = "fa fa-cog"></i><br>
						<span class = "nav-item">Set Up</span>
					</a>
				</div>
			</div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
				<div class="card bg-dark">
					<a href="{{route('transition')}}">
						<i class = "fa fa-tasks"></i><br>
						<span class = "nav-item">Transition</span>
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