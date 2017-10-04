<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/3/20
 * Time: 10:30
 */

namespace App\Models;


use App\Traits\Model\BaseModel as traitModel;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    use traitModel;
    protected $fillable = ['id', 'name', 'display_name', 'description'];

    public function rolesPermissionDetail()
    {
        return $this->belongsToMany('App\Models\Admin\Permission', 'permission_role', 'role_id')->orderBy('sort','asc');
    }
}