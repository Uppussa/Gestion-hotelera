<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Str;
use App\Models\Permit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Response;

class LogController extends Controller
{
    protected $model;
    protected $validationRules;
    protected $attributeNames;
    protected $errorMessages;
    protected $validationRulesAdd;

    public function __construct(Log $model)
    {
        $this->validationRulesAdd = [
            'nom' => 'required|string|max:100|unique:modules',
            'desc' => 'required|string|max:100',
            'icon' => 'required|string|max:100',
            'url_module' => 'required|string|max:100',
        ];

        $this->attributeNames = [
            'nom' => 'nombre',
            'desc' => 'descripción',
            'icon' => 'ícono',
            'url_module' => 'url',
        ];

        $this->errorMessages = [
            'required' => 'El campo :attribute es obligatorio.',
        ];
        $this->model = $model;
    }

    public function listLogs(Request $request)
    {
        $data['title'] = 'Módulo';
        $data['tab'] = 'main';
        $data['url'] = Route::current()->getName();
        if ($data['url'] !== '') {
            $data['permiso'] = auth()->user()->isPermitUrl($data);
            if ($data['permiso']) {
                $data['title'] = $data['permiso']->module->desc;
                $data['tab'] = $data['permiso']->parentModule->nom;

                return view('logs/'.$data['url'], $data);
            } else {
                redireccionar(route('dashboard'), 'Módulo no autorizado.', 'danger');
            }
        } else {
            redireccionar(route('dashboard'), 'Permiso no encontrado.', 'danger');
        }
    }

