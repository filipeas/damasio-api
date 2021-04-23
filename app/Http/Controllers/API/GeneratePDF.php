<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\API\BaseController as BaseController;

class GeneratePDF extends BaseController
{
    /**
     * Método
     */
    public function progressGeneration()
    {
        $categories = Category::whereNull('parent');

        // quantidade de categorias cadastradas
        $countAllCategories = $categories->count();
        // quantidade de categorias que ainda não foram processadas
        $countInProgress = $categories->whereNull('pdf')->count();
        // quantidade de categorias que finalizaram o processo de criação do PDF
        $countFinished = $countAllCategories - $countInProgress;

        return $this->sendResponse(
            [
                'countAllCategories' => $countAllCategories,
                'countInProgress' => $countInProgress,
                'countFinished' => $countFinished,
            ],
            'Analise de processamento das categorias',
        );
    }
}
