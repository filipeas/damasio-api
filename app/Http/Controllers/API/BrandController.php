<?php

namespace App\Http\Controllers\API;

use App\Brand;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\StoreBrand;
use App\Http\Requests\StoreImageInBrand;
use App\Http\Requests\UpdateBrand;
use App\Http\Resources\Brand as BrandResource;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BrandController extends BaseController
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
     * Método responsável por retornar todas as marcas disponíveis.
     * 
     * GET METHOD
     */
    public function index()
    {
        return $this->sendResponse(
            [
                'brands' => BrandResource::collection(Brand::orderBy('title', 'ASC')->get()),
            ],
            'Marcas encontradas con sucesso',
        );
    }

    /**
     * Método responsável por cadastrar uma nova marca.
     * 
     * POST METHOD
     */
    public function store(StoreBrand $request)
    {
        return $this->sendResponse(
            [
                'brand' => new BrandResource(Brand::create($request->all(), 200)),
            ],
            'Marca cadastrada com sucesso',
        );
    }

    /**
     * Método responsável por armazenar arquivo imagem de uma marca especifica pelo id.
     * Remove todas as imagens vinculadas a marca e insere a nova informada.
     * 
     * POST METHOD
     */
    public function storeImage(StoreImageInBrand $request, int $brand)
    {
        $brand = Brand::where('id', $brand)->first();

        if (is_null($brand)) {
            return $this->sendError('Marca não encontrada');
        }

        // remove cover
        File::delete(storage_path('app/public' . $brand->image));

        $image = $request->file('image');
        $name = Str::slug($brand->title . time());
        $folder = '/marcas/';
        $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
        $this->uploadOne($image, $folder, 'public', $name);
        $brand->image = $filePath;
        $brand->save();

        return $this->sendResponse(
            [
                'brand' => new BrandResource($brand),
            ],
            'Marca encontrada com sucesso'
        );
    }

    /**
     * Método responsável por retornar uma marca especifica pelo id.
     * 
     * GET METHOD
     */
    public function show(int $brand)
    {
        $brand = Brand::where('id', $brand)->first();

        if (is_null($brand)) {
            return $this->sendError('Marca não encontrada');
        }

        return $this->sendResponse(
            [
                'brand' => new BrandResource($brand),
            ],
            'Marca encontrada com sucesso'
        );
    }

    /**
     * Método responsável por atualizar uma marca especifica pelo id.
     * 
     * PUT METHOD
     */
    public function update(UpdateBrand $request, int $brand)
    {
        $brand = Brand::where('id', $brand)->first();

        if (is_null($brand))
            return $this->sendError('Marca não encontrada');

        $brand->code = $request->code;
        $brand->title = $request->title;
        $brand->save();

        return $this->sendResponse(
            [
                'brand' => new BrandResource($brand),
            ],
            'Marca atualizada com sucesso'
        );
    }

    /**
     * Método responsável por excluir uma marca especifica pelo id.
     * 
     * DELETE METHOD
     */
    public function destroy(int $brand)
    {
        $brand = Brand::where('id', $brand)->first();

        if (is_null($brand)) {
            return $this->sendError('Marca não encontrada');
        }

        $brand->delete();

        return $this->sendResponse(
            [
                'brand' => new BrandResource($brand),
            ],
            'Marca excluida com sucesso'
        );
    }
}
