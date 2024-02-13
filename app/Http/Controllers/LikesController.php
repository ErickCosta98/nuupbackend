<?php

namespace App\Http\Controllers;

use App\Models\likes;
use App\Models\weather_dates;
use Illuminate\Http\Request;

class LikesController extends Controller
{



    //funcion para almacenar los likes
    //se recibe la fecha del clima,la ip del usuario y la fecha en la que se dio like
    //si la fecha no existe en la tabla de fechas se crea
    //se registra el like en la tabla de likes
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

    //funcion para obtener los likes de una fecha
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
