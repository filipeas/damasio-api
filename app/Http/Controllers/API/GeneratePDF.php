<?php

namespace App\Http\Controllers\API;

use App\Category;
use Illuminate\Filesystem\Filesystem;
use Barryvdh\DomPDF\Facade as PDF;
use LynX39\LaraPdfMerger\Facades\PdfMerger;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Product;

class GeneratePDF extends BaseController
{
    /**
     * Método responsável por gerar PDF's a partir do banco de dados.
     * Esse método exclui todos os PDF's já gerados e os recria.
     */
    public function generateAllPDF()
    {
        // retornando categorias na ordem algabetica
        $categories = Category::whereNull('parent')->orderBy('title', 'ASC')->get();

        // removendo apontamento dos PDF's de cada categoria
        foreach ($categories as $category) {
            $category->pdf = null;
            $category->save();
        }

        // removendo todos os PDF's do diretório
        $file = new Filesystem;
        $file->cleanDirectory(public_path('storage/pdfs'));

        // array de PDF's gerados. E usado para fazer merge de todos os PDF's gerados no final
        $pdfs = [];
        // controle do número da página corrente
        $pagina = 0;

        foreach ($categories as $category) {
            gc_disable();

            $pdf = PDF::loadView('index', ['categories' => $category, 'page' => $pagina]);

            $path = public_path('storage/pdfs');
            $fileName =  $category->title . '.' . 'pdf';

            $pdf->save($path . '/' . $fileName);
            array_push($pdfs, $path . '/' . $fileName);

            // ajustando contagem de páginas para inserir a pagina atual correta no proximo loop
            $countProducts = Product::where('subcategory', $category->id)->count();
            for ($i = $countProducts; $i > 0; $i = $i - 9) {
                $pagina += 1;
            }

            gc_enable();
            gc_collect_cycles();

            // salvar caminho do PDF na categoria
            $category->pdf = "pdfs/{$fileName}";
            $category->save();
        }

        $pdfMerger = PDFMerger::init();

        foreach ($pdfs as $newpdf) {
            $pdfMerger->addPDF($newpdf, 'all');
        }

        $pdfMerger->merge();
        $pdfMerger->save(public_path('storage/pdfs/catalogo_completo.pdf'), "file");
    }

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
        $countFinished = $categories->whereNotNull('pdf')->count();

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
