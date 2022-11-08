<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        // not used
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User|null $user
     * @param Topic $topic
     * @return bool
     */
    public function view(?User $user, Topic $topic): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Topic $topic
     * @return bool
     */
    public function update(User $user, Topic $topic)
    {
        return $user->id === $topic->author->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Topic $topic
     * @return bool
     */
    public function delete(User $user, Topic $topic): bool
    {
        return $this->update($user, $topic);
    }
}
