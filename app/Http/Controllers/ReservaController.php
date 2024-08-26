<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva; // Asumiendo que tienes un modelo Reserva
use Carbon\Carbon;

class ReservaController extends Controller
{
    public function listRevs()
    {
        // $month = request('month', Carbon::now()->month);
        // $year = request('year', Carbon::now()->year);

        // $date = Carbon::createFromDate($year, $month, 1);
        // $weeks = [];
        // $reservas = Reserva::whereYear('fecha', $year)
        //                    ->whereMonth('fecha', $month)
        //                    ->get();

        // // Generar el calendario
        // while ($date->month == $month) {
        //     $week = [];
        //     for ($i = 0; $i < 7; $i++) {
        //         if ($date->month == $month) {
        //             $dayReservas = $reservas->where('fecha', $date->toDateString());
        //             $week[] = [
        //                 'date' => $date->day,
        //                 'reservas' => $dayReservas
        //             ];
        //         } else {
        //             $week[] = null;
        //         }
        //         $date->addDay();
        //     }
        //     $weeks[] = $week;
        // }

        // return view('reservas.listado', [
        //     'weeks' => $weeks,
        //     'month' => $date->subMonth(),
        //     'tipos' => ['SENCILLA', 'DOBLE'] // Tipos de reserva
        // ]);
    }
    }

    // public function editReserva($id)
    // {
    //     // Lógica para editar reserva
    // }

    // public function crearReserva()
    // {
    //     // Lógica para mostrar el formulario de crear reserva
    // }

    // public function storeReserva(Request $request)
    // {
    //     // Lógica para almacenar una nueva reserva
    // }

    // public function updateReserva(Request $request)
    // {
    //     // Lógica para actualizar una reserva existente
    // }

    // public function delReserva(Request $request)
    // {
    //     // Lógica para eliminar una reserva
    // }

    // public function loadReservas(Request $request)
    // {
    //     // Lógica para cargar datos de reservas (posiblemente para una tabla dinámica)
    // }
