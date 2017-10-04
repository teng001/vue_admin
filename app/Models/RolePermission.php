<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/25
 * Time: 18:51
 */

namespace App\Models;


class RolePermission extends BaseModel
{

    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permission_role';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission_id',
        'role_id'
    ];
    /**
     * @var bool
     */
    public $incrementing = true;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        //开启自动原子缓存,设置缓存10小时
        $this->startAutoEachCache(600);

    }
}