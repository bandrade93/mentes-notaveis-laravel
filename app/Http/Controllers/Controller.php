<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        if ((Route::current()) && in_array('auth', Route::current()->getAction('middleware'))) {
            
            if (Route::currentRouteName()) {
                $routeName = Route::currentRouteName();
            } else {
                $routeName = Route::current()->parameter('controller')
                    . '.'
                    . Route::current()->getActionMethod();
            }
            
            $this->middleware("can:resource,'{$routeName}'");
        }

        $url = (strpos(url()->previous(), '/create')) 
            ? '/' . explode('.', request()->route()->getAction('as'))[0]
            : url()->previous();
        
        View::share('backUrl', $url);
    }

    public function enableMulti(Request $request)
    {
        $model =  $this->getInstanceModel($request);

        $enable = ($model)::query()
            ->whereIn('id', $request->ids)
            ->update(['active' => 1]);

        if (!$enable) {
            return response(['message' => 'Erro ao atualizar registros!'], 500);
        }

    	return response()->noContent();
    }

    public function disableMulti(Request $request)
    {
        $model =  $this->getInstanceModel($request);

        $disabled = ($model)::query()
            ->whereIn('id', $request->ids)
            ->update(['active' => 0]);

        if (!$disabled) {
            return response(['message' => 'Erro ao atualizar registros!'], 500);
        }

        return response()->noContent();
    }

    public function deleteMulti(Request $request)
    {
        $model =  $this->getInstanceModel($request);

        $delete = ($model)::query()
            ->whereIn('id', $request->ids)
            ->delete();

        if (!$delete) {
            return response(['message' => 'Erro ao deletar registros!'], 500);
        }

        return response()->noContent();
    }

    private function getInstanceModel(Request $request)
    {
        $modelName = Str::singular($request->route('controller'));
        $modelName = Str::studly($modelName);

        return '\App\Models\\' . $modelName;
    }
}
