<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     *  usuario puede ver un formulario de inicio de sesión
     * @test
     */
    public function user_can_view_a_login_form()
    {
        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    /**
     * usuario no puede ver un formulario de inicio de sesión cuando está autenticado
     * @test
     */
    // public function user_cannot_view_a_login_form_when_authenticated()
    // {
    //     $user = factory(User::class)->make();
    //     $response = $this->actingAs($user)->get('/login');
    //     $response->assertRedirect('/home');
    // }

    /**
     * usuario puede iniciar sesión con las credenciales correctas
     * @test
     */
//     public function user_can_login_with_correct_credentials()
//     {
//         $user = factory(User::class)->create([
//             'password' => bcrypt($password = 'i-love-laravel'),
//         ]);
//         $response = $this->post('/login', [
//             'email' => $user->email,
//             'password' => $password,
//         ]);
//         $response->assertRedirect('/home');
//         $this->assertAuthenticatedAs($user);
//     }
}
