<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\EntryService;

/**
 * Class SelfEntry
 *
 * このミドルウェアはブログエントリ作成本人以外は情報更新などを行わないようにする為に動作させます
 */
class SelfEntry
{
    /** @var EntryService $entry */
    protected $entry;

    /**
     * @param EntryService $entry
     */
    public function __construct(EntryService $entry)
    {
        $this->entry = $entry;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $result = $this->entry->getEntryAbility(
            $request->route()->getParameter('entry')
        );
        if (!$result) {
            return redirect()->route('admin.entry.index')
                ->with('message', '投稿者以外は編集できません');
        }

        return $next($request);
    }
}
