<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Requests\CityRequest;
use DataTables;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::with('state')
            ->orderBy('state_id')
            ->orderBy('name');

        $columns = [
            ['title' => __('#'), 'orderable' => false, 'searchable' => false],
            ['title' => __('ID'), 'field' => 'id', 'data' => 'id'],
            ['title' => __('Nome'), 'field' => 'name', 'data' => 'name'],
            ['title' => __('Estado'), 'field' => 'state.name', 'data' => 'state.name'],
            ['title' => __('Status'), 'field' => 'active_text', 'data' => 'active_text'],
            ['field' => 'active', 'data' => 'active', 'visible' => false],
            ['field' => 'state_id', 'data' => 'state_id', 'visible' => false],
        ];

        if ($request->ajax()) {
            return DataTables::eloquent($cities)->make(true);
        }

        return view('cities.index', compact('columns'));
    }

    public function create()
    {
        $city = new City();

        return view('cities.create', compact('city'));
    }

    public function store(CityRequest $request)
    {
        $city = new City($request->validated());

        if (!$city->save()) {
            return response(['message' => 'Erro ao criar cidade!'], 500);
        }

        return response($city);
    }

    public function show(int $id)
    {
        $city = City::with('state')->find($id);;

        if (!$city) {
            return response(['message' => 'Data does not exist.'], 203);
        }

        return response(['city' => $city]);
    }

    public function edit(int $id)
    {
        $city = City::find($id);

        if (!$city) {
            return response(['message' => 'Cidade não encontrada!'], 404);
        }

        return view('cities.edit', compact('city'));
    }

    public function update(CityRequest $request, int $id)
    {
        $city = City::find($id);

        if (!$city) {
            return response(['message' => 'Cidade não encontrada!'], 404);
        }

        if (!$city->update($request->validated())) {
            return response(['message' => 'Erro ao editar cidade!'], 500);
        }

        return response()->noContent();
    }

    public function destroy(int $id)
    {
        $city = City::find($id);

        if (!$city) {
            return response(['message' => 'Estado não encontrado!'], 404);
        }

        if (!$city->delete()) {
            return response(['message' => 'Erro ao deletar estado!'], 500);
        }

        return response()->noContent();
    }

    public function list(int $state_id)
    {
        $cities = City::select(['id', 'name'])
            ->where([
                'active' => 1,
                'state_id' => $state_id
            ])
            ->get()
			->map(function ($itemType) {
				return [
					'label' => $itemType->name,
					'value' => $itemType->id
				];
			})
			->values();

        return response($cities);
    }
}
