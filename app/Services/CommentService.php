<?php

namespace App\Services;

use App\Repositories\CommentRepositoryInterface;

/**
 * Class CommentService
 */
class CommentService
{
    /** @var CommentRepositoryInterface */
    protected $comment;

    /**
     * @param CommentRepositoryInterface $comment
     */
    public function __construct(CommentRepositoryInterface $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getCommentsByEntry($id)
    {
        return $this->comment->allByEntry($id);
    }

    /**
     * @param $params
     *
     * @return mixed
     */
    public function addComment($params)
    {
        return $this->comment->save($params);
    }
}
