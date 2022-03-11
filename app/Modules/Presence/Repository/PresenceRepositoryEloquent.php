<?php

namespace App\Modules\Presence\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use App\Modules\Presence\Presence;

class PresenceRepositoryEloquent extends BaseEloquentRepository implements PresenceRepositoryInterface
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
        return Presence::class;
    }
}
