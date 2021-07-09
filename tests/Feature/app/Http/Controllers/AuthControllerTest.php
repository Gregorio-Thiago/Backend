<?php


namespace Feature\app\Http\Controllers;


use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function createApplication()
    {
        return require './bootstrap/app.php';
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    public function userAuthenticationTest()
    {
        $payload = [
            'email' => 'name@ficticio.com',
            'password' => 'Login123'
        ];

        $request = $this->post(route('authenticate', ['provider' => 'Teste-autenticacao']), $payload);

        $request->assertResponseStatus(422);
        $request->seeJson(['errors' => ['main' => 'Provider Not found']]);
    }


    public function userRegisteredTest()
    {
        $payload = [
            'email' => 'name@ficticio.com',
            'password' => 'Login123'
        ];

        $request = $this->post(route('authenticate', ['provider' => 'shopkeeper']), $payload);
        $request->assertResponseStatus(401);
        $request->seeJson(['errors' => ['main' => 'Wrong credentials']]);
    }

    public function userPasswordErrorTest()
    {

        $user = User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'error123'
        ];

        $request = $this->post(route('authenticate', ['provider' => 'user']), $payload);
        $request->assertResponseStatus(401);
        $request->seeJson(['errors' => ['main' => 'Wrong credentials']]);

    }

    public function userAuthenticateErrorTest()
    {

        $this->artisan('passport:install');
        $user = User::factory()->create();

        $payload = [
            'email' => $user->email,
            'password' => 'Login123'
        ];

        $request = $this->post(route('authenticate', ['provider' => 'user']), $payload);
        $request->assertResponseStatus(200);
        $request->seeJsonStructure(['access_token','expires_at', 'provider']);
    }

}
