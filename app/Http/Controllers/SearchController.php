<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permit;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SearchController extends Controller
{
    protected $model;

    public function __construct(Module $model)
    {
        $this->model = $model;
    }

    public function searchGlobal(Request $request)
    {
        $search = ($request->search) ? trim($request->search) : '';
        
        $res['search'] = '';

        $permisos = Permit::where('status', 1)->where('user_id', auth()->user()->id)->whereHas('module', function (Builder $q) use ($search)  {
            $q->where('status', 1);
            $q->whereIn('type', ['module']);
            $q->whereIn('show_on', ['navbar', 'sidebar']);
            $q->where('status', 1);
            $q->whereAny([
                'nom',
                'desc',
            ], 'LIKE', '%'.$search.'%');
        })->get();


        if ($permisos) {
            $res['search'] .= '<ul class="list-unstyled">';

            foreach ($permisos as $permiso) {
                $res['search'] .= '<li><a class="dropdown-item" href="'.route($permiso->module->url_module).'">
                        <i class="fs-5 mt-2 '.$permiso->module->icon.'"></i> '.$permiso->module->desc.'</a></li>';
            }
            $res['search'] .= '</ul>';

        } else {
            $res['search'] = '<div class="alert alert-secondary text-center" role="alert"><i class="bi bi-search"></i> Sin resultados.</div>';
        }

        return response()->json($res);
    }
}
