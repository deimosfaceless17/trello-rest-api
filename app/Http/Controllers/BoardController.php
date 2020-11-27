<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Board\CreateRequest;
use App\Http\Resources\Board;
use App\Http\Resources\Boards;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function create(CreateRequest $request)
    {
        /* @var User */
        $user = Auth::user();

        $board = $user->boards()->create($request->all());

        return new Board($board);
    }

    public function index()
    {
        return new Boards(Auth::user()->boards()->paginate());
    }
}
