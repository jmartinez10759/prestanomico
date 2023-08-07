<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoUser extends Model
{
    use HasFactory;

    public $table = 'info_users';

    public $guarded = [];
    public $dates = [
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
        'updated_at' => 'datetime:Y-m-d H:00'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
