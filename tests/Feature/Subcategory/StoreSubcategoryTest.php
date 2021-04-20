<?php

namespace Tests\Feature\Subcategory;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class StoreSubcategoryTest extends TestCase
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
     * @group Subcategory
     */
    public function criandoSubcategoria()
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

        // contando categorias cadastradas
        $this->assertEquals(1, Category::whereNull('parent')->count());

        // criando subcategoria
        $this->post(
            'api/user/subcategory',
            [
                'parent' => 1,
                'title' => 'categoria 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando marcas cadastradas
        $this->assertEquals(1, Category::whereNotNull('parent')->count());
    }

    /**
     * @test
     * @group Subcategory
     */
    public function criandoSubcategoriaSemParent()
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

        // contando categorias cadastradas
        $this->assertEquals(1, Category::whereNull('parent')->count());

        // criando subcategoria
        $this->post(
            'api/user/subcategory',
            [
                // 'parent' => 1,
                'title' => 'categoria 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);

        // contando marcas cadastradas
        $this->assertEquals(0, Category::whereNotNull('parent')->count());
    }

    /**
     * @test
     * @group Subcategory
     */
    public function criandoSubcategoriaSemTitle()
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

        // contando categorias cadastradas
        $this->assertEquals(1, Category::whereNull('parent')->count());

        // criando subcategoria
        $this->post(
            'api/user/subcategory',
            [
                'parent' => 1,
                'title' => '',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);

        // contando marcas cadastradas
        $this->assertEquals(0, Category::whereNotNull('parent')->count());
    }

    /**
     * @test
     * @group Subcategory
     */
    public function criandoSubcategoriaComTitleAcimaDe30Caracteres()
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

        // contando categorias cadastradas
        $this->assertEquals(1, Category::whereNull('parent')->count());

        // criando subcategoria
        $this->post(
            'api/user/subcategory',
            [
                'parent' => 1,
                'title' => '123456789123456789123456789123456789123456789123456789',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);

        // contando marcas cadastradas
        $this->assertEquals(0, Category::whereNotNull('parent')->count());
    }
}
