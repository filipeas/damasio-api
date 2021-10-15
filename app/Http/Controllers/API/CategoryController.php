<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\StoreCategory;
use App\Http\Requests\StorePDFForACategory;
use App\Http\Requests\UpdateCategory;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\CategoryWithSubCategories;
use App\Http\Resources\User as ResourcesUser;
use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CategoryController extends BaseController
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
     * Método responsável por listar todas as categorias.
     * 
     * GET METHOD
     */
    public function index()
    {
        return $this->sendResponse(
            [
                'user' => new ResourcesUser(User::where('id', 1)->first()),
                'categories' => CategoryResource::collection(Category::whereNull('parent')->orderBy('title', 'ASC')->get()),
            ],
            'Categorias encontradas con sucesso',
        );
    }

    /**
     * Método responsável por cadastrar uma categoria.
     * 
     * POST METHOD
     */
    public function store(StoreCategory $request)
    {
        $category = new Category();
        $category->title = $request->title;

        if ($request->hasFile('propaganda')) {
            $image = $request->file('propaganda');

            $name = Str::slug($request->title . (time()));
            $folder = '/uploads/PDF/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();

            $this->uploadOne($image, $folder, 'public', $name);

            $category->propaganda = $filePath;
        }

        if ($request->has('color'))
            $category->color = $request->color;

        if ($request->has('title_color'))
            $category->title_color = $request->title_color;

        if ($request->has('model'))
            $category->model = $request->model;

        $category->save();

        return $this->sendResponse(
            [
                'category' => new CategoryResource($category),
            ],
            'Categoria cadastrada com sucesso',
        );
    }

    /**
     * Método responsável por armazenar arquivo pdf de uma categoria especifica pelo id.
     * 
     * POST METHOD
     */
    public function storePDF(StorePDFForACategory $request, int $category)
    {
        $category = Category::where('id', $category)->first();

        if (is_null($category)) {
            return $this->sendError('Categoria não encontrada');
        }

        $pdf = $request->file('pdf');
        $name = Str::slug($category->title . time());
        $folder = '/uploads/PDF/';
        $filePath = $folder . $name . '.' . $pdf->getClientOriginalExtension();
        $this->uploadOne($pdf, $folder, 'public', $name);
        $category->pdf = $filePath;

        return $this->sendResponse(
            [
                'category' => new CategoryResource($category),
            ],
            'Categoria encontrada com sucesso'
        );
    }

    /**
     * Método responsável por retornar uma categoria especifica pelo id.
     * 
     * GET METHOD
     */
    public function show(int $category)
    {
        $category = Category::where('id', $category)->whereNull('parent')->first();

        if (is_null($category)) {
            return $this->sendError('Categoria não encontrada');
        }

        return $this->sendResponse(
            [
                'category' => new CategoryWithSubCategories($category),
            ],
            'Categoria encontrada com sucesso'
        );
    }

    /**
     * Método responsável por atualizar uma categoria especifica pelo id.
     * 
     * PATCH METHOD
     */
    public function updatecategory(UpdateCategory $request, int $category)
    {
        $category = Category::where('id', $category)->first();

        if (is_null($category)) {
            return $this->sendError('Categoria não encontrada');
        }

        $category->title = $request->title;

        if ($request->hasFile('propaganda')) {
            $image = $request->file('propaganda');

            $name = Str::slug($request->title . (time()));
            $folder = '/uploads/PDF/';
            $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();

            $this->uploadOne($image, $folder, 'public', $name);

            // remove old propaganda
            File::delete(storage_path('app/public' . $category->propaganda));

            $category->propaganda = $filePath;
        }

        if ($request->has('color'))
            $category->color = $request->color;

        if ($request->has('title_color'))
            $category->title_color = $request->title_color;

        if ($request->has('model'))
            $category->model = $request->model;

        $category->save();

        return $this->sendResponse(
            [
                'category' => new CategoryResource($category),
            ],
            'Categoria atualizada com sucesso'
        );
    }

    /**
     * Método responsável por excluir uma categoria especifica pelo id.
     * 
     * DELETE METHOD
     */
    public function destroy(int $category)
    {
        $category = Category::where('id', $category)->first();

        if (is_null($category)) {
            return $this->sendError('Categoria não encontrada');
        }

        $category->delete();

        return $this->sendResponse(
            [
                'category' => new CategoryResource($category),
            ],
            'Categoria excluida com sucesso'
        );
    }
}
