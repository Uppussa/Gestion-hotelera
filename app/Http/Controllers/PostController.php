<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Module;
use App\Models\Cat;
use App\Models\Permit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Response;

class PostController extends Controller
{
    protected $model;
    protected $validationRules;
    protected $attributeNames;
    protected $errorMessages;
    protected $validationRulesUpProfile;
    protected $attributeNamesUpProfile;
    protected $errorMessagesUpProfile;
    protected $validationRulesUpPassword;
    protected $attributeNamesUpPassword;
    protected $errorMessagesUpPassword;
    protected $validationRulesAddUser;
    protected $attributeNamesAddUser;

    public function __construct(Post $model)
    {
        $this->validationRulesUpProfile = [
            'name' => 'required|string|max:100',
            'email' => 'required|string|max:100|unique:users',
            'cta_id' => ['required', 'integer'],
        ];
        $this->attributeNamesUpProfile = [
            'nombre' => 'nombre/área',
            'email' => 'correo electrónico',
            'cta_id' => 'oficina',
            'client_id' => 'cliente',
        ];
        $this->errorMessagesUpProfile = [
            'required' => 'El campo :attribute es obligatorio.',
        ];

        $this->validationRulesUpPassword = [
            'password' => ['required', 'max:20'],
        ];
        $this->attributeNamesUpPassword = [
            'password' => 'contraseña',
        ];
        $this->errorMessagesUpPassword = [
            'required' => 'El campo :attribute es obligatorio.',
        ];

        $this->validationRulesAddUser = [
            'name' => 'required|string|max:300',
            'email' => 'required|email|max:100|unique:users',
            'cta_id' => 'required|integer',
            'tipo_emp' => 'required|integer',
            'lvl_id' => 'required|integer',
        ];
        $this->attributeNamesAddUser = [
            'name' => 'nombre o área',
            'email' => 'email',
            'cta_id' => 'oficina',
            'tipo_emp' => 'tipo usuario',
            'lvl_id' => 'nivel',
            'client_id' => 'cliente',
        ];
        $this->errorMessages = [
            'required' => 'El campo :attribute es obligatorio.',
        ];

        $this->model = $model;
    }

    public function listPosts(Request $request)
    {
        $data['title'] = 'Módulo';
        $data['tab'] = 'main';
        $data['url'] = Route::current()->getName();
        if ($data['url'] !== '') {
            $data['permiso'] = auth()->user()->isPermitUrl($data);
            if ($data['permiso']) {
                $data['title'] = $data['permiso']->module->desc;
                $data['tab'] = $data['permiso']->parentModule->nom;

                return view('posts/'.$data['url'], $data);
            } else {
                redireccionar(route('dashboard'), 'Módulo no autorizado.', 'danger');
            }
        } else {
            redireccionar(route('dashboard'), 'Permiso no encontrado.', 'danger');
        }
    }

