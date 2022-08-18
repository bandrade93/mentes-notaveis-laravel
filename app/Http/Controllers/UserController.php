<?php

namespace App\Http\Controllers;

use App\Address;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::select(['id', 'name', 'date', 'phone', 'address_id', 'active'])
            ->with('address.city.state')
            ->get();

        if (!$users) {
            return response(['message' => 'Nenhum usuário encontrado!'], 404);
        }

        $columns = [
            ['title' => __('#'), 'orderable' => false, 'searchable' => false],
            ['title' => __('ID'), 'field' => 'id', 'data' => 'id'],
            ['title' => __('Nome'), 'field' => 'name', 'data' => 'name'],
            ['title' => __('Telefone'), 'field' => 'phone', 'data' => 'phone'],
            [
                'title' => __('Cidade'), 'field' => 'address.city.name',
                'data' => 'address.city.name'
            ],
            [
                'title' => __('Estado'),
                'field' => 'address.city.state.uf',
                'data' => 'address.city.state.uf'
            ],
            ['title' => __('Status'), 'field' => 'active_text', 'data' => 'active_text'],
            ['field' => 'active', 'data' => 'active', 'visible' => false],
        ];

        if ($request->ajax()) {
            return DataTables::of($users)
                ->editColumn('phone', '{{$phone_formated}}')
                ->make(true);
        }

        return view('users.index', compact('columns'));
    }

    public function store(UserRequest $request)
    {
        $response = DB::transaction(function () use ($request) {
            $request['password'] = Hash::make($request->password);

            $address = new Address($request->validated());

            if (!$address->save()) {
                return response(['message' => 'Erro ao salvar endereço.'], 500);
            }

            $user = $address->user()->create($request->validated());

            if (!$user) {
                return response(['message' => 'Erro ao salvar usuário.'], 500);
            }

            return response()->noContent();
        });

        return $response;
    }

    public function create()
    {
        $user = new User();

        return view('users.create', compact('user'));
    }

    public function show(int $id)
    {
        $user = User::select(['id', 'name', 'date', 'phone', 'email', 'address_id', 'active'])
            ->with('address.city.state')
            ->find($id);


        if (!$user) {
            return response(['message' => 'Usuário não encontrado!'], 404);
        }

        return response(['user' => $user]);
    }

    public function update(UserRequest $request, int $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response(['message' => 'Usuário não encontrado!'], 404);
        }

        $response = DB::transaction(function () use ($request, $user) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'date' => $request->date,
                'phone' => $request->phone
            ];

            if (!$user->update($data)) {
                return response(['message' => 'Erro ao salvar usuário.'], 500);
            }

            $data_address = [
                'street' => $request->street,
                'cep' => $request->cep,
                'number' => $request->number,
                'city_id' => $request->city_id
            ];

            if (!$user->address()->update($data_address)) {
                return response(['message' => 'Erro ao salvar endereço.'], 500);
            }

            return response()->noContent();
        });

        return $response;
    }

    public function edit(int $id)
    {
        $user = User::select(['id', 'name', 'date', 'phone', 'email', 'address_id'])
            ->with('address.city.state')
            ->find($id);


        if (!$user) {
            return response(['message' => 'Usuário não encontrado!'], 404);
        }

        return view('users.edit', compact('user'));
    }

    public function destroy(int $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response(['message' => 'No data to delete.'], 203);
        }

        if (!$user::destroy($id)) {
            return response(['message' => 'Error to delete data.'], 500);
        }

        return response(['message' => 'Data removed successfully.'], 201);
    }

    public function getManyUserByState(int $state_id)
    {
        $users = User::query()
            ->whereHas('address.city.state', function ($query) use ($state_id) {
                $query->where('id', $state_id);
            })
            ->count();

        return response(['users' => $users], 201);
    }

    public function getManyUserByCity(int $city_id)
    {
        $users = User::query()
            ->whereHas('address.city', function ($query) use ($city_id) {
                $query->where('id', $city_id);
            })
            ->count();

        return response(['users' => $users], 201);
    }
}
