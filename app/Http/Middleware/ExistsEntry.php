<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\EntryService;

/**
 * Class ExistsEntry
 *
 * $ php artisan make:middleware ExistsEntryコマンドで作成したミドルウェアです
 * 存在しないブログエントリにはアクセスしません
 */
class ExistsEntry
{
    /** @var EntryService $entry */
    protected $entry;

    /** @var string  管理画面 ブログ投稿へ遷移させます */
    protected $redirectToAdmin = 'admin.entry.index';

    /** @var string  ブログ画面へ遷移させます */
    protected $redirectTo = 'entry.index';

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
     * @param         $request
     * @param Closure $next
     * @param string  $for
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $for = 'admin')
    {
        if (!$this->entry->getEntry($request->route()->getParameter('entry'))) {
            $route = $this->redirectToAdmin;
            if ($for !== 'admin') {
                $route = $this->redirectTo;
            }

            return redirect()->route($route);
        }

        return $next($request);
    }
}
