<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EntryService;
use App\Services\CommentService;

/**
 * Class EntryController
 */
class EntryController extends Controller
{
    /** @var EntryService */
    protected $entry;

    /** @var CommentService */
    protected $comment;

    /**
     * @param EntryService   $entry
     * @param CommentService $comment
     */
    public function __construct(EntryService $entry, CommentService $comment)
    {
        $this->entry = $entry;
        $this->comment = $comment;
        $this->middleware('exists.entry:entry', ['only' => ['show']]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $result = $this->entry
            ->getPage($request->get('page', 1), 20)
            ->setPath($request->getBasePath());
        return view('entry.index', ['page' => $result]);
    }

    /**
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $attributes = [
            'entry' => $this->entry->getEntry($id),
            'comments' => $this->comment->getCommentsByEntry($id)
        ];
        return view('entry.show', $attributes);
    }
}
