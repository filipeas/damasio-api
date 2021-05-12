<?php

namespace App\Http\Controllers\API;

use App\BrandProduct;
use App\Category;
use App\Product;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\StoreImageInProduct;
use App\Http\Requests\StoreProduct;
use App\Http\Requests\UpdateBrandsInProduct;
use App\Http\Requests\UpdateProduct;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends BaseController
{
    /**
     * Método responsável por guardar arquivo do produto no servidor.
     * 
     */
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);

        return $file;
    }

    /**
     * Método responsável por listar produtos de uma categoria.
     * 
     * GET METHOD
     */
    public function listByCategory(int $category)
    {
        $category = Category::where('id', $category)->whereNull('parent')->first();

        if (is_null($category)) {
            return $this->sendError('Categoria não encontrada');
        }

        return $this->sendResponse(
            [
                'products' => ProductResource::collection($category->productsOfCategory()->get()),
            ],
            'Produtos encontrados con sucesso',
        );
    }

    /**
     * Método responsável por listar produtos de uma sub-categoria.
     * 
     * GET METHOD
     */
    public function listBySubcategory(int $subcategory)
    {
        $subcategory = Category::where('id', $subcategory)->whereNotNull('parent')->first();

        if (is_null($subcategory)) {
            return $this->sendError('Subcategoria não encontrada');
        }

        return $this->sendResponse(
            [
                'products' => ProductResource::collection($subcategory->productsOfSubcategory()->get()),
            ],
            'Produtos encontrados con sucesso',
        );
    }

    /**
     * Método responsável por cadastrar um produto em uma subcategoria especificada e em
     * um grupo especificado.
     * 
     * POST METHOD
     */
    public function store(StoreProduct $request)
    {
        $product = new Product();
        $product->cod = $request->cod;
        $product->subcategory = $request->subcategory;
        // $product->group = $request->group;
        $product->description = $request->description;
        $product->application = $request->application;
        $product->save();

        foreach ($request->brands as $key => $value) {
            $brand_product = new BrandProduct();
            $brand_product->brand = $request->brands[$key];
            $brand_product->product = $product->id;
            $brand_product->save();
        }
        return $this->sendResponse(
            [
                'product' => new ProductResource($product),
            ],
            'Produto cadastrado com sucesso',
        );
    }

    /**
     * Método responsável por armazenar arquivo imagem de um produto especifico pelo id.
     * Remove todas as imagens vinculadas ao produto e insere a nova informada.
     * 
     * POST METHOD
     */
    public function storeImage(StoreImageInProduct $request, int $product)
    {
        $product = Product::where('id', $product)->first();

        if (is_null($product)) {
            return $this->sendError('Produto não encontrada');
        }

        // remove cover
        File::delete(storage_path('app/public' . $product->cover));

        $image = $request->file('cover');
        $name = Str::slug('produto-' . time());
        $folder = '/produtos/';
        $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
        $this->uploadOne($image, $folder, 'public', $name);
        $product->cover = $filePath;
        $product->save();

        return $this->sendResponse(
            [
                'product' => new ProductResource($product),
            ],
            'Produto encontrado com sucesso'
        );
    }

    /**
     * Método responsável por mostrar um produto específico pelo id.
     * 
     * GET METHOD
     */
    public function show(int $product)
    {
        $product = Product::where('id', $product)->first();

        if (is_null($product)) {
            return $this->sendError('Produto não encontrado');
        }

        return $this->sendResponse(
            [
                'product' => new ProductResource($product),
            ],
            'Produto encontrado com sucesso'
        );
    }

    /**
     * Método responsável por atualizar um produto em uma subcategoria especificada e
     * em um grupo especificado.
     * 
     * PUT METHOD
     */
    public function update(UpdateProduct $request, int $product)
    {
        $product = Product::where('id', $product)->first();

        if (is_null($product)) {
            return $this->sendError('Produto não encontrado');
        }

        $product->cod = $request->cod;
        $product->subcategory = $request->subcategory;
        $product->group = $request->group;
        $product->description = $request->description;
        $product->application = $request->application;
        // $product->cover = $request->cover;
        $product->save();

        return $this->sendResponse(
            [
                'product' => new ProductResource($product),
            ],
            'Produto atualizado com sucesso'
        );
    }

    /**
     * Método responsável por atualizar marcas vinculadas ao produto.
     * Esse método apagar as marcas anteriores e atualiza para as novas marcas inseridas.
     * 
     * PUT METHOD
     */
    public function UpdateBrands(UpdateBrandsInProduct $request, int $product)
    {
        $product = Product::where('id', $product)->first();

        if (is_null($product)) {
            return $this->sendError('Produto não encontrado');
        }

        $product->brands()->delete();

        foreach ($request->brands as $key => $value) {
            $brand_product = new BrandProduct();
            $brand_product->brand = $request->brands[$key];
            $brand_product->product = $product->id;
            $brand_product->save();
        }

        return $this->sendResponse(
            [
                'product' => new ProductResource($product),
            ],
            'Marcas do produto atualizado com sucesso'
        );
    }

    /**
     * Método responsável por excluir um produto especifico pelo id.
     * 
     * DELETE METHOD
     */
    public function destroy(int $product)
    {
        $product = Product::where('id', $product)->first();

        if (is_null($product)) {
            return $this->sendError('Produto não encontrado');
        }

        $product->delete();

        return $this->sendResponse(
            [
                'product' => new ProductResource($product),
            ],
            'Produto excluido com sucesso'
        );
    }
}
