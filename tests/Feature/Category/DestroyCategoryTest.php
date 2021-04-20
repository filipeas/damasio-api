<?php

namespace Tests\Feature\Category;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ListCategoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->seed([
            'CreateUsersSeeder',
        ]);
    }

    /**
     * @test
     * @group Category
     */
    public function ListarCategoriaCadastrada()
    {
        $this->artisan('passport:install');

        Passport::actingAs(
            User::where('email', 'user@user.com')->first(),
            // ['token']
        );

        // criando categoria
        $this->post(
            'api/user/category',
            [
                'title' => 'categoria 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando marcas cadastradas
        $this->assertEquals(1, Category::all()->count());

        // atualizando categoria
        $this->get(
            'api/user/category/1',
            [
                'title' => 'categoria 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @group Category
     */
    public function ListarTodasAsCategoriaCadastradas()
    {
        $this->artisan('passport:install');

        Passport::actingAs(
            User::where('email', 'user@user.com')->first(),
            // ['token']
        );

        // criando categoria
        $this->post(
            'api/user/category',
            [
                'title' => 'categoria 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando marcas cadastradas
        $this->assertEquals(1, Category::all()->count());

        // atualizando categoria
        $this->get(
            'api/user/category',
            [
                'title' => 'categoria 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }
}
