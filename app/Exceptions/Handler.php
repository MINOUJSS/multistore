<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (HttpExceptionInterface $e, Request $request) {
            if ($request->expectsJson()) {
                return null;
            }

            $status = $e->getStatusCode();
            $handledStatuses = [404, 500, 403, 419];

            if (in_array($status, $handledStatuses)) {
                $view = $this->resolveErrorView($status, $request);
                if ($view && view()->exists($view)) {
                    return response()->view($view, [
                        'exception' => $e,
                        'status' => $status,
                    ], $status, $e->getHeaders());
                }
            }
        });
    }

    /**
     * Resolve the appropriate domain error view based on request context.
     */
    protected function resolveErrorView(int $status, Request $request): string
    {
        // 1. Tenant Store Context (Subdomain / Custom Domain)
        if (function_exists('tenant') && tenant()) {
            try {
                $user = function_exists('get_user_data') ? get_user_data(tenant('id')) : null;
                $type = $user ? $user->type : null;

                if ($type === 'supplier') {
                    $view = "stores.suppliers.errors.{$status}";
                    if (view()->exists($view)) {
                        return $view;
                    }
                } else {
                    $view = "stores.sellers.errors.{$status}";
                    if (view()->exists($view)) {
                        return $view;
                    }
                }
            } catch (\Throwable $th) {
                return "stores.sellers.errors.{$status}";
            }
        }

        // 2. Seller Dashboard Context
        if ($request->is('seller-panel*') || ($request->user() && $request->user()->type === 'seller' && !$request->is('admin*'))) {
            $view = "users.sellers.errors.{$status}";
            if (view()->exists($view)) {
                return $view;
            }
        }

        // 3. Supplier Dashboard Context
        if ($request->is('supplier-panel*') || ($request->user() && $request->user()->type === 'supplier' && !$request->is('admin*'))) {
            $view = "users.suppliers.errors.{$status}";
            if (view()->exists($view)) {
                return $view;
            }
        }

        // 4. Default to Landing Page / Site Error Context
        return "site.errors.{$status}";
    }
}
