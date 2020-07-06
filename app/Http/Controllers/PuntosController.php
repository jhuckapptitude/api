<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Puntos;

class PuntosController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $puntos = Puntos::get();
        return response()->json(['status' => true, 'punto' => $puntos])
                    ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
                    'coor_x' => 'required',
                    'coor_y' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'faltan datos'])
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $puntos = new Puntos;

        $id = $puntos->nuevo($request->coor_x, $request->coor_y);

        if($id){
            return response()->json(['status' => true, 'id' => $id])
                    ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['status' => false])
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $punto = Puntos::where('id', $id)->get();
        if(empty($punto)){
            return response()->json(['status' => false])
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
        
        return response()->json(['status' => true, 'punto' => $punto])
                    ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
                    'coor_x' => 'required',
                    'coor_y' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => 'faltan datos'])
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        $puntos = Puntos::find($id);

        $id = $puntos->actualizar($request->coor_x, $request->coor_y);

        if($id){
            return response()->json(['status' => true, 'id' => $id])
                    ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['status' => false])
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $puntos = Puntos::find($id)->delete();

        //Log::debug("JHUCK: $puntos");
        
        /*
        if($puntos->delete()){
            return response()->json(['status' => true])
                    ->setStatusCode(Response::HTTP_OK);
        } else {
            return response()->json(['status' => true])
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);
        } 
         * 
         */
        return response()->json(['status' => true])
                    ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * 
     */
    public function cercanos($id, $limite=0) {

        $origen = Puntos::find($id);
        if(empty($origen))
            return ['status' => false, 'message' => 'Punto no encontrado'];
        
        return ['status' => true, 'distancias' => $this->distancia($origen, $limite )];
    }

    /**
     * 
     * Obtiene los puntos cercanos a un punto origen
     */
    private function distancia(Puntos $origen, $limite) {

        $puntos = Puntos::whereNotIn('id', [$origen->id])->get();
        if(empty($puntos))
            return ['status' => false, 'message' => 'Puntos no encontrados'];
        
        $distancias = [];

        foreach ($puntos as $punto) {

            $theta = $origen->coor_x - $punto->coor_x;

            $dist = sin(deg2rad($origen->coor_y)) * sin(deg2rad($punto->coor_y)) + cos(deg2rad($origen->coor_x)) * cos(deg2rad($punto->coor_x)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);

            if( is_nan($dist))
                continue;
            
            array_push($distancias, ['punto' => $punto->id, 'distancia' => $dist]);

            Log::debug("punto {$punto->id} distancia  $dist");
        }

        uasort($distancias, [$this, 'cmp']);

        return ($limite === 0 ) ? $distancias : array_slice($distancias, 0, $limite);
    }

    /**
     * Compara las distancias para el ordenamiento
     */
    private function cmp($a, $b) {
        if ($a['distancia'] == $b['distancia']) {
            return 0;
        }
        return ($a['distancia'] < $b['distancia']) ? -1 : 1;
    }

}
