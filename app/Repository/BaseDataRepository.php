<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/7/11
 * Time: 11:18
 */

namespace App\Repository;


use App\Models\Admin\BaseAge;
use App\Models\Admin\BaseSalary;
use App\Models\Admin\DictionaryJob;
use App\Models\Admin\DictionaryWorkingPlace;
use App\Models\Admin\Industry;
use App\RepositoryInterface\BaseDataRepositoryInterface;
use App\Models\Admin\CompanyRecruit;

class BaseDataRepository implements BaseDataRepositoryInterface
{
    public function __construct(
        BaseAge $baseAge,
        BaseSalary $baseSalary,
        DictionaryJob $dictionaryJob,
        DictionaryWorkingPlace $dictionaryWorkingPlace,
        Industry $industry,
        CompanyRecruit $companyRecruit
    )
    {
        $this->baseAgeModel = $baseAge;
        $this->baseSalaryModel = $baseSalary;
        $this->dictionaryJobModel = $dictionaryJob;
        $this->dictionaryWorkingPlaceModel = $dictionaryWorkingPlace;
        $this->industryModel = $industry;
        $this->companyRecruitModel = $companyRecruit;
    }

    public function getBaseJobList()
    {
        return $this->dictionaryJobModel->get();
    }

    public function getBaseAgeList()
    {
        return $this->baseAgeModel->get();
    }

    public function getBaseSalaryList()
    {
        return $this->baseSalaryModel->get();
    }

    public function getBaseWorkingplaceList()
    {
        return $this->dictionaryWorkingPlaceModel->get();
    }

    public function getIndustry()
    {
        return $this->industryModel->get();
    }
}