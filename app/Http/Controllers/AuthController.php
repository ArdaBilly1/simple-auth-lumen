<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
            'password1' => 'required|same:password',
            'no_hp' => 'required|unique:users',
            'alamat' => 'required',
            'desc' => 'required'
        ]);
 
        $nama = $request->input("nama");
        $username = $request->input("username");
        $email = $request->input("email");
        $password = $request->input("password");
        $password1 = $request->input("password1");
        $no_hp = $request->input("no_hp");
        $alamat = $request->input("alamat");
        $desc = $request->input("desc");
        $data = [
            'nama' => $nama,
            'username' => $username,
            "email" => $email,
            "password" => $password1,
            'no_hp' => $no_hp,
            'alamat' => $alamat,
            'desc' => $desc,
            'role' => 0 
        ];
 
 
 
        if (User::create($data)) {
            $out = [
                "message" => "register_success",
                "code"    => 201,
            ];
        } else {
            $out = [
                "message" => "failed_regiser",
                "code"   => 404,
            ];
        }
 
        return response()->json($out, $out['code']);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
 
        $username = $request->input("username");
        $password = $request->input("password");
 
        $user = User::where("username", $username)->first();
 
        if (!$user) {
            $out = [
                "message" => "login_failed",
                "code"    => 401,
                "result"  => [
                    "Key" => null,
                ]
            ];
            return response()->json($out, $out['code']);
        }
 
        if ($user->password) {
            $newtoken  = $this->generateRandomString();
            $user->update([
                'token' => $newtoken
            ]);
 
            if($user->role == 1){
                $out = [
                    'message' => 'Login Success, Anda Admin',
                    'code' => 200,
                    "result"  => [
                        "Key" => $newtoken,
                    ]
                ];
            } else{
                    $out = [
                        'message' => 'Login Success, Anda User',
                        'code' => 200,
                        "result"  => [
                            "token" => $newtoken,
                        ]
                    ];

            }
        } else {
            $out = [
                "message" => "login_failed",
                "code"    => 401,
                "result"  => [
                    "Key" => null,
                ]
            ];
        }
 
        return response()->json($out, $out['code']);
    }

    public function generateRandomString($length = 40)
    {
        $char = '1234567890ABCDEFGHIJKLMNOPQRSTVWXYZabcdefgahijklmnopqrstuvwxyz';
        $longChar = strlen($char);
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $char[rand(0, $longChar - 1)];
        }
        return $str;
    }

    public function lupaPass(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'username' => 'required'
        ]);

        $email = $request->input("email");
        $username = $request->input("username");
 
        $email = User::where("email", $email)->first();
        $user = User::where("username", $username)->first();
 
        if (!$user) {
            $out = [
                "message" => "failed",
                "code"    => 401
            ];
            return response()->json($out, $out['code']);
        }

        if ($user==$email) {
            $newPass  = $this->generateRandomString(7);
            $user->update([
                'password' => $newPass
            ]);
            $out = [
                'message' => 'Password berhasil diubah',
                'code' => 200,
                "password" => $newPass,
                
            ];
        } else{
                $out = [
                    "message" => "username/email salah",
                    "code"    => 401,
                ];
        }
        return response()->json($out);



    }

    //
}
