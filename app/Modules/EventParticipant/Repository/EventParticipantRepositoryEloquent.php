<?php

namespace App\Modules\EventParticipant\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use App\Modules\EventParticipant\EventParticipant;

class EventParticipantRepositoryEloquent extends BaseEloquentRepository implements EventParticipantRepositoryInterface
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
        return EventParticipant::class;
    }
}
