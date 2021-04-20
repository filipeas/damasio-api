<?php

namespace App\Http\Controllers\API;

use App\Group;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\StoreGroup;
use App\Http\Requests\UpdateGroup;
use App\Http\Resources\Group as GroupResource;

class GroupController extends BaseController
{
    /**
     * [DESCONTINUADO]
     */
    public function index()
    {
        return $this->sendResponse(
            [
                'groups' => 'função descontinuada',
            ],
            'Grupo cadastrado com sucesso',
        );
    }

    /**
     * Método responsável por cadastrar um número de grupo.
     * 
     * POST METHOD
     */
    public function store(StoreGroup $request)
    {
        return $this->sendResponse(
            [
                'group' => new GroupResource(Group::create($request->all(), 200)),
            ],
            'Grupo cadastrado com sucesso',
        );
    }

    /**
     * Método responsável por retornar produtos de um grupo especifico pelo id do grupo.
     * 
     * GET METHOD
     */
    public function show(int $group)
    {
        $group = Group::where('id', $group)->first();

        if (is_null($group)) {
            return $this->sendError('Grupo não encontrado');
        }

        return $this->sendResponse(
            [
                'group' => new GroupResource($group),
            ],
            'Grupo encontrado com sucesso'
        );
    }

    /**
     * Método responsável por atualizar um numero de grupo especifico pelo id.
     * 
     * PATCH METHOD
     */
    public function update(UpdateGroup $request, int $group)
    {
        $group = Group::where('id', $group)->first();

        if (is_null($group)) {
            return $this->sendError('Grupo não encontrado');
        }

        $group->number = $request->number;
        $group->save();

        return $this->sendResponse(
            [
                'group' => new GroupResource($group),
            ],
            'Grupo atualizado com sucesso'
        );
    }

    /**
     * Método responsável por excluir um grupo especifico pelo id.
     * 
     * DELETE METHOD
     */
    public function destroy(int $group)
    {
        $group = Group::where('id', $group)->first();

        if (is_null($group)) {
            return $this->sendError('Grupo não encontrado');
        }

        $group->delete();

        return $this->sendResponse(
            [
                'group' => new GroupResource($group),
            ],
            'Grupo excluido com sucesso'
        );
    }
}
