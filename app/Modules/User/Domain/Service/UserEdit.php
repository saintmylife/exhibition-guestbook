<?php

namespace App\Modules\User\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\User\Domain\UserFilter;
use App\Modules\User\Repository\UserRepositoryInterface;
use App\Modules\User\UserDto;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * UserEdit service
 */
class UserEdit extends BaseService
{
    private $filter;
    private $userRepo;

    public function __construct(UserFilter $filter, UserRepositoryInterface $userRepo)
    {
        $this->filter = $filter;
        $this->userRepo = $userRepo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $userDto = $this->makeDto($data, new UserDto);
        $userDto->id = $id;

        try {
             $user = $this->userRepo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        try{
            Gate::authorize('owner', $user->user_id);
        } catch (AuthorizationException $e){
            return $this->newPayload(Payload::STATUS_UNAUTHORIZED);
        }

        if (! $this->filter->forUpdate($userDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        $dataForDb = $userDto->getData();

        $update = $this->userRepo->update($dataForDb, $id);

        return $this->newPayload(Payload::STATUS_UPDATED, compact('data'));
    }
}