<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/3/21
 * Time: 9:52
 */

namespace App\Traits\Model;


trait BaseModel
{
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
                            case 'whereNull':
                                $query->whereNull($key);
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

    //过滤提交的数据中非数据库填充字段
    public function filterRequestData($data)
    {
        if (!empty($data) && !empty($this->fillable)) {
            array_push($this->fillable, $this->primaryKey);
            foreach ($data as $key => $value) {
                if (!$key || !in_array($key, $this->fillable)) {
                    unset($data[$key]);
                }
            }
        }
        return $data;
    }

    public function saveInfo($saveArr)
    {
        if (!empty($saveArr[$this->primaryKey])) {
            $keyArr[$this->primaryKey] = $saveArr[$this->primaryKey];
            $this->setRawAttributes($keyArr, true);#刻意将主键传给syncOriginal
            $this->exists = true;
            //unset($saveArr[$this->primaryKey]);
        } else {
            $this->setRawAttributes($saveArr, true);#刻意将主键不给syncOriginal
            $this->exists = false;
        }
        $this->fill($saveArr);
        $result = parent::save($saveArr);
        return $result ? $this : false;
    }

    /**
     * 获取分页列表数据
     * @param $where
     * @param array $orderBy
     * @param $pageNum
     * @return mixed
     */
    public function getPaginateList($where, $orderBy = [], $pageNum = 20)
    {
        $queryObj = $this->formatWhere($where);

        if (!empty($orderBy)) {
            $queryObj = $this->formatOrderBy($queryObj, $orderBy);
        }
        return $queryObj->paginate($pageNum);
    }

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
}