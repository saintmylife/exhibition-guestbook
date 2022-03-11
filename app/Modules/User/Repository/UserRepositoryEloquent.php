<?php

namespace App\Modules\User\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use App\Modules\User\User;

class UserRepositoryEloquent extends BaseEloquentRepository implements UserRepositoryInterface
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
        return User::class;
    }
}
