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
		</div>
    </div>
    @include('asset.js_links')
    <script src="{{ URL::asset('js/user/trash.js') }}"></script>
    <script src="{{ URL::asset('js/user/common.js') }}"></script>
</body>
</html>