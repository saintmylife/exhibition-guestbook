<?php

namespace App\Modules\Guest\Repository;

use App\Modules\Base\Repository\BaseEloquentRepository;
use App\Modules\Guest\Guest;

class GuestRepositoryEloquent extends BaseEloquentRepository implements GuestRepositoryInterface
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
        return Guest::class;
    }

    public function generateGuestCode(int $event_id, string $event_code)
    {
        $count = $this->model->where('event_id', $event_id)->count();
        return $event_code . \Str::padLeft($count + 1, 4, '0');
    }
    public function findGuestByCode(int $event_id, string $guest_code)
    {
        return $this->model->where('event_id', $event_id)->where('code', $guest_code)->firstOrFail();
    }
}
