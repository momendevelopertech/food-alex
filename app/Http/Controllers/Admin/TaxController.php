<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Tax;
use App\Services\TaxService;
use App\Http\Requests\TaxRequest;
use App\Http\Requests\TranslationRequest;
use App\Http\Resources\TaxResource;
use App\Http\Requests\PaginateRequest;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class TaxController extends AdminController implements HasMiddleware
{

    public TaxService $taxService;

    public function __construct(TaxService $taxService)
    {
        parent::__construct();
        $this->taxService = $taxService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:settings', only: ['show']),
            new Middleware('permission:settings', only: ['store']),
            new Middleware('permission:settings', only: ['update']),
            new Middleware('permission:settings', only: ['destroy']),
            new Middleware('permission:settings|items', only: ['index']),
            new Middleware('permission:settings', only: ['saveTranslations']),
        ];
    }

    public function index(PaginateRequest $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return TaxResource::collection($this->taxService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(TaxRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Foundation\Application|TaxResource
    {
        try {
            return new TaxResource($this->taxService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(TaxRequest $request, Tax $tax): \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Foundation\Application|TaxResource
    {
        try {
            return new TaxResource($this->taxService->update($request, $tax));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(Tax $tax): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->taxService->destroy($tax);
            return response('', 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(Tax $tax): \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Foundation\Application|TaxResource
    {
        try {
            return new TaxResource($this->taxService->show($tax));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function saveTranslations(TranslationRequest $request, Tax $tax): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return $this->taxService->saveTranslations($request, $tax);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
