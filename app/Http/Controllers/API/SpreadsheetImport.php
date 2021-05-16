<?php

namespace App\Http\Controllers\API;

use App\Brand;
use App\BrandProduct;
use App\Category;
use App\Group;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\XMLFileImport;
use App\Product;
use Exception;
use App\Jobs\GeneratePDF as JobsGeneratePDF;
use App\Jobs\GenerateFinalPDF as GenerateFinalPDF;
use App\User;

class SpreadsheetImport extends BaseController
{
    /**
     * Método responsável por receber a planilha, processar e armazenar
     * os dados direto no banco de dados.
     * 
     * Esse método processa o documento e separa as marcas e categorias,
     * insere elas no banco de dados e depois separa os produtos, vinculando-os
     * a suas marcas e categorias e inserindo no banco de dados por ultimo.
     */
    public function XMLFileImport(XMLFileImport $request)
    {
        $user = User::where('id', auth()->user()->id)->first();

        if (is_null($user->pdf_fixo))
            return $this->sendError("Você precisa inserir primeiro o arquivo de páginas fixas para montar os PDF's.");

        // extraindo linhas da planilha e limpando os campos
        $documento = $this->processXML($request->xml);

        if (!$documento['status'])
            return $this->sendError($documento['message'] . ' linha:' . $documento['line']);

        // manipulando marcas e combinando nome com código
        $marcas = $this->manipulateBrands($documento);

        if (!$marcas['status'])
            return $this->sendError($marcas['message']);

        // manipulando categorias
        $categorias = $this->manipulateCategories($documento);

        if (!$categorias['status'])
            return $this->sendError($categorias['message']);

        // manipulando categorias
        $subcategorias = $this->manipulateSubcategories($documento);

        if (!$subcategorias['status'])
            return $this->sendError($subcategorias['message']);

        // limpando banco de dados para realizar inserção atualizada
        BrandProduct::whereNotNull('id')->delete();
        Product::whereNotNull('id')->delete();
        Brand::whereNotNull('id')->delete();
        Group::whereNotNull('id')->delete();
        Category::whereNotNull('parent')->delete(); // remover subcategorias
        Category::whereNull('parent')->delete(); // remover categorias

        // inserindo marcas
        $marcasModel = [];
        try {
            foreach ($marcas['data'] as $key => $value) {
                $marcasModel[] = Brand::create($value);
            }
        } catch (Exception $ex) {
            return $this->sendError('Ocorreu um erro na inserção das marcas. Verifique com o suporte' . ' erro: ' . $ex->getMessage());
        }

        // inserindo categorias
        $categoriasModel = [];
        try {
            foreach ($categorias['data'] as $key => $value) {
                $categoriasModel[] = Category::create($value);
            }
        } catch (Exception $ex) {
            return $this->sendError('Ocorreu um erro na inserção das categorias. Verifique com o suporte' . ' erro: ' . $ex->getMessage());
        }

        // ajustes finais para inserir subcategorias
        $subcategorias = $this->manipulateSubcategoriesChangeId($categoriasModel, $subcategorias['data']);

        // inserindo subcategorias
        $subcategoriasModel = [];
        try {
            foreach ($subcategorias['data'] as $key => $value) {
                $subcategoriasModel[] = Category::create($value);
            }
        } catch (Exception $ex) {
            return $this->sendError('Ocorreu um erro na inserção das subcategorias. Verifique com o suporte' . ' erro: ' . $ex->getMessage());
        }

        // ajustes finais para inserir produtos
        $produtos = $this->manipulateProducts($documento['data'], $marcasModel, $subcategoriasModel);

        // inserindo produtos
        $produtosModel = [];
        try {
            foreach ($produtos['data'] as $key => $value) {
                $produtosModel[] = Product::create($value);
            }
        } catch (Exception $ex) {
            return $this->sendError('Ocorreu um erro na inserção dos produtos. Verifique com o suporte' . ' erro: ' . $ex->getMessage());
        }

        $marcas_produtos = $this->manipulateBrandsProducts($produtos['data_2'], $produtosModel, $marcasModel);

        // inserindo produtos
        try {
            foreach ($marcas_produtos['data'] as $key => $value) {
                BrandProduct::create($value);
            }
        } catch (Exception $ex) {
            return $this->sendError('Ocorreu um erro na inserção dos vinculos entre produtos e marcas. Verifique com o suporte' . ' erro: ' . $ex->getMessage());
        }

        // realizando chamada de job para executar a criação dos PDF's e enviar a fila de processos
        JobsGeneratePDF::dispatch($user->pdf_fixo);

        // realizando chamada de job para executar a criação do PDF final e enviar a fila de processos
        GenerateFinalPDF::dispatch($user);

        return $this->sendResponse([], "Atualização do banco de dados realizada com sucesso. Gerando PDF's");
    }

