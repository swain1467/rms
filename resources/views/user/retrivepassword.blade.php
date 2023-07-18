<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retrive Password</title>
    @include('asset.css_links')
</head>
<body>
	<div class="container">
        <br>
        <div class="row">
            <h3 class="text-center">Reset Password</h3>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form>
                    <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                    {{-- Component --}}
                    <div id="divEmail">
                        <x-input type="text" name="txtEmail" id="txtEmail" label="Registered Email" placeholder="Please enter registered your email" value="{{old('txtEmail')}}"/>
                        <br>
                        <button type="button" id="btnSendOTP" class="btn btn-success btn-sm" style="float: right">Send OTP</button>
                    </div>
                    <div id="divPass">
                        <x-input type="password" name="txtPassword" id="txtPassword" label="Password" placeholder="Please enter new password"/>
                        <x-input type="password" name="txtConfPassword" id="txtConfPassword" label="Confirm Password" placeholder="Please confirm the password"/>
                        <x-input type="text" name="txtOTP" id="txtOTP" label="OTP" placeholder="Please enter the otp send your mail address"/>
                        <br>
                        <button type="button" id="btnSubmit" class="btn btn-success btn-sm" style="float: right">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('asset.js_links')
    <script>
    $(document).ready(function () {
        $("#divEmail").show();
        $("#divPass").hide();
        
        $("#btnSendOTP").click(function () {
            $("#btnSendOTP").html('Please Wait');
            $("#btnSendOTP").attr('disabled', true);
            let email = $("#txtEmail").val();
            let _token = $("#_token").val();
            $.ajax({
                url: "SendOTP",
                type: "POST",
                data: {email:email, _token:_token},
                success: function (response) {
                    if (response.status == 'Success') {
                        $("#btnSendOTP").html('Send OTP');
                        $("#btnSendOTP").removeAttr('disabled');
                        $("#divEmail").hide();
                        $("#divPass").show(1000);
                        toastr.success(response.message);
                    } else if (response.status == 'Error') {
                        $("#btnSendOTP").html('Send OTP');
                        $("#btnSendOTP").removeAttr('disabled');
                        toastr.warning(response.message);
                    } else {
                        $("#btnSendOTP").html('Send OTP');
                        $("#btnSendOTP").removeAttr('disabled');
                        toastr.error(response.message);
                    }
                },
                error: function (response) {
                    toastr.error('Sorry! Something Went Wrong!!!');
                }
            });
        });

        $("#btnSubmit").click(function () {
            $("#btnSubmit").html('Please Wait');
            $("#btnSubmit").attr('disabled', true);
            let email = $("#txtEmail").val();
            let otp = $("#txtOTP").val();
            let password = $("#txtPassword").val();
            let confirm_password = $("#txtConfPassword").val();
            let _token = $("#_token").val();
            $.ajax({
                url: "Verify",
                type: "POST",
                data: {email:email, otp:otp, password:password, 
                    confirm_password:confirm_password, _token:_token},
                success: function (response) {
                    if (response.status == 'Success') {
                        $("#btnSubmit").html('Submit');
                        $("#btnSubmit").removeAttr('disabled');
                        alert(response.message);
                        window.open("/SignIn", "_self");
                    } else if (response.status == 'Error') {
                        $("#btnSubmit").html('Submit');
                        $("#btnSubmit").removeAttr('disabled');
                        toastr.warning(response.message);
                    } else {
                        $("#btnSubmit").html('Submit');
                        $("#btnSubmit").removeAttr('disabled');
                        toastr.error(response.message);
                    }
                },
                error: function (response) {
                    toastr.error('Sorry! Something Went Wrong!!!');
                }
            });
        });
    });
    </script>
</body>
</html>