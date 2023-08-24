<?php

namespace App\Http\Controllers\user;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class SignInController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['LogIn']]);
    }

    public function SignInView(){
        return view("user.signin");
    }

    public function CheckSignIn(Request $request){
        $request->validate(
            [
                "txtEmail" => "required|email",
                "txtPassword" => "required"
            ],
            [
                'txtEmail.required' => 'Email is required',
                'txtEmail.email' => 'Invalid email',
                'txtPassword.required' => 'Password is required'
            ]
        );
        $user = User::select('id', 'name', 'password', 'email', 'user_type')
                ->where('email', '=', $request['txtEmail'])
                ->where('status', '=', 1)
                ->get();

        $data = $user->toArray();
        $password = '';
        foreach($data AS $d){
            $id = $d['id'];
            $name = $d['name'];
            $email = $d['email'];
            $user_type = $d['user_type'];
            $password = $d['password'];
        }
        $verify = password_verify($request['txtPassword'], $password);
    
        if($verify){
            session()->put('id',$id);
            session()->put('name',$name);
            session()->put('email',$email);
            session()->put('user_type',$user_type);

            return redirect(route('user_dashboard'));
        }else if(COUNT($data)!=1){
            echo'Invalid email address.';
        } else{
            echo'Invalid password.';
        }
    }
    //API--------------------------
    public function LogIn(Request $request){
        $output = array('status' => '', 'message' => '', 'token' => '');
        $credentials = request(['email', 'password']);
        
        if (! $token = auth()->attempt($credentials)) {
            $output['status'] = 'Error';
            $output['message'] = 'Invalid Credentials';
        }else{
            $output['status'] = 'Success';
            $output['message'] = 'You have successfull Signed In.';
            $output['token'] = $this->respondWithToken($token);
        }
        return $output;
    }
    public function logout()
    {
        auth()->logout();
        $output['status'] = 'Success';
        $output['message'] = 'Successfully Signed Out.';
        $output['token'] = '';
        return $output;
    }
    public function me()
    {
        return auth()->check();
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user_email' => auth()->user()->email,
            'user_type' => auth()->user()->user_type,
            'user_id' => auth()->user()->id,
            'user_name' => auth()->user()->name
        ]);
    }
}