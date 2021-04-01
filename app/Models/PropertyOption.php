<?php

namespace App\Models;

use App\Models\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyOption extends Model
{
    use SoftDeletes, Translatable;

    protected $fillable = ['name', 'name_en', 'property_id'];

    public function property(){
        return $this->belongsTo(Property::class);
    }

    public function pros(){
        return $this->belongsToMany(Pro::class);
    }
}
