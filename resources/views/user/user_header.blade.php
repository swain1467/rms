<br>
<div class="row">
    <div class="text-center col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <button class="action-btn btn btn-warning btn-md pull-left" id="navBar" onclick="openNav()"><i class="fa fa-bars"></i></button>
        <span class="btn-xs btn btn-warning" style="font-size: 16px; border-radius: 15%;">
            <b>Hi {{session('name')}} <i class="fa fa-user fa-lg"></i></b>
        </span>
        <a href="{{route('sign_out')}}">
            <button class="action-btn btn btn-warning btn-md pull-right"><i  class="fa fa-power-off"></i></button>
        </a>
    </div>
</div>
<br>
<div id="mySidepanel" class="sidepanel">
    <a href="{{route('user_dashboard')}}">Dashboard</a>
    <a href="{{route('find_hc')}}">Find A House/ Commercial Place</a>
    <a href="{{route('post_hc')}}">Post A House/ Commercial Place</a>
    <a href="{{route('post_history')}}">Post History</a>
    <a href="{{route('my_trash')}}">My Trash</a>
</div>