<?php

// namespace Tests\Feature\Group;

// use App\Group;
// use App\User;
// use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
// use Laravel\Passport\Passport;
// use Tests\TestCase;

// class ListGroupTest extends TestCase
// {
//     protected function setUp(): void
//     {
//         parent::setUp();
//         $this->artisan('migrate:fresh');
//         $this->seed([
//             'CreateUsersSeeder',
//         ]);
//     }

//     /**
//      * @test
//      * @group group
//      */
//     public function listandoGrupoCadastrado()
//     {
//         $this->artisan('passport:install');

//         Passport::actingAs(
//             User::where('email', 'user@user.com')->first(),
//             // ['token']
//         );

//         // criando grupo
//         $this->post(
//             'api/user/group',
//             [
//                 'number' => 1,
//             ],
//             ['Accept' => 'application/json']
//         )
//             // ->dump()
//             ->assertStatus(200)
//             ->assertJsonStructure(['success', 'data', 'message']);

//         // contando grupos cadastradas
//         $this->assertEquals(1, Group::all()->count());

//         // listando grupo
//         $this->get(
//             'api/user/group/1',
//             [],
//             ['Accept' => 'application/json']
//         )
//             // ->dump()
//             ->assertStatus(200)
//             ->assertJsonStructure(['success', 'data', 'message']);
//     }

//     /**
//      * @test
//      * @group group
//      */
//     public function listandoTodosOsGrupoCadastrado()
//     {
//         $this->artisan('passport:install');

//         Passport::actingAs(
//             User::where('email', 'user@user.com')->first(),
//             // ['token']
//         );

//         // criando grupo
//         $this->post(
//             'api/user/group',
//             [
//                 'number' => 1,
//             ],
//             ['Accept' => 'application/json']
//         )
//             // ->dump()
//             ->assertStatus(200)
//             ->assertJsonStructure(['success', 'data', 'message']);

//         // contando grupos cadastradas
//         $this->assertEquals(1, Group::all()->count());

//         // listando grupo
//         $this->get(
//             'api/user/group',
//             [],
//             ['Accept' => 'application/json']
//         )
//             // ->dump()
//             ->assertStatus(200)
//             ->assertJsonStructure(['success', 'data', 'message']);
//     }
// }
