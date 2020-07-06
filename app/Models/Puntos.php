<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Puntos extends Model {

    use SoftDeletes;
 
    protected $dates = ['deleted_at'];
 
    protected $fillable = ['coor_x', 'coor_y', 'borrado'];

    /**
     * 
     * @param double $cx -> coordenada x
     * @param double $cy -> coordenada y
     * @return type
     * 
     * Crea un nuevo punto. Por default el campo borrado es 0
     * 
     */
    public function nuevo($cx, $cy) {
        $this->coor_x = $cx;
        $this->coor_y = $cy;

        return $this->save() ? $this->id : false;
    }

    /**
     * 
     * @param double $cx -> coordenada x
     * @param double $cy -> coordenada y
     * @return type
     * 
     * Actualiza un punto.
     * 
     */
    public function actualizar($cx, $cy) {

        $this->coor_x = $cx;
        $this->coor_y = $cy;

        return $this->save() ? $this->id : false;
    }
}
