<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\MessageStoreRequest;
use App\Http\Resources\MessageCollectionResourceInterface;
use App\Http\Resources\MessageResourceInterface;
use App\Models\Author;
use App\Models\Message;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class MessagesController extends Controller
{
    private $message_repository;

    public function __construct(MessageRepository $message_repository)
    {
        $this->message_repository = $message_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Author $author)
    {
        return app()->make('MessageCollectionResource', [$this->message_repository->index($author), Response::HTTP_OK]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageStoreRequest $request, Author $author)
    {
        return app()->make('MessageResource', [$this->message_repository->create($author), Response::HTTP_CREATED]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author, Message $message)
    {
        return app()->make('MessageResource', [$message, Response::HTTP_OK]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author, Message $message)
    {
        return app()->make('MessageResource', [$this->message_repository->updateExceptParent($message), Response::HTTP_ACCEPTED]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author, Message $message)
    {
        return app()->make('MessageResource', [$this->message_repository->delete($message), Response::HTTP_OK]);
    }
}