    public function loadPosts(Request $request)
    {
        $data['page'] = ($request->page) ? $request->page : 1;
        $data['order'] = ($request->order) ? $request->order : 'desc';
        $data['order_by'] = ($request->order_by) ? $request->order_by : 'id';
        $data['search'] = ($request->search) ? trim($request->search) : '';
        $data['per_page'] = ($request->limite) ? $request->limite : 10;
        $data['user'] = ($request->user) ? $request->user : 0;
        $data['filter'] = ($request->filter) ? $request->filter : 0;
        $data['act_fc'] = $request->act_fc;
        $data['dt_ini'] = ($request->dt_ini) ? $request->dt_ini : getFirstLastDate('first', 'month');
        $data['dt_fin'] = ($request->dt_fin) ? $request->dt_fin : getFirstLastDate('last', 'month');
        $data['adyacentes'] = 2;

        $total = $this->search($data, 1);
        $results = $this->search($data, 0);
        
        
        $total_pages = ceil($total / $data['per_page']);
        $response['total'] = $total;

        $response['data'] = '';
        if ($total > 0) {
            $response['data'] .= '<div class="table-responsive"><table id="table-posts" class="table table-row-gray-200  kt_table_users">
                <thead>
                    <tr class="row-link">
                        <th class="text-left w-5">
                            <div class="form-check form-check-sm form-check-custom me-3">
                                <input class="form-check-input chk-delete-all" type="checkbox" data-kt-check="true" data-kt-check-target="#table-users .form-check-input" value="1" />
                            </div>
                        </th>
                        <th data-field="title"  class="th-link"><i class="bi bi-sort-down"></i> Título</th>
                        <th data-field="status" class="th-link w-7 text-center"><i class="bi bi-sort-down"></i> Estado</th>';
            
            $response['data'] .= '<th data-field="user_id" class="th-link text-center"><i class="bi bi-sort-down"></i> Autor</th>';

            

            $response['data'] .= '
                        <th class="w-10 text-center"><i class="bi bi-check-circle"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>';
            foreach ($results as $reg) {
                $response['data'] .= '<tr>
                                        <td class="text-center w-3">
                                            <div class="form-check form-check-sm form-check-custom">
                                                <input class="form-check-input chk-select-delete" type="checkbox" data-id="' . $reg->id . '" value="1" id="chk_' . $reg->id . '" name="chk_' . $reg->id . '">
                                                <label for="chk_' . $reg->id . '" class="form-check-label"> ' . $reg->id . '</label>
                                            </div>
                                        </td>
                                        <td class="">    
                                            <a href="' . route('editPost', $reg) . '">
                                                <img class="rounded-circle" src="'.($reg->image!=null? $reg->image : 'public/assets/custom/images/404.png' ).'" alt="" width="32" height="32" ' . '/>
                                            </a>
                                            <a href="' . route('editPost', $reg) . '" class="text-gray-800 text-hover-primary mb-1">
                                                ' . $reg->title . '
                                                <i class="'.$reg->id.' text-'.$reg->id.' float-end"></i>
                                            </a>
                                        </td>
                                        <td class="text-center">';
                switch ($reg->status) {
                    case 1:
                        $response['data'] .= '<span class="fs-9 badge text-bg-success">Activo</span>';
                        break;
                    case 2:
                        $response['data'] .= '<span class="fs-9 badge text-bg-danger">Publicado</span>';
                        break;
                    default:
                        $response['data'] .= '<span class="fs-9 badge text-bg-dark">Eliminado</span>';
                        break;
                }

                $response['data'] .= '</td>';
        
                
                $response['data'] .= '<td class="text-center">';
                if ($reg->user_id == auth()->user()->id) {
                    $response['data'] .= 'Yo';
                }else{
                    $response['data'] .= $reg->author->name;
                }
                

                $response['data'] .= '</td><td class="text-center">';
                
                $response['data'] .= '<a href="'.route('editPost', $reg).'" class="text-primary btn btn-link"><i class="text-primary fa fa-edit"></i></a>';
                $response['data'] .= '<button class="btn btn-link mdl-del-reg" data-id="'.$reg->id.'" data-nom="'.$reg->title.'" data-bs-toggle="modal" data-bs-target="#del-regs"><i class="text-danger bi bi-trash"></i></button>';
                $response['data'] .= '</td></tr>';
            }
            $response['data'] .= '</tbody></table></div>';
            $response['data'] .= '<div class="border-top">'.paginate($data['page'], $total_pages, $data['adyacentes'], 'load').'</div>';
        } else {
            $response['data'] = '<div class="alert alert-dark text-center" role="alert"><i class="fas fa-search"></i> No hay registros para mostrar.</div>';
        }

        return response()->json($response);
    }

    private function search($data, $mode)
    {
        $query = $this->model;
        if ($data['act_fc'] == 1) {
            $query = $query->whereBetween('fc', [$data['dt_ini'], $data['dt_fin']]);
        }

        if ($data['filter'] > 0) {
            $query = $query->where('posts.status', $data['filter']);
        } else {
            $query = $query->where('posts.status', '>', 0);
        }
        $query = $query->where('posts.id', '!=', auth()->user()->id);

        if (auth()->user()->level_cat_id==1) {
            $query = $query->where('user_id', auth()->user()->id);
        }

        if (auth()->user()->level_cat_id==2) {
            $query = $query->join('users', 'users.id', '=', 'posts.user_id')
            ->where('users.level_cat_id', '<=', 2);
        }

        $words = splitWordSearch($data['search']);
        if ($words) {
            $query = $query->where(function (Builder $q) use ($words) {
                foreach ($words as $word) {
                    $q->whereAny([
                        'title',
                        'content',
                        'slug',
                    ], 'LIKE', '%'.$word.'%');
                }
            });
        }
        $query = $query->orderBy('posts.'.$data['order_by'], $data['order']);
        if ($mode == 0) {
            $data['offset'] = ($data['page'] - 1) * $data['per_page'];
            $query = $query->offset($data['offset'])->limit($data['per_page']);
            $query = $query->get(['posts.id','title', 'content', 'slug', 'image', 'posts.status', 'fc', 'user_id']);
        } else {
            $query = $query->count('posts.id');
        }

        return $query;
    }

