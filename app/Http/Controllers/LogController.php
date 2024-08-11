<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use App\Models\Log;
use Illuminate\Http\Request;
use DB;

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
}
