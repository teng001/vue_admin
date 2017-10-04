<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/7/11
 * Time: 11:19
 */

namespace App\RepositoryInterface;


interface BaseDataRepositoryInterface
{
    public function getBaseJobList();
    public function getBaseAgeList();
    public function getBaseSalaryList();
    public function getBaseWorkingplaceList();
    public function getIndustry();
}