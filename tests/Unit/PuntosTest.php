<?php

namespace Tests\Unit;

use Tests\TestCase;

class PuntosTest extends TestCase
{
    /**
     * 
     */
    public function testPuntos() {
        
        $response = $this->get('puntos');

        $response->assertStatus(200)
                ->assertJson(['status' => true]);        
    }
    
    /**
     * 
     */
    public function testPunto() {
        
        $response = $this->get('puntos/1');

        $response->assertStatus(200)
                ->assertJson(['status' => true]);        
    }
    
    /**
     * 
     */
    public function testPuntoStore() {
        
        $response = $this->post('puntos/', ['coor_x' => 2, 'coor_y' => 3]);

        $response->assertStatus(200)
                ->assertJson(['status' => true]);     
    }
    
    /**
     * 
     */
    public function testPuntoPut() {
        
        $response = $this->put('puntos/7', ['coor_x' => 2, 'coor_y' => 3]);

        $response->assertStatus(200)
                ->assertJson(['status' => true]);     
    }
    
    /**
     * 
     */
    public function testPuntoDelete() {
        
        $response = $this->delete('puntos/7');

        $response->assertStatus(200)
                ->assertJson(['status' => true]);     
    }
}
