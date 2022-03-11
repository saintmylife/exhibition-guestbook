<?php

namespace App\Modules\EventType\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use App\Modules\EventType\EventType;

class EventTypeRepositoryEloquent extends BaseEloquentRepository implements EventTypeRepositoryInterface
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
        return EventType::class;
    }
}