    public function loadGraphLogs(Request $request)
    {
        $data['div'] = ($request->div) ? $request->div : 'div-cnt-graph';
        $data['tipo_graph'] = ($request->tipo_graph) ? $request->tipo_graph : 1;
        $data['per_graph'] = ($request->per_graph) ? $request->per_graph : 1;
        $data['ini_per'] = ($request->ini_per) ? $request->ini_per : dayWeek('Monday');
        $data['fin_per'] = ($request->fin_per) ? $request->fin_per : dayWeek('Sunday');

        $fechas = dateRange( $data['ini_per'], $data['fin_per'], $step = '+1 day', $format = 'Y-m-d' );
	    $labels = "";
        $response['graph'] = '';
        $errores = [];
        $informativos = [];

        if ($data['per_graph']==1) {
            foreach ($fechas as $fecha) {
                $errores[] = Log::select(DB::raw('id'))->where('tipo_log', 'danger')->whereBetween(DB::raw("DATE_FORMAT(fc_log, '%Y-%m-%d')"), [$fecha, $fecha])->count();
                $informativos[] = Log::select(DB::raw('id'))->whereIn('tipo_log', ['success', 'info'])->where(DB::raw("DATE_FORMAT(fc_log, '%Y-%m-%d')"), $fecha)->count();
            }
            foreach ($fechas as $fecha) {
                $labels.='"'.$fecha.'"'.',';
            }
        }

        if ($data['per_graph']==2) {
            $weeks = getWeeksDate($data['ini_per'], $data['fin_per'], $step = '+1 day', 'Y-m-d');
            foreach ($weeks as $week) {
                $yw = explode("-", $week);
                $data['year'] = $yw[0];
                $data['week'] = $yw[1];
                $errores[] = Log::select(DB::raw('id'))->where('tipo_log', 'danger')->where(DB::raw("DATE_FORMAT(fc_log, '%Y')"), $data['year'])->where(DB::raw("WEEKOFYEAR(DATE_FORMAT(fc_log, '%Y-%m-%d'))"), $data['week'])->count();

                $informativos[] = Log::select(DB::raw('id'))->whereIn('tipo_log', ['success', 'info'])->where(DB::raw("DATE_FORMAT(fc_log, '%Y')"), $data['year'])->where(DB::raw("WEEKOFYEAR(DATE_FORMAT(fc_log, '%Y-%m-%d'))"), $data['week'])->count();
            }
            foreach ($weeks as $week) {
                $yw = explode("-", $week);
                $labels.='"'.$yw[1].'/'.$yw[0].'"'.',';
            }
        }

        if ($data['per_graph']==3) {
            $i = 0;
            $meses = getMonthsDate($data['ini_per'], $data['fin_per'], $step = '+1 day', $format = 'Y-m-d');
            foreach ($meses as $mes) {
                $errores[] = Log::select(DB::raw('id'))->where('tipo_log', 'danger')->where(DB::raw("DATE_FORMAT(fc_log, '%Y-%m')"), $mes)->count();
                $informativos[] = Log::select(DB::raw('id'))->whereIn('tipo_log', ['success', 'info'])->where(DB::raw("DATE_FORMAT(fc_log, '%Y-%m')"), $mes)->count();
            }
            foreach ($meses as $mes) {
                $labels.='"'.$mes.'"'.',';
            }
        }

        if ($data['per_graph']==4) {
            $anios = getYearDate($data['ini_per'], $data['fin_per'], $step = '+1 month', $format = 'Y-m-d');
            foreach ($anios as $anio) {
                $errores[] = Log::select(DB::raw('id'))->where('tipo_log', 'danger')->where(DB::raw("DATE_FORMAT(fc_log, '%Y')"), $anio)->count();
                $informativos[] = Log::select(DB::raw('id'))->whereIn('tipo_log', ['success', 'info'])->where(DB::raw("DATE_FORMAT(fc_log, '%Y')"), $anio)->count();
            }
            foreach ($anios as $anio) {
                $labels.='"'.$anio.'"'.',';
            }
        }
        
        if ($data['tipo_graph']==1) {
            $response['graph'] = '<div class="col-md-12" id="'.$data['div'].'" style="height: 10%;"></div><script type="text/javascript">
                var chart = Highcharts.chart("'.$data['div'].'", {
                    chart: {
                        type: "column"
                    },
    
                    title: {
                        text: ""
                    },
    
                    subtitle: {
                        text: ""
                    },
    
                    legend: {
                        align: "center",
                        verticalAlign: "bottom",
                        layout: "horizontal"
                    },
    
                    xAxis: {
                        categories: ['.$labels.'],
                        labels: {
                            x: -10
                        }
                    },
    
                    yAxis: {
                        allowDecimals: true,
                        title: {
                            text: "Incidencias"
                        },
                        labels: {
                            formatter: function () {
                                return this.value;
                            }
                        }
                    },
                    plotOptions: {
                        column: {
                            minPointLength: 2
                        }
                    },
                    series: [{
                        color: "#c6303e",
                        name: "Errores",
                        data: ['.implode(', ', $errores).']
                    }, {
                        color: "#13795b",
                        name: "Informativos",
                        data: ['.implode(', ', $informativos).']
                    }],
    
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    align: "center",
                                    verticalAlign: "bottom",
                                    layout: "horizontal"
                                },
                                yAxis: {
                                    labels: {
                                        align: "left",
                                        x: 0,
                                        y: -5
                                    },
                                    title: {
                                        text: null
                                    }
                                },
                                subtitle: {
                                    text: null
                                },
                                credits: {
                                    enabled: false
                                }
                            }
                        }]
                    }
                });
            </script>';
        }
    
        if ($data['tipo_graph']==2) {
            $response['graph'] = '<div class="col-md-12" id="'.$data['div'].'" style="height: 100%;"></div></div><script type="text/javascript">
                Highcharts.chart("'.$data['div'].'", {
                    chart: {
                        type: "spline"
                    },
                    title: {
                        text: ""
                    },
                    subtitle: {
                        text: ""
                    },
                    xAxis: {
                        categories: ['.$labels.']
                    },
                    yAxis: {
                        title: {
                            text: "Incidencias"
                        },
                        labels: {
                            formatter: function () {
                                return this.value;
                            }
                        }
                    },
                    tooltip: {
                        crosshairs: true,
                        shared: true
                    },
                    plotOptions: {
                        spline: {
                            marker: {
                                radius: 4,
                                lineColor: "#666666",
                                lineWidth: 1
                            }
                        }
                    },
                    series: [{
                        color: "#dc3545",
                        name: "Errores",
                        marker: {
                            symbol: "square"
                        },
                        data: ['.implode(', ', $errores).']
    
                    }, {
                        color: "#198754",
                        name: "Informativos",
                        marker: {
                            symbol: "diamond"
                        },
                        data: ['.implode(', ', $informativos).']
                    }]
                });
                </script>';
        }
        return response()->json($response);
    }

    public function loadLogs(Request $request)
    {
        $data['page'] = ($request->page) ? $request->page : 1;
        $data['order'] = ($request->order) ? $request->order : 'desc';
        $data['order_by'] = ($request->order_by) ? $request->order_by : 'id';
        $data['search'] = ($request->search) ? trim($request->search) : '';
        $data['per_page'] = ($request->limite) ? $request->limite : 10;
        
        
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
            $response['data'] .= '<div class="table-responsive"><table id="table-logs" class="table table-row-gray-200  kt_table_users">
                <thead>
                    <tr class="row-link">
                        <th class="text-left w-5">
                            <div class="form-check form-check-sm form-check-custom me-3">
                                <input class="form-check-input chk-delete-all" type="checkbox" data-kt-check="true" data-kt-check-target="#table-users .form-check-input" value="1" />
                            </div>
                        </th>
                        <th data-field="title"  class="th-link"><i class="bi bi-sort-down"></i> Acción</th>
                        <th data-field="status" class="th-link w-7 text-center"><i class="bi bi-sort-down"></i> Tipo</th>';
            
            $response['data'] .= '<th data-field="user_id" class="th-link text-center"><i class="bi bi-sort-down"></i> IP</th>';

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
                                        <td>
                                            ' . $reg->action_log . '
                                        </td>
                                        <td class="text-center">';
                switch ($reg->tipo_log) {
                    case 'success':
                        $response['data'] .= '<span class="fs-9 badge text-bg-success"><i class="bi bi-check-circle"></i> Correcto</span>';
                        break;
                    case 'danger':
                        $response['data'] .= '<span class="fs-9 badge text-bg-danger"><i class="bi bi-x-circle"></i> Error</span>';
                        break;
                    case 'info':
                        $response['data'] .= '<span class="fs-9 badge text-bg-info"><i class="bi bi-info-circle"></i> Información</span>';
                        break;
                    default:
                        $response['data'] .= '<span class="fs-9 badge text-bg-dark"><i class="bi bi-trash"></i> Eliminado</span>';
                        break;
                }

                $response['data'] .= '</td>';
        
                
                $response['data'] .= '<td class="text-center">';
                
                $response['data'] .= '</td>
                                        <td class="text-center">';
                $response['data'] .= '<button class="btn btn-link mdl-del-reg" data-id="'.$reg->id.'" data-nom="'.$reg->action_log.'" data-bs-toggle="modal" data-bs-target="#del-regs"><i class="text-danger bi bi-trash"></i></button>';
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
            $query = $query->whereBetween('fc_log', [$data['dt_ini'], $data['dt_fin']]);
        }

        $words = splitWordSearch($data['search']);
        if ($words) {
            $query = $query->where(function (Builder $q) use ($words) {
                foreach ($words as $word) {
                    $q->whereAny([
                        'action_log',
                        'tipo_log',
                        'ip_log',
                        'table_log',
                        'from_log',
                        'user_id',
                    ], 'LIKE', '%'.$word.'%');
                }
            });
        }
        $query = $query->orderBy('logs.'.$data['order_by'], $data['order']);
        if ($mode == 0) {
            $data['offset'] = ($data['page'] - 1) * $data['per_page'];
            $query = $query->offset($data['offset'])->limit($data['per_page']);
            $query = $query->get(['logs.id','action_log', 'ip_log', 'from_log', 'table_log', 'user_id', 'fc_log', 'tipo_log']);
        } else {
            $query = $query->count('logs.id');
        }

        return $query;
    }
}
