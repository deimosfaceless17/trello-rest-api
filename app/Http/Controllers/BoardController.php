<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\Board\CreateRequest;
use App\Http\Requests\Api\Board\UpdateRequest;
use App\Http\Resources\Board as BoardResource;
use App\Http\Resources\Boards;
use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

//Todo maybe implement something like swagger
class BoardController extends Controller
{
    /**
     * @return Boards
     */
    public function index()
    {
        return new Boards(Auth::user()->boards()->paginate());
    }

    /**
     * @param CreateRequest $request
     *
     * @return BoardResource
     */
    public function create(CreateRequest $request)
    {
        /* @var User */
        $user = Auth::user();

        $board = $user->boards()->create($request->all());

        return new BoardResource($board);
    }

    public function update(int $id, UpdateRequest $request)
    {
        $board = Board::findOrFail($id);

        if (Auth::user()->cant('update', $board)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        $board->update($request->all());

        return new BoardResource($board);
    }
}