    /** FUNÇÕES PRIVADAS */

    /**
     * Método responsável por manipular os vinculos entre um produto e suas marcas,
     * depois realizar inserção no banco de dados.
     */
    private function manipulateBrandsProducts($produtos, $produtosModel, $marcasModel)
    {
        $tmp_brand_product = [];
        $combinacao = array_combine(array_column($produtosModel, 'id'), array_column($produtos, 'brand'));

        foreach ($combinacao as $key => $codMarcas) {
            foreach ($codMarcas as $codMarca) {
                $indice = array_search($codMarca, array_column($marcasModel, 'code'));
                array_push($tmp_brand_product, [
                    'product' => $key,
                    'brand' => $marcasModel[$indice]->id,
                ]);
            }
        }

        return ['status' => true, 'message' => "Vinculos entre produto e marcas extraidos com sucesso", 'data' => $tmp_brand_product];
    }
    /**
     * Método responsável por manipular todos os dados da planilha, ajustar
     * ids das marcas e subcategorias para inserção no banco de dados.
     */
    private function manipulateProducts($documento, $marcasModel, $subcategoriasModel)
    {
        $tmp_products = [];
        $brand_products = [];

        foreach ($documento as $key => $value) {
            // inserindo vinculos com as marcas
            array_push($brand_products, ['product' => 'x', 'brand' => $value['cod_marcas']]);

            // inserindo produto
            $indice = array_search($value['categorias_2'], array_column($subcategoriasModel, 'title'));
            array_push($tmp_products, [
                'cod' => implode(", ", $value['codigo2']),
                'subcategory' => $subcategoriasModel[$indice]->id,
                // 'group' => 0, // não existe tratamento para essa variavel no momento
                'description' => $value['descricao'],
                'application' => $value['aplicacao'],
                'cover' => $value['capa'],
            ]);
        }

        return ['status' => true, 'message' => "Produtos extraidos com sucesso", 'data' => $tmp_products, 'data_2' => $brand_products];
    }
    /**
     * Método responsável por manipular todas as categorias detectadas no array
     * de extração da planilha original.
     */
    private function manipulateCategories($documento)
    {
        $categorias = array_unique(array_column($documento['data'], 'categorias_3'));
        $tmp_categorias = [];

        foreach ($categorias as $key => $value) {
            array_push($tmp_categorias, ['title' => $value]);
        }

        return ['status' => true, 'message' => "Categorias extraidas com sucesso", 'data' => $tmp_categorias];
    }

    /**
     * Método responsável por manipular todas as subcategorias detectadas no array
     * de extração da planilha original.
     */
    private function manipulateSubcategories($documento)
    {
        $categorias = array_column($documento['data'], 'categorias_3');
        $subcategorias = array_column($documento['data'], 'categorias_2');

        $combinacao = array_combine($subcategorias, $categorias);
        $tmp_combinacao = [];

        foreach ($combinacao as $subcategoria => $categoria) {
            array_push($tmp_combinacao, ['parent' => $categoria, 'title' => $subcategoria]);
        }

        return ['status' => true, 'message' => "Subcategorias extraidas com sucesso", 'data' => $combinacao];
    }

    /**
     * Método responsável por alterar titulo da categoria pelo id da mesma,
     * para inserção das subcategorias.
     */
    private function manipulateSubcategoriesChangeId($categoriasModel, $subcategorias)
    {
        $tmp_subcategorias = [];
        foreach ($subcategorias as $subcategoria => $categoria) {
            $indice = array_search($categoria, array_column($categoriasModel, 'title'));
            array_push($tmp_subcategorias, ['parent' => $categoriasModel[$indice]->id, 'title' => $subcategoria]);
        }

        return ['status' => true, 'message' => "Subcategorias montadas com sucesso", 'data' => $tmp_subcategorias];
    }

