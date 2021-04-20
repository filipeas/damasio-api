<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\StoreSubcategory;
use App\Http\Requests\UpdateSubcategory;
use App\Http\Resources\Subcategory as SubCategoryResource;

class SubcategoryController extends BaseController
{
    /**
     * Método responsável por listar todas as sub-categorias de uma categoria
     * especificada.
     * 
     * GET METHOD
     */
    public function index()
    {
        return $this->sendResponse(
            [
                'categories' => SubCategoryResource::collection(Category::whereNotNull('parent')->get()),
            ],
            'Subcategorias encontradas con sucesso',
        );
    }

    /**
     * Método responsável por cadastrar uma sub-categoria.
     * 
     * POST METHOD
     */
    public function store(StoreSubcategory $request)
    {
        return $this->sendResponse(
            [
                'subcategory' => new SubCategoryResource(Category::create($request->all(), 200)),
            ],
            'Subcategoria cadastrada com sucesso',
        );
    }

    /**
     * Método responsável por retornar uma sub-categoria especifica pelo id.
     * 
     * GET METHOD
     */
    public function show(int $subcategory)
    {
        $subcategory = Category::where('id', $subcategory)->whereNotNull('parent')->first();

        if (is_null($subcategory)) {
            return $this->sendError('Subcategoria não encontrada');
        }

        return $this->sendResponse(
            [
                'category' => new SubCategoryResource($subcategory),
            ],
            'Subcategoria encontrada com sucesso'
        );
    }

    /**
     * Método responsável por atualizar uma sub-categoria especifica pelo id.
     * 
     * PATCH METHOD
     */
    public function update(UpdateSubcategory $request, int $subcategory)
    {
        $subcategory = Category::where('id', $subcategory)->first();

        if (is_null($subcategory)) {
            return $this->sendError('Subcategoria não encontrada');
        }

        $subcategory->parent = $request->parent;
        $subcategory->title = $request->title;
        $subcategory->save();

        return $this->sendResponse(
            [
                'subcategory' => new SubCategoryResource($subcategory),
            ],
            'Subcategoria atualizada com sucesso'
        );
    }

    /**
     * Método responsável por excluir uma sub-categoria especifica pelo id.
     * 
     * DELETE METHOD
     */
    public function destroy(int $subcategory)
    {
        $subcategory = Category::where('id', $subcategory)->first();

        if (is_null($subcategory)) {
            return $this->sendError('Subcategoria não encontrada');
        }

        $subcategory->delete();

        return $this->sendResponse(
            [
                'subcategory' => new SubCategoryResource($subcategory),
            ],
            'Subcategoria excluida com sucesso'
        );
    }
}
