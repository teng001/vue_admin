<?php namespace App\Models;

/**
 * 管理员用户模型
 *
 * @author  AaronLiu <liukan0926@stnts.com>
 * @package Common\Models
 */

use Illuminate\Auth\Authenticatable;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
class User extends BaseModel implements AuthenticatableContract
{
    use Authenticatable;
//    use EntrustUserTrait {
//        restore as private restoreEntrust;
//    }
//    use SoftDeletes {
//        restore as private restoreSoftDelete;
//    }
    use EntrustUserTrait;
    public $timestamps = true;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'username',
        'password',
        'is_super',
        'email'
    ];

    protected $dates = ['deleted_at'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];


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

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function _passSecret($passWord)
    {
        return md5(substr(md5($passWord), 0, 16));
    }
}
