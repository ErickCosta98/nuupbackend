<?php

namespace App\Http\Controllers;

use App\Models\likes;
use App\Models\weather_dates;
use Illuminate\Http\Request;

class LikesController extends Controller
{

    /**
     * Almacena un nuevo like en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //validamos los datos
        $request->validate([
            'date' => 'required|date',
            'lat' => 'required',
            'lon' => 'required'
        ]);

        //buscamos la fecha en la tabla de fechas
        $weatherDate = weather_dates::firstOrCreate([
            'date' => $request->date,
            'lat' => $request->lat,
            'lon' => $request->lon
        ]);

        //registramos el like
        $like = new likes();
        $like->weather_dates_id = $weatherDate->id;
        $like->ip_address = $request->ip();
        $like->liked_at = now();
        $like->save();

        //retornamos la respuesta
        //se retornar la cantidad de likes que tiene la fecha
        return response()->json([
            'likes' => $weatherDate->likes->count()
        ]);
    }


    /**
     * Muestra la cantidad de likes para una fecha específica.
     *
     * @param string $date La fecha para la cual se desea obtener la cantidad de likes.
     * @param Request $request La instancia de la clase Request que contiene los datos de la solicitud.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON que contiene la cantidad de likes.
     */
    public function show($date, Request $request)
    {
        //buscamos la fecha en la tabla de fechas
        $weatherDate = weather_dates::where('date', $date)
            ->where('lat', $request->lat)
            ->where('lon', $request->lon)
            ->first();

        //si no existe la fecha retornamos ceros likes
        if (!$weatherDate) {
            return response()->json([
                'likes' => 0
            ]);
        }

        //retornamos la cantidad de likes que tiene la fecha
        return response()->json([
            'likes' => $weatherDate->likes->count()
        ]);
    }
}
