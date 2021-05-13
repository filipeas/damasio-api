<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\ConfigPDF;
use App\User;
use App\Http\Resources\User as ResourcesUser;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class UserController extends BaseController
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
     * Método responsável por atualizar pdfs fixos do sistema de catálogo.
     */
    public function configPDF(ConfigPDF $request)
    {
        $user = User::where('id', auth()->user()->id)->first();

        if (is_null($user)) {
            return $this->sendError('Usuário não encontrado');
        }

        // remove pdf_fixo
        File::delete(storage_path('app/public' . $user->pdf_fixo));

        // armazena pdf no diretorio correto
        $image =  $request->pdf_fixo;
        $name = "paginas-fixas";
        $folder = '/fixed pages/';
        $filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
        $this->uploadOne($image, $folder, 'public', $name);

        // salvando mudança no banco de dados
        $user->pdf_fixo = $filePath;
        $user->save();

        return $this->sendResponse(['user' => new ResourcesUser($user)], 'Configuração realizada com sucesso');
    }
}
