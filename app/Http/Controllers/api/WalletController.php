<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repositories\Wallet\EloquentWalletRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{

    private EloquentWalletRepository $walletRepository;

    public function __construct(EloquentWalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->walletRepository->index(Auth::id()));
    }

    /**
     * @param int $walletId
     * @return JsonResponse
     */
    public function show(int $walletId): JsonResponse
    {
        return response()->json($this->walletRepository->show(Auth::id(), $walletId));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'cardName' => 'required|string',
        ]);

        return response()->json($this->walletRepository->create(Auth::id(), $fields['cardName']));
    }

    /**
     * @param int $walletId
     * @return JsonResponse
     */
    public function delete(int $walletId): JsonResponse
    {
        $this->walletRepository->delete(Auth::id(), $walletId);

        return response()->json(['message' => "Wallet with id: $walletId has been deleted"]);
    }

    /**
     * @param Request $request
     * @param int $walletId
     * @return JsonResponse
     */
    public function update(Request $request, int $walletId): JsonResponse
    {
        $fields = $request->validate([
            'cardName' => 'required|string',
        ]);

        return response()->json(
            $this->walletRepository
                ->update(Auth::id(), $walletId, $fields['cardName']) ?: ['message' => 'Cant update this wallet.']
        );
    }
}
