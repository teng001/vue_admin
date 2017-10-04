<?php

namespace App\Models;

// use Hbclare\ModelHelper\Model;
use Hbclare\ModelHelper\Model;

class BaseModel extends Model
{

    public function saveInfo($saveArr)
    {
        $result = parent::saveInfo($saveArr);
        return $result ? $this : false;
    }

    /**
     * 获取分页列表数据
     * @param $where
     * @param array $orderBy
     * @param $pageNum
     * @return mixed
     */
    public function getPaginateList($where, $orderBy = [], $pageNum = 20, $fields = '')
    {
        $queryObj = $this->formatWhere($where);

        if (!empty($orderBy)) {
            $queryObj = $this->formatOrderBy($queryObj, $orderBy);
        }
        if (!empty($fields)) {
            $queryObj = $this->formatField($queryObj, $fields);
        }
        return $queryObj->paginate($pageNum);
    }


    public function formatField($queryObj, $fields)
    {
        $queryObj = $queryObj->select($fields);
        return $queryObj;
    }

    /**
     * 根据条件计算条数
     * @return mixed
     */
    public function getCount($where)
    {
        return $this->formatWhere($where)->count();
    }

    /**
     * 查找一条数据
     * @param array $where eg:['id'=>1,'fild'=>2]
     * @param array $orderBy eg：['id'=>'desc']
     * @return mixed
     */
    public function findOne(array $where, $orderBy = [])
    {
        $queryObj = $this->formatWhere($where);
        if (!empty($orderBy)) {
            $queryObj = $this->formatOrderBy($queryObj, $orderBy);
        }
        return $queryObj->first();
    }

    /**
     * 格式条件语句
     * @param $where
     * @return mixed
     */
    public function formatWhere($where)
    {
        $queryObj = $this->where(function ($query) use ($where) {
            if (!empty($where)) {
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        switch ($value[0]) {
                            case 'whereIn':
                                $query->whereIn($key, $value[1]);
                                break;
                            case 'whereNotIn':
                                $query->whereNotIn($key, $value[1]);
                                break;
                            case 'whereRaw':
                                $query->whereRaw($value[1]);
                                break;
                            case 'whereBetween':
                                $query->whereBetween($key, $value[1]);
                                break;
                            default:
                                $query->where($key, $value[0], $value[1]);
                        }
                    } else {
                        $query->where($key, $value);
                    }
                }
            }
        });
        return $queryObj;
    }

    //通用保存类方法
    // public function saveInfo($saveArr)
    // {
    //     //不存在主键，是新建
    //     if (empty($saveArr[$this->primaryKey])) {
    //         return $this::create($saveArr);
    //     } else {
    //         //否则是修改
    //         $pkValue = $saveArr[$this->primaryKey];
    //         unset($saveArr[$this->primaryKey]);
    //         return $this::where($this->primaryKey, $pkValue)
    //             ->update($saveArr);
    //     }
    // }

    //通用保存类方法  重写basemodel方法  basemodel方法 中的保存 无法触发saving事件
//    public function saveInfo($saveArr)
//    {
//        //不存在主键，是新建
//        if (empty($saveArr[$this->primaryKey])) {
//            return $this::create($saveArr);
//        } else {
//            //否则是修改
//            $pkValue = $saveArr[$this->primaryKey];
//            unset($saveArr[$this->primaryKey]);
//            return $this::find($pkValue)->fill($saveArr)->save();
//        }
//    }


    /**
     * 格式排序语句
     * @param $queryObj
     * @param array $orderBy
     * @return mixed
     */
    private function formatOrderBy($queryObj, $orderBy)
    {
        if (is_array($orderBy)) {
            foreach ($orderBy as $key => $value) {
                if ($value !== 'desc' && $value !== 'asc') {
                    continue;
                }
                $queryObj->orderBy($key, $value);
            }
        }
        return $queryObj;
    }

    //删除方法 触发deleting事件
    public function delById($id)
    {
        return $this::find($id)->delete();
    }

    //过滤提交的数据中非数据库填充字段
    public function filterRequestData($data)
    {
        if (!empty($data) && !empty($this->fillable)) {
            array_push($this->fillable, $this->primaryKey);
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->fillable)) {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }

    public function getDates()
    {
        return array('created_at');
    }
}
