<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

class UserTest extends TestCase
    {
        use RefreshDatabase;
        public function testRegisterSuccess(){
            $this->post('/api/users',[
                'username' => 'harisriyoni',
                'password' => 'harisriyoni',
                'name' => 'haris',

                ])->assertStatus(201)
                ->assertJson([
                    "data" => [
                        'username' => 'harisriyoni',
                        'name' => 'haris',
                        ]
                    ]);
                }
                public function testRegisterfailed(){
                    $this->post('/api/users',[
                        'username' => '',
                        'password' => '',
                        'name' => '',

                        ])->assertStatus(400)
                        ->assertJson([
                            "errors" => [
                                'username' => [
                                    "The username field is required."

                                ],
                                'password' => [
                                    "The password field is required."

                ],
                'name' => [
                    "The name field is required."

                ],
            ]
            ]);
    }
    public function testRegisterUsernameAlreadyExists(){
        $this->testRegisterSuccess();
        $this->post('/api/users',[
            'username' => 'harisriyoni',
            'password' => 'harisriyoni',
            'name' => 'haris',

        ])->assertStatus(400)
        ->assertJson([
            "errors" => [
                'username' => [
                    "Username sudah terdaftar"
                ],
            ]
            ]);
    }
    public function testLoginBerhasil(){
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login',[
            'username' => 'test',
            'password' => 'test'
        ])->assertStatus(200)
        ->assertJson([
            'data' => [
                'username' => 'test',
                'name' => 'test'
            ]
        ]);
        $user = User::where('username', 'test')->first();
        self::assertNotNull($user->token);
    }
    public function testLoginGagalUsernameNotFound(){
        $this->post('/api/users/login',[
            'username' => 'test',
            'password' => 'test'
        ])->assertStatus(401)
        ->assertJson([
            'errors' => [
                "message" => [
                    "Username atau password Anda salah"
                ],
            ]
        ]);
    }
    public function testLoginGagalPasswordWrong(){
        $this->post('/api/users/login',[
            'username' => 'test',
            'password' => 'salah'
        ])->assertStatus(401)
        ->assertJson([
            'errors' => [
                "message" => [
                    "Username atau password Anda salah"
                ],
            ]
        ]);
    }
}
