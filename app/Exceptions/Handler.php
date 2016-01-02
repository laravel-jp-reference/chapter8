<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

/**
 * Class Handler
 *
 * エラーハンドラクラス
 * アプリケーションでスローされた例外を、このクラスでまとめて処理を行うことができます
 */
class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }
        // データベースエラーがスローされた場合は、指定したテンプレートで描画します
        if ($e instanceof QueryException) {
            return response()->view('errors.occurred')->setStatusCode(500);
        }
        // スローされるエラーに合わせて表示するテンプレートの変更が可能です
        // ここではデータベースエラーと同じものを利用しています
        if ($e instanceof \ErrorException) {
            return response()->view('errors.occurred')->setStatusCode(500);
        }

        return parent::render($request, $e);
    }
}
