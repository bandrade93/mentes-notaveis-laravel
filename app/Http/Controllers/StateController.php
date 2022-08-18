<?php

namespace App\Http\Controllers;

use App\Http\Requests\StateRequest;
use App\State;
use Illuminate\Http\Request;
use DataTables;

class StateController extends Controller
{
    public function index(Request $request)
    {
        $states = State::all();

        if (!$states) {
            return response(['message' => 'Nenhum estado encontrado!'], 404);
        }

        $columns = [
            ['title' => __('#'), 'orderable' => false, 'searchable' => false],
            ['title' => __('ID'), 'field' => 'id', 'data' => 'id'],
            ['title' => __('Nome'), 'field' => 'name', 'data' => 'name'],
            ['title' => __('UF'), 'field' => 'uf', 'data' => 'uf'],
            ['title' => __('Status'), 'field' => 'active_text', 'data' => 'active_text'],
            ['field' => 'active', 'data' => 'active', 'visible' => false],
        ];

        if ($request->ajax()) {
            return DataTables::of($states)->make(true);
        }

        $status = [
            ['value' => 0, 'label' => 'Inativo'],
            ['value' => 1, 'label' => 'Ativo']
        ];

        return view('states.index', compact('columns', 'status'));
    }

    public function create()
    {
        $state = new State();

        return view('states.create', compact('state'));
    }

    public function store(StateRequest $request)
    {
        $state = new State($request->validated());

        if (!$state->save()) {
            return response(['message' => 'Erro ao criar estado!'], 500);
        }

        return response($state);
    }

    public function show(int $id)
    {
        $state = State::find($id);

        if (!$state) {
            return response(['message' => 'Data does not exist.'], 203);
        }

        return response(['state' => $state]);
    }

    public function edit(int $id)
    {
        $state = State::find($id);

        if (!$state) {
            return response(['message' => 'Estado não encontrado!'], 404);
        }

        return view('states.edit', compact('state'));
    }

    public function update(StateRequest $request, int $id)
    {
        $state = State::find($id);

        if (!$state) {
            return response(['message' => 'Estado não encontrado!'], 404);
        }

        if (!$state->update($request->validated())) {
            return response(['message' => 'Erro ao editar estado!'], 500);
        }

        return response()->noContent();
    }

    public function destroy(int $id)
    {
        $state = State::find($id);

        if (!$state) {
            return response(['message' => 'Estado não encontrado!'], 404);
        }

        if (!$state->delete()) {
            return response(['message' => 'Erro ao deletar estado!'], 500);
        }

        return response()->noContent();
    }

    public function list()
    {
        $states = State::select(['id', 'name'])
            ->where('active', 1)
            ->get()
			->map(function ($itemType) {
				return [
					'label' => $itemType->name,
					'value' => $itemType->id
				];
			})
			->values();

        return response($states);
    }
}
