<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Lumen\Auth\Authorizable;

class VisitorCategory extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, SoftDeletes;
    // Laravel documentation: https://laravel.com/docs/7.x/eloquent

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'visitor_category';

    protected $primaryKey = 'id';

    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'time'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [

    ];
}