    public function getLastPosts(Request $request)
    {
        $data['totalPosts'] = ($request->totalPosts) ? $request->totalPosts : 0;
        $data['page'] = ($request->page) ? $request->page : 1;
        $data['order'] = ($request->order) ? $request->order : 'desc';
        $data['order_by'] = ($request->order_by) ? $request->order_by : 'id';
        $data['search'] = ($request->search) ? trim($request->search) : '';
        $data['per_page'] = ($request->limite) ? $request->limite : 10;
        $data['user'] = ($request->user) ? $request->user : 0;
        $data['filter'] = ($request->filter) ? $request->filter : 0;
        $data['act_fc'] = $request->act_fc;
        $data['dt_ini'] = ($request->dt_ini) ? $request->dt_ini : getFirstLastDate('first', 'month');
        $data['dt_fin'] = ($request->dt_fin) ? $request->dt_fin : getFirstLastDate('last', 'month');
        $data['adyacentes'] = 2;

        $total = $this->search($data, 1);
        $results = $this->search($data, 0);
        
        $response['total'] = $total;

        $response['data'] = '';
        if ($total > $data['totalPosts']) {
            $reg = $results[0];
            $response['data'] .= '<tr>
                                    <td class="text-center w-3">
                                        <div class="form-check form-check-sm form-check-custom">
                                            <input class="form-check-input chk-select-delete" type="checkbox" data-id="' . $reg->id . '" value="1" id="chk_' . $reg->id . '" name="chk_' . $reg->id . '">
                                            <label for="chk_' . $reg->id . '" class="form-check-label"> ' . $reg->id . '</label>
                                        </div>
                                    </td>
                                    <td class="">    
                                        <a href="' . route('editPost', $reg) . '">
                                            <img class="rounded-circle" src="'.($reg->image!=null? $reg->image : 'public/assets/custom/images/404.png' ).'" alt="" width="32" height="32" ' . '/>
                                        </a>
                                        <a href="' . route('editPost', $reg) . '" class="text-gray-800 text-hover-primary mb-1">
                                            ' . $reg->title . '
                                            <i class="'.$reg->id.' text-'.$reg->id.' float-end"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">';
            switch ($reg->status) {
                case 1:
                    $response['data'] .= '<span class="fs-9 badge text-bg-success">Activo</span>';
                    break;
                case 2:
                    $response['data'] .= '<span class="fs-9 badge text-bg-danger">Publicado</span>';
                    break;
                default:
                    $response['data'] .= '<span class="fs-9 badge text-bg-dark">Eliminado</span>';
                    break;
            }

            $response['data'] .= '</td>';
    
            
            $response['data'] .= '<td class="text-center">';
            if ($reg->user_id == auth()->user()->id) {
                $response['data'] .= 'Yo';
            }else{
                $response['data'] .= $reg->author->name;
            }
            $response['data'] .= '</td><td class="text-center">';
            $response['data'] .= '<a href="'.route('editPost', $reg).'" class="text-primary btn btn-link"><i class="text-primary fa fa-edit"></i></a>';
            $response['data'] .= '<button class="btn btn-link mdl-del-reg" data-id="'.$reg->id.'" data-nom="'.$reg->title.'" data-bs-toggle="modal" data-bs-target="#del-regs"><i class="text-danger bi bi-trash"></i></button>';
            $response['data'] .= '</td></tr>';
        } else {
            $response['data'] = '';
        }

        return response()->json($response);
    }
}