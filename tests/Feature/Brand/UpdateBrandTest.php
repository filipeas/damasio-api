<?php

namespace Tests\Feature\Brand;

use App\Brand;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UpdateBrandTest extends TestCase
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
     * @group Brand
     */
    public function AtualizarMarca()
    {
        $this->artisan('passport:install');

        Passport::actingAs(
            User::where('email', 'user@user.com')->first(),
            // ['token']
        );

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

        // atualizando marca
        $this->put(
            'api/user/brand/1',
            [
                'code' => '2424',
                'title' => 'marca 1',
            ],
            ['Accept' => 'application/json']
        )
        // ->dump()
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message']);
    }

    /**
     * @test
     * @group Brand
     */
    public function AtualizarMarcaComErroNotitle()
    {
        $this->artisan('passport:install');

        Passport::actingAs(
            User::where('email', 'user@user.com')->first(),
            // ['token']
        );

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

        // atualizando marca
        $this->put(
            'api/user/brand/1',
            [
                'code' => '2424',
                'title' => '',
            ],
            ['Accept' => 'application/json']
        )
        // ->dump()
            ->assertStatus(422)
            ->assertJsonStructure(['errors', 'message']);
    }

    /**
     * @test
     * @group Brand
     */
    public function AdicionarImagemDaMarcaSemInformarNovaImagem()
    {
        $this->artisan('passport:install');

        Passport::actingAs(
            User::where('email', 'user@user.com')->first(),
            // ['token']
        );

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

        // atualizando imagem á marca
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
    }
}
