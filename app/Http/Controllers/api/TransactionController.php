<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repositories\Transaction\EloquentTransactionRepository;
use App\Services\CurrenciesService;
use App\Services\TransactionsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private EloquentTransactionRepository $transactionRepository;
    private CurrenciesService $currenciesService;
    private TransactionsService $transactionsService;

    /**
     * @param EloquentTransactionRepository $transactionRepository
     * @param CurrenciesService $currenciesService
     * @param TransactionsService $transactionsService
     */
    public function __construct(EloquentTransactionRepository $transactionRepository, CurrenciesService $currenciesService, TransactionsService $transactionsService)
    {
        $this->transactionRepository = $transactionRepository;
        $this->currenciesService = $currenciesService;
        $this->transactionsService = $transactionsService;
    }

    public function index(string $walletNumber)
    {
        return response()->json($this->transactionRepository->index(Auth::id(), $walletNumber));
    }

    public function create(Request $request, string $walletNumber)
    {
        $fields = $request->validate([
            'amount' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'currency_code' => 'required|string',
            'to_wallet_number' => 'string'
        ]);

        $isCurrencyValid = $this->currenciesService->currencyIsValid($fields['currency_id'], $fields['currency_code']);

        if (!$isCurrencyValid) {
            return response()->json(['message' => 'Currency not supported'], 400);
        }

        $walletTo = !empty($fields['to_wallet_number']) ? $fields['to_wallet_number'] : null;

        $transactionValid = $this->transactionsService->isTransactionValid(
            Auth::id(),
            $walletNumber,
            $fields['amount'],
            $fields['currency_code'],
            $walletTo
        );

        if ($transactionValid) {
            $transaction = $this->transactionRepository->create(
                $walletNumber,
                $fields['amount'],
                $fields['currency_id'],
                $walletTo
            );
            return response()->json($transaction);
        }


        return response()->json(['message' => 'Transaction unsuccessful.']);
    }
}
