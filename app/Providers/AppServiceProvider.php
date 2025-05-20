<?php

namespace App\Providers;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Schema::defaultStringLength(125);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(ResponseFactory $response): void
    {


         $response->macro('success', function (string $value) {
            return response()->json(data: [
                'msg' => $value,
                'status' => 200,
            ]);
            // return Response::make(strtoupper($value));
        });

        $response->macro('error', function (string $value) {
            return response()->json([
                'msgErr' => $value,
                'status' => 201,
            ], 406);
            // return Response::make(strtoupper($value));
        });

        $response->macro('notfound', function (string $value) {
            return response()->json([
                'msg' => $value,
                'status' => 404,
            ], 404);
            // return Response::make(strtoupper($value));
        });

        $response->macro('exist', function (string $value) {
            return response()->json([
                'msg' => $value,
                'status' => 409,
            ], 409);
        });

        $response->macro('warning', function (string $value) {
            return response()->json([
                'msgWarning' => $value,
                'status' => 202,
            ]);
            // return Response::make(strtoupper($value));
        });

        $response->macro('getPaginatedData', function ($list, $query, $pagination) {
            $response = [
                'current_page'  => $query->currentPage(),
                'data'          => $list,
                'from'          => $query->firstItem(),
                'last_page'     => $query->lastPage(),
                'last_page_url' => $query->lastPage(),
                'next_page_url' => $query->nextPageUrl(),
                'path'          => $query->url($pagination),
                'per_page'      => $query->perPage(),
                'prev_page_url' => $query->previousPageUrl(),
                'to'            => $pagination,
                'total'         => $query->total()
            ];
            return response()->json($response);
        });
    }
}
