<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <br>
        <div class="row">
            <h3 class="text-center">Sign Up</h3>
            {{-- Normal Route --}}
            <form action="{{url('/')}}/SaveUser" method= "post">
                @csrf
                {{-- Component --}}
                <x-input type="text" name="txtName" id="txtName" label="Name" placeholder="Please enter your name" value="{{old('txtName')}}"/>
                <span class="text-danger">
                    @error('txtName')
                        {{$message}}
                    @enderror
                </span>
                <x-input type="text" name="txtEmail" id="txtEmail" label="Email" placeholder="Please enter your email" value="{{old('txtEmail')}}"/>
                <span class="text-danger">
                    @error('txtEmail')
                        {{$message}}
                    @enderror
                </span>
                <x-input type="password" name="txtPassword" id="txtPassword" label="Password" placeholder="Please enter new password"/>
                <span class="text-danger">
                    @error('txtPassword')
                        {{$message}}
                    @enderror
                </span>
                <x-input type="password" name="txtConfPassword" id="txtConfPassword" label="Confirm Password" placeholder="Please confirm the password"/>
                <span class="text-danger">
                    @error('txtConfPassword')
                        {{$message}}
                    @enderror
                </span>
                <br>
                {{-- Named Route --}}
                <a href="{{route('user_sign_in')}}">
                    <button type="button" class="btn btn-warning btn-sm">Sign In</button>
                </a>
                <button type="submit" class="btn btn-success btn-sm" style="float: right">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>