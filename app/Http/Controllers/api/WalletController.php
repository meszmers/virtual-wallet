<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repositories\Wallet\EloquentWalletRepository;
use App\Services\TransactionsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{

    private EloquentWalletRepository $walletRepository;
    private TransactionsService $transactionsService;

    /**
     * @param EloquentWalletRepository $walletRepository
     * @param TransactionsService $transactionsService
     */
    public function __construct(EloquentWalletRepository $walletRepository, TransactionsService $transactionsService)
    {
        $this->walletRepository = $walletRepository;
        $this->transactionsService = $transactionsService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = $this->walletRepository->index(Auth::id());

        foreach ($data as &$wallet) {
            $wallet['balance'] = $this->transactionsService->getWalletTotalBalanceOfEachCurrency($wallet['wallet_number']);
        }

        return response()->json($data);
    }

    /**
     * @param string $walletNumber
     * @return JsonResponse
     */
    public function show(string $walletNumber): JsonResponse
    {
        $wallet = $this->walletRepository->show(Auth::id(), $walletNumber);
        $wallet['balance'] = $this->transactionsService->getWalletTotalBalanceOfEachCurrency($walletNumber);

        return response()->json($wallet);
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
