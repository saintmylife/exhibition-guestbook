<?php

namespace App\Modules\Event\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use App\Modules\Event\Event;

class EventRepositoryEloquent extends BaseEloquentRepository implements EventRepositoryInterface
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
        return Event::class;
    }
    public function getActiveEvent()
    {
        return $this->model->where('isActive', true)->first();
    }
    public function countActiveEvent()
    {
        return $this->model->where('isActive', true)->count();
    }
}
