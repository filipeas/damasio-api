<?php

namespace Tests\Feature\Product;

use App\Brand;
use App\Category;
use App\Group;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ListProductTest extends TestCase
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
     * @group product
     */
    public function ListandoUmProdutoCadastrado()
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
                'title' => 'subcategoria 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando subcategorias cadastradas
        $this->assertEquals(1, Category::whereNotNull('parent')->count());

        // criando grupo
        $this->post(
            'api/user/group',
            [
                'number' => 1,
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando grupos cadastradas
        $this->assertEquals(1, Group::all()->count());

        // criando marca
        $this->post(
            'api/user/brand',
            [
                'code' => '2424',
                'title' => 'marca 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando marcas cadastradas
        $this->assertEquals(1, Brand::all()->count());

        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.png');

        // adicionando imagem á marca
        $this->post(
            'api/user/brand/1/image',
            [
                'image' => $file,
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // criando produto
        $this->post(
            'api/user/product',
            [
                'cod' => '001 / 002',
                'subcategory' => 2,
                'group' => 1,
                'brands' => [1],
                'description' => 'descrição do produto',
                'application' => 'aplicação do produto',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando produtos cadastradas
        $this->assertEquals(1, Product::all()->count());

        // listando produto
        $this->get(
            'api/user/product/1',
            [],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @group product
     */
    public function ListandoProdutosCadastradosDeUmaCategoriaEspecifica()
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
                'title' => 'subcategoria 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando subcategorias cadastradas
        $this->assertEquals(1, Category::whereNotNull('parent')->count());

        // criando grupo
        $this->post(
            'api/user/group',
            [
                'number' => 1,
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando grupos cadastradas
        $this->assertEquals(1, Group::all()->count());

        // criando marca
        $this->post(
            'api/user/brand',
            [
                'code' => '2424',
                'title' => 'marca 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando marcas cadastradas
        $this->assertEquals(1, Brand::all()->count());

        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.png');

        // adicionando imagem á marca
        $this->post(
            'api/user/brand/1/image',
            [
                'image' => $file,
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // criando produto
        $this->post(
            'api/user/product',
            [
                'cod' => '001 / 002',
                'subcategory' => 2,
                'group' => 1,
                'brands' => [1],
                'description' => 'descrição do produto',
                'application' => 'aplicação do produto',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando produtos cadastradas
        $this->assertEquals(1, Product::all()->count());

        // listando produto
        $this->get(
            'api/user/product/bycategory/1',
            [],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @group product
     */
    public function ListandoProdutosCadastradosDeUmaSubcategoriaEspecifica()
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
                'title' => 'subcategoria 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando subcategorias cadastradas
        $this->assertEquals(1, Category::whereNotNull('parent')->count());

        // criando grupo
        $this->post(
            'api/user/group',
            [
                'number' => 1,
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando grupos cadastradas
        $this->assertEquals(1, Group::all()->count());

        // criando marca
        $this->post(
            'api/user/brand',
            [
                'code' => '2424',
                'title' => 'marca 1',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando marcas cadastradas
        $this->assertEquals(1, Brand::all()->count());

        Storage::fake('avatars');
        $file = UploadedFile::fake()->image('avatar.png');

        // adicionando imagem á marca
        $this->post(
            'api/user/brand/1/image',
            [
                'image' => $file,
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // criando produto
        $this->post(
            'api/user/product',
            [
                'cod' => '001 / 002',
                'subcategory' => 2,
                'group' => 1,
                'brands' => [1],
                'description' => 'descrição do produto',
                'application' => 'aplicação do produto',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);

        // contando produtos cadastradas
        $this->assertEquals(1, Product::all()->count());

        // listando produto
        $this->get(
            'api/user/product/bysubcategory/2',
            [],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }
}
