<?php

namespace App\Traits;

trait HashBarcodeTrait
{
    //
    public static function bootHashBarcodeTrait(){
        static::creating(function ($model){
            if (empty($model->made_in)){
                $model->made_in = self::generateMade_in();
            }
        });
    }

    public static function generateMade_in(){
        return "Made in China" ;
    }
}