    /**
     * Método responsável por manipular todas as marcas detectadas no
     * array de extração da planilha original.
     */
    private function manipulateBrands($documento)
    {
        $nome_marcas = array_column($documento['data'], 'nome_marcas');
        $tmp_nome_marcas = [];
        $cod_marcas = array_column($documento['data'], 'cod_marcas');
        $tmp_cod_marcas = [];

        // extraindo nome das marcas
        foreach ($nome_marcas as $key => $arrayMarcas) {
            foreach ($arrayMarcas as $key2 => $value2) {
                // if (in_array($value2, $tmp_nome_marcas))
                //     continue;
                array_push($tmp_nome_marcas, $value2);
            }
        }

        // extraindo codigo das marcas
        foreach ($cod_marcas as $key => $arrayCodMarcas) {
            foreach ($arrayCodMarcas as $key2 => $value2) {
                // if (in_array($value2, $tmp_cod_marcas))
                //     continue;
                array_push($tmp_cod_marcas, $value2);
            }
        }

        // verificando se o tamanho dos arrays são iguais
        if (count($tmp_nome_marcas) != count($tmp_cod_marcas))
            return ['status' => false, 'message' => "O tamanho dos vetores de nome de marcas e seus códigos são diferentes", 'data' => false];

        $combinacao = array_combine($tmp_cod_marcas, $tmp_nome_marcas);
        $tmp_combinacao = [];

        foreach ($combinacao as $key => $value) {
            array_push($tmp_combinacao, ['code' => $key, 'title' => $value, 'image' => "marcas/{$key}.jpg"]);
        }

        return ['status' => true, 'message' => "Marcas extraidas com sucesso", 'data' => $tmp_combinacao];
    }

