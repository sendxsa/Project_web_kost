<?php

namespace App\Model;

use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    //
    use SoftDeletes;

    protected $table = 'tenant';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'umur',
        'status',
        'pekerjaan',
        'email',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Uuid::uuid4()->toString();
            $model->created_by = \Auth::id();
            $model->updated_by = \Auth::id();
        });
        static::updating(function($model)
        {
            $model->updated_by = Auth::id();
        });
        static::deleting(function ($model) {
            $model->deleted_by = Auth::id();
            $model->save();
        });
    }

}
