<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ballroom extends Model
{
    use HasFactory;

    /**
* fillable
*
* @var array
*/
protected $fillable = [
    'jenis',
    'jumlah',
    'harga',
    ]; 

    public function getCreatedAttribute()
{
    if (!is_null($this->attributes['created)at'])) {
        return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
    }
}

public function getUpdatedAttribute()
{
    if (!is_null($this->attributes['update_at'])) {
        return Carbon::parse($this->attributes['update_at'])->format('Y-m-d H:i:s');
    }
}
}
