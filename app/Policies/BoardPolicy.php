<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;

class BoardPolicy
{
    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Board  $board
     * @return mixed
     */
    public function update(User $user, Board $board)
    {
        return $board->user_id === $user->id;
    }
}
