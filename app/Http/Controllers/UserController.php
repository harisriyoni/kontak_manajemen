<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request): JsonResponse
    {
        // ambil data dulu yang selesai divalidasi
        $data = $request->validated();

        // username harus unik dalam database maka harus dicek terlebih dahulu
        if(User::where('username', $data['username'])->count() > 0) {
            // jika terjadi eroor maka kita gunakan throw exception
            throw new HttpResponseException(response([
                "errors" => [
                    "username" => [
                        "Username sudah terdaftar"
                    ]
                ]
            ], 400));

        }
        //buat user baru dan ambil dari data yang sudah di validasi diatas
        $user = new User($data);
        // jika kita buat seperti ini data attribute harus fillable maka fillable kan di model User
        //hashing password untuk register ketika masuk kedalam database
        //dengan bycrpt yang sudah ada dilaravel
        //lalu di hashing $data['passsword'] akan di masukan ke password
        $user->password = Hash::make($data['password']);
        $user->save(); //maka secara otomatis akan di save, fungsi untuk save

        return (new UserResource($user))->response()->setStatusCode(201);        // akan return responsenya

    }
    public function login(UserLoginRequest $request): UserResource
    {
        $data = $request->validated();

        $user = User::where('username', $data['username'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "message" => [
                        "Username atau password Anda salah"
                    ],
                ]
            ], 401));
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        return new UserResource($user);
    }

    public function get(Request $request): UserResource{
        $user = Auth::user();
        return new UserResource($user);
    }
}
