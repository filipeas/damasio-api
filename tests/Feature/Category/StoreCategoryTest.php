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

class StoreCategoryTest extends TestCase
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
    public function criarCategoria()
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
    }

    /**
     * @test
     * @group Category
     */
    public function criarCategoriaSemTitle()
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
                'title' => '',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);

        // contando marcas cadastradas
        $this->assertEquals(0, Category::all()->count());
    }

    /**
     * @test
     * @group Category
     */
    public function criarCategoriaComTitleAcimaDe30Caracteres()
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
                'title' => '123456789123456789123456789123456789',
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);

        // contando marcas cadastradas
        $this->assertEquals(0, Category::all()->count());
    }

    /**
     * @test
     * @group Category
     */
    public function SalvarPDFDaCategoria()
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

        Storage::fake('avatars');
        $file = UploadedFile::fake()->create('avatar.pdf', 100);

        // enviando pdf da categoria
        $this->post(
            'api/user/category/1/pdf',
            [
                'pdf' => $file,
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
    public function SalvarPDFDaCategoriaSemEnviarArquivo()
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

        Storage::fake('avatars');
        $file = UploadedFile::fake()->create('avatar.pdf', 100);

        // enviando pdf da categoria
        $this->post(
            'api/user/category/1/pdf',
            [
                // 'pdf' => $file,
            ],
            ['Accept' => 'application/json']
        )
            // ->dump()
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }
}
