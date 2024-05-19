<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Response;

class UserController extends Controller
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

    public function __construct(User $model)
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

    public function listUsers(Request $request)
    {
        $data['title'] = 'Módulo';
        $data['tab'] = 'main';
        $data['url'] = Route::current()->getName();
        if ($data['url'] !== '') {
            $data['permiso'] = auth()->user()->isPermitUrl($data);
            if ($data['permiso']) {
                $data['title'] = $data['permiso']->module->desc_mod;
                $data['tab'] = $data['permiso']->parentModule->nom_mod;

                return view('users/'.$data['url'], $data);
            } else {
                redireccionar(route('dashboard'), 'Módulo no autorizado.', 'danger');
            }
        } else {
            redireccionar(route('dashboard'), 'Permiso no encontrado.', 'danger');
        }
    }

    public function loadUsers(Request $request)
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
            $response['data'] .= '<div class="table-responsive"><table id="table-users" class="table table-row-gray-200 align-middle kt_table_users">
                <thead>
                    <tr class="row-link">
                        <th class="text-left w-5">
                            <div class="form-check form-check-sm form-check-custom me-3">
                                <input class="form-check-input chk-delete-all" type="checkbox" data-kt-check="true" data-kt-check-target="#table-users .form-check-input" value="1" />
                            </div>
                        </th>
                        <th data-field="name"  class="th-link"><i class="bi bi-sort-down"></i> Nombre</th>
                        <th data-field="status" class="th-link w-7"><i class="bi bi-sort-down"></i> Estado</th>';
            if (auth()->user()->nivel->lvl == 4) {
            //if ($permiso->lvl_per > 1) {
                $response['data'] .= '<th class="w-25">Cliente/Área</th>';
            } else {
                $response['data'] .= '<th class="w-25">Área</th>';
            }
            $response['data'] .= '<th data-field="tel_user" class="th-link"><i class="bi bi-sort-down"></i> Teléfono</th>';

            

            $response['data'] .= '<th class="w-10"><i class="bi bi-ui-checks"></i> Permisos</th>
                        <th class="w-10"><i class="bi bi-check-circle"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>';
            foreach ($results as $reg) {
                $response['data'] .= '<tr>
                                        <td class="text-center w-3">
                                            <div class="form-check form-check-sm form-check-custom">
                                                <input class="form-check-input chk-select-delete" type="checkbox" data-id="' . $reg->id_user . '" value="1" id="chk_' . $reg->id_user . '" name="chk_' . $reg->id_user . '">
                                                <label for="chk_' . $reg->id_user . '" class="form-check-label"> ' . $reg->id_user . '</label>
                                            </div>
                                        </td>
                                        <td class="">
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                    <a href="' . route('editUser', $reg) . '">
                                                        <div class="symbol-label">
                                                            <img src="' . route('imaget', $reg->avatar->nom_img ?? 'none.png') . '" alt="' . ($reg->name) . '" class="w-100">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <a href="' . route('editUser', $reg) . '" class="text-gray-800 text-hover-primary mb-1">
                                                        ' . ($reg->name ?? '') . '
                                                    </a>
                                                    <span class="text-gray-700"><span class="badge small-1 bg-' . ($reg->nivel->color_lvl ?? '') . ' fs-9 align-middle"><i class="' . ($reg->nivel->icon_lvl ?? '') . '"></i> ' . ($reg->nivel->nom_lvl ?? '') . '</span> ' . ($reg->email ?? '') . '</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">';
                switch ($reg->status) {
                    case 1:
                        $response['data'] .= '<span class="fs-9 align-middle badge bg-success">Activo</span>';
                        break;
                    case 2:
                        $response['data'] .= '<span class="fs-9 align-middle badge bg-danger">Bloqueado</span>';
                        break;
                    case 3:
                        $response['data'] .= '<span class="fs-9 align-middle badge bg-warning">Baneado</span>';
                        break;
                    default:
                        $response['data'] .= '<span class="fs-9 align-middle badge bg-secondary">Eliminado</span>';
                        break;
                }

                $response['data'] .= '</td><td>';

                if (auth()->user()->nivel->lvl == 4) {
                //if ($permiso->lvl_per > 1) {
                    if ($reg->client) {                        // code..
                        $response['data'] .= '<a href="' . route('editClient', $reg->client) . '">' . ($reg->client->nom_com ?? '') . '</a><br><span class="text-gray-800">' . ($reg->office->nom_ofi ?? '') . '</span>';
                    }
                } else {
                    $response['data'] .= ($reg->office->nom_ofi ?? '');
                }

                $response['data'] .= '</td>
                                    <td class="text-center">' . $reg->tel_user . '</td>';

                
                $response['data'] .= '<td class="text-center">';
                if ($reg->user_id == auth()->user()->id_user) {
                    $response['data'] .= '<a href="' . route('editUser', $reg) . '#permisos">' . count($reg->permisos) . (count($reg->permisos) == 1 ? ' permiso' : ' permisos') . '</a>';
                } else {
                    $response['data'] .= '' . count($reg->permisos) . (count($reg->permisos) == 1 ? ' permiso' : ' permisos');
                }
                $response['data'] .= '</td><td class="text-center">';
                $response['data'] .= '<a href="'.route('editUser', $reg).'" class="text-primary btn btn-icon fs-3"><i class="text-primary fa fa-edit fs-3"></i></a>';
                $response['data'] .= '<button class="btn btn-icon mdl-del-reg" data-id="'.$reg->id_user.'" data-nom="'.$reg->name.'" data-bs-toggle="modal" data-bs-target="#del-regs"><i class="text-danger fs-3 bi bi-trash"></i></button>';
                $response['data'] .= '</td></tr>';
            }
            $response['data'] .= '</tbody></table></div>';
            $response['data'] .= '<div class="border-top">'.paginate($data['page'], $total_pages, $data['adyacentes'], 'load').'</div>';
        } else {
            $response['data'] = '<div class="alert alert-dark text-center" role="alert"><i class="fas fa-search"></i> No hay registros para mostrar.</div>';
        }

        return response()->json($response);
    }
}
