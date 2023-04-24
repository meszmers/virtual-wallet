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
     * @param string $walletNumber
     * @return JsonResponse
     */
    public function show(string $walletNumber): JsonResponse
    {
        return response()->json($this->walletRepository->show(Auth::id(), $walletNumber));
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
     * @param string $walletNumber
     * @return JsonResponse
     */
    public function delete(string $walletNumber): JsonResponse
    {
        $this->walletRepository->delete(Auth::id(), $walletNumber);

        return response()->json(['message' => "Wallet with number: $walletNumber has been deleted"]);
    }

    /**
     * @param Request $request
     * @param string $walletNumber
     * @return JsonResponse
     */
    public function update(Request $request, string $walletNumber): JsonResponse
    {
        $fields = $request->validate([
            'cardName' => 'required|string',
        ]);

        return response()->json(
            $this->walletRepository
                ->update(Auth::id(), $walletNumber, $fields['cardName']) ?: ['message' => 'Cant update this wallet.']
        );
    }
}
