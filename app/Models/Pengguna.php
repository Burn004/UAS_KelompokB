<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengguna extends Model
{
    use HasFactory;
    /**
* fillable
*
* @var array
*/
protected $fillable = [
'nama',
'email',
'tanggal_lahir',
'password',
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

