<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ResourceController;
use App\Http\Controllers\Traits\SetActiveStatus;
use App\Http\Queries\UserQuery;
use App\Http\Requests\Api\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends ResourceController
{
    use SetActiveStatus;

    public function __construct()
    {
        $this->hook(function () {
            $this->model = User::class;
        });

        $this->hook(function () {
            $this->query = new UserQuery;
        })->only(['index', 'show']);

        $this->hook(function () {
            $this->request = UserRequest::class;
        })->only(['store', 'update']);
    }

    protected function fill($user, $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password'] ?? '');
        if (blank($data['password'])) {
            unset($data['password']);
        }
        $user->fill($data);
    }

    public function parentGroups(User $user)
    {
        return JsonResource::make($user->accesses);
    }

    public function syncParentGroups(Request $request, User $user)
    {
        $request->validate([
            'items' => ['array'],
            'items.*.parent_group_id' => ['required', 'exists:parent_groups,id'],
            'items.*.role_id' => ['required', 'exists:roles,id'],
        ]);

        $sync = collect($request->items)->mapWithKeys(function ($item) {
            $item = (object) $item;
            return [
                $item->parent_group_id => ['role_id' => $item->role_id]
            ];
        });

        return $user->parentGroups()->sync($sync);
    }
}