    /**
     * Método responsável por extrair todos os dados do arquivo XML,
     * limpar todos os campos e verificar se há algum erro em alguma linha.
     * 
     * @return array ['status' => bool, 'message' => string, 'line' => integer]
     */
    private function processXML($request)
    {
        $path = storage_path('app/public/produtos/');

        $arquivo = new \DOMDocument();
        $arquivo->load($request);

        $linhas = $arquivo->getElementsByTagName("Row");

        // variáveis de controle
        $primeira_linha = true;
        $arrayReturn = [];

        foreach ($linhas as $key => $linha) {
            // Caso haja uma linha completamente vazia, ignorar
            // verificando se há algum atributo vazi no documento, evitando leitura
            // de dados inexistentes.
            if (
                !is_object($linha->getElementsByTagName("Data")->item(0)) && !is_object($linha->getElementsByTagName("Data")->item(1)) ||
                !is_object($linha->getElementsByTagName("Data")->item(2)) && !is_object($linha->getElementsByTagName("Data")->item(3)) ||
                !is_object($linha->getElementsByTagName("Data")->item(4)) && !is_object($linha->getElementsByTagName("Data")->item(5)) ||
                !is_object($linha->getElementsByTagName("Data")->item(6)) && !is_object($linha->getElementsByTagName("Data")->item(7))
            )
                continue;

            // Extrair dados a partir da segunda linha do documento,
            // eliminando a primeira linha (cabeçalho) do arquivo.
            if ($primeira_linha == false && $linha->getElementsByTagName("Data")->item(0)->nodeValue !== NULL) {
                // verificando se há algum atributo vazi no documento, evitando leitura
                // de dados inexistentes.
                if (
                    !is_object($linha->getElementsByTagName("Data")->item(0)) || !is_object($linha->getElementsByTagName("Data")->item(1)) ||
                    !is_object($linha->getElementsByTagName("Data")->item(2)) || !is_object($linha->getElementsByTagName("Data")->item(3)) ||
                    !is_object($linha->getElementsByTagName("Data")->item(4)) || !is_object($linha->getElementsByTagName("Data")->item(5)) ||
                    !is_object($linha->getElementsByTagName("Data")->item(6)) || !is_object($linha->getElementsByTagName("Data")->item(7))
                )
                    return ['status' => false, 'message' => "Há um campo vazio", 'line' => $key + 1, 'data' => false];

                $primeiroCod = array_map(function ($value) {
                    $value = trim($value);
                    $value = preg_replace("[^a-zA-Z0-9_]", "", strtr($value, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
                    // $value = intval($value);
                    return $value;
                }, explode("/", $linha->getElementsByTagName("Data")->item(0)->nodeValue));
                $segundoCod = array_map(function ($value) {
                    $value = trim($value);
                    $value = preg_replace("[^a-zA-Z0-9_]", "", strtr($value, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
                    // $value = intval($value);
                    return $value;
                }, explode("/", $linha->getElementsByTagName("Data")->item(1)->nodeValue));

                $descricao = trim($linha->getElementsByTagName("Data")->item(2)->nodeValue);
                $aplicacao = trim($linha->getElementsByTagName("Data")->item(3)->nodeValue);

                $nome_marcas = array_map('trim', explode("/", $linha->getElementsByTagName("Data")->item(4)->nodeValue));
                $cod_marcas = array_map(function ($value) {
                    $value = trim($value);
                    $value = preg_replace("[^a-zA-Z0-9_]", "", strtr($value, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));
                    // $value = intval($value);
                    return $value;
                }, explode("/", $linha->getElementsByTagName("Data")->item(5)->nodeValue));

                $categorias_3 = trim($linha->getElementsByTagName("Data")->item(6)->nodeValue);
                $categorias_2 = trim($linha->getElementsByTagName("Data")->item(7)->nodeValue);

                // removendo valores vazios no array do primeiro código
                $primeiroCod = array_filter($primeiroCod);
                // removendo valores vazios no array do segundo código
                $segundoCod = array_filter($segundoCod);
                // removendo valores vazios no array do nome das marcas
                $nome_marcas = array_filter($nome_marcas);
                // removendo valores vazios no array de codigo das marcas
                $cod_marcas = array_filter($cod_marcas);

                // verificando se os primeiros códigos são numéricos
                foreach ($primeiroCod as $codigo1) {
                    if (!is_numeric($codigo1))
                        return ['status' => false, 'message' => "Há caracteres dentro do primeiro código. '{$codigo1}'", 'line' => $key + 1, 'data' => false];
                }

                // verificando se os segundos códigos são numéricos
                foreach ($segundoCod as $codigo2) {
                    if (!is_numeric($codigo2))
                        return ['status' => false, 'message' => "Há caracteres dentro do segundo código. '{$codigo2}'", 'line' => $key + 1, 'data' => false];
                }

                // verificando se os codigos das marcas são numéricos
                foreach ($cod_marcas as $codigoMarca) {
                    if (!is_numeric($codigoMarca))
                        return ['status' => false, 'message' => "Há caracteres dentro do código da marca. '{$codigoMarca}'", 'line' => $key + 1, 'data' => false];
                }

                // verifica se o tamanho do array do nome das marcas é igual ao tamanho do
                // array dos codigos das marcas
                if (count($nome_marcas) != count($cod_marcas))
                    return ['status' => false, 'message' => 'Tamanho dos vetores do nome das marcas e códigos das marcas é diferente', 'line' => $key + 1, 'data' => false];

                // verificar se algum dos campos está vazio
                if (
                    empty($primeiroCod) || empty($segundoCod) ||
                    empty($descricao) || empty($aplicacao) ||
                    empty($nome_marcas) || empty($cod_marcas) ||
                    empty($categorias_3) || empty($categorias_2)
                )
                    return ['status' => false, 'message' => 'Campo em branco', 'line' => $key + 1, 'data' => false];

                // buscando imagem do produto
                foreach ($segundoCod as $image) {
                    if (file_exists($path . str_replace(' ', '', $image) . '.jpg')) {
                        $capa = "produtos/" . str_replace(' ', '', $image) . ".jpg";
                        break;
                    } else $capa = "";
                }

                if ($capa == "")
                    return ['status' => false, 'message' => 'Capa não encontrada para o produto', 'line' => $key + 1, 'data' => false];

                // capturando toda a linha e inserindo no array final
                array_push($arrayReturn, [
                    'codigo1' => $primeiroCod,
                    'codigo2' => $segundoCod,
                    'capa' => $capa,
                    'descricao' => $descricao,
                    'aplicacao' => $aplicacao,
                    'nome_marcas' => $nome_marcas,
                    'cod_marcas' => $cod_marcas,
                    'categorias_3' => $categorias_3,
                    'categorias_2' => $categorias_2,
                ]);
            }
            $primeira_linha = false;
        }

        return ['status' => true, 'message' => 'Leitura e extração realizada com sucesso', 'line' => false, 'data' => $arrayReturn];
    }
}
