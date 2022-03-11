<?php

namespace App\Modules\Doorprize\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use App\Modules\Doorprize\Doorprize;

class DoorprizeRepositoryEloquent extends BaseEloquentRepository implements DoorprizeRepositoryInterface
{

    protected $fieldSearchable = [];

    public function boot()
    {
        $this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Doorprize::class;
    }
}
