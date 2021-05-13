<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Jobs\GeneratePDF as JobsGeneratePDF;
use Illuminate\Filesystem\Filesystem;
use Barryvdh\DomPDF\Facade as PDF;
use LynX39\LaraPdfMerger\Facades\PdfMerger;

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

    /**
     * Método responsável por mandar executar um job para criação dos PDF's
     */
    public function generateAllPDFs()
    {
        // realizando chamada de job para executar a criação dos PDF's e enviar a fila de processos
        JobsGeneratePDF::dispatch(auth()->user()->pdf_fixo);

        return $this->sendResponse([], "Gerando novos PDF's");
    }
}
