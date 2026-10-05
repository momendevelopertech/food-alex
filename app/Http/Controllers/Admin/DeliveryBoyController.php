<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Services\OrderService;
use App\Exports\DeliveryBoyExport;
use App\Services\DeliveryBoyService;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\ChangeImageRequest;
use App\Http\Requests\DeliveryBoyRequest;
use App\Http\Resources\UserOrderResource;
use App\Http\Resources\DeliveryBoyResource;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Requests\UserChangePasswordRequest;
use Illuminate\Routing\Controllers\HasMiddleware;

class DeliveryBoyController extends AdminController implements HasMiddleware
{
    private DeliveryBoyService $deliveryBoyService;
    private OrderService $orderService;

    public function __construct(DeliveryBoyService $deliveryBoyService, OrderService $orderService)
    {
        parent::__construct();
        $this->deliveryBoyService = $deliveryBoyService;
        $this->orderService = $orderService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:delivery-boys|online-orders|table-orders|sales-report|pos-orders', only: ['index']),
            new Middleware('permission:delivery-boys', only: ['export']),
            new Middleware('permission:delivery-boys', only: ['changePassword']),
            new Middleware('permission:delivery-boys', only: ['changeImage']),
            new Middleware('permission:delivery-boys', only: ['myOrder']),
            new Middleware('permission:delivery-boys_create', only: ['store']),
            new Middleware('permission:delivery-boys_edit', only: ['update']),
            new Middleware('permission:delivery-boys_delete', only: ['destroy']),
            new Middleware('permission:delivery-boys_show', only: ['show']),
        ];
    }

    public function index(PaginateRequest $request): \Illuminate\Http\Response | \Illuminate\Http\Resources\Json\AnonymousResourceCollection | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return DeliveryBoyResource::collection($this->deliveryBoyService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function store(DeliveryBoyRequest $request): \Illuminate\Http\Response | DeliveryBoyResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new DeliveryBoyResource($this->deliveryBoyService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(DeliveryBoyRequest $request, User $deliveryBoy): \Illuminate\Http\Response | DeliveryBoyResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new DeliveryBoyResource($this->deliveryBoyService->update($request, $deliveryBoy));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(User $deliveryBoy): \Illuminate\Http\Response | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->deliveryBoyService->destroy($deliveryBoy);
            return response('', 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(User $deliveryBoy): \Illuminate\Http\Response | DeliveryBoyResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new DeliveryBoyResource($this->deliveryBoyService->show($deliveryBoy));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function export(PaginateRequest $request): \Illuminate\Http\Response | \Symfony\Component\HttpFoundation\BinaryFileResponse | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return Excel::download(new DeliveryBoyExport($this->deliveryBoyService, $request), 'Delivery-Boy.xlsx');
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function changePassword(UserChangePasswordRequest $request, User $deliveryBoy): \Illuminate\Http\Response | DeliveryBoyResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new DeliveryBoyResource($this->deliveryBoyService->changePassword($request, $deliveryBoy));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function changeImage(ChangeImageRequest $request, User $deliveryBoy): \Illuminate\Http\Response | DeliveryBoyResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new DeliveryBoyResource($this->deliveryBoyService->changeImage($request, $deliveryBoy));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function myOrder(PaginateRequest $request, User $deliveryBoy) : \Illuminate\Http\Response | \Illuminate\Http\Resources\Json\AnonymousResourceCollection | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return UserOrderResource::collection($this->orderService->userOrder($request, $deliveryBoy));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
