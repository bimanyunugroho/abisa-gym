<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentTypeEnum;
use App\Enums\StatusPaymentEnum;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\GymVisit;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payments = Payment::query()
            ->with(['user', 'payable'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'ilike', "%{$search}%");
                    })
                    ->orWhere('no_payment', 'ilike', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $transformPayment = $payments->map(function ($payment) {
            return new PaymentResource($payment);
        });

        return Inertia::render('Admin/Payment/Index', [
            'title' => 'Payment',
            'desc'  => 'Data Payment',
            'payments'  => [
                'data'  => $transformPayment,
                'links' => PaginationHelper::formatPaginationLinks($payments),
                'current_page'  => $payments->currentPage(),
                'per_page' => $payments->perPage(),
                'total' => $payments->total()
            ],
            'filters'   => $request->only(['search']) ?: ['search' => '']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'MEMBER')->get();
        $gymVisits = GymVisit::with('user')->get();

        $paymentMethods = collect(PaymentMethodEnum::cases())->map(function ($paymentMethod) {
            return [
                'label' => $paymentMethod->label(),
                'value' => $paymentMethod->value
            ];
        });

        $paymentTypes = collect(PaymentTypeEnum::cases())->map(function ($paymentType) {
            return [
                'label' => $paymentType->label(),
                'value' => $paymentType->value
            ];
        });

        $statuses = collect(StatusPaymentEnum::cases())->map(function ($status) {
            return [
                'label' => $status->label(),
                'value' => $status->value
            ];
        });
        
        return Inertia::render('Admin/Payment/Add', [
            'title' => 'Payment',
            'desc'  => 'Data Payment',
            'users' => $users,
            'gymVisits' => $gymVisits,
            'paymentMethods' => $paymentMethods,
            'paymentTypes' => $paymentTypes,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request)
    {
        $payment = Payment::create($request->validated());
        return redirect()->route('admin.payments.index')->with('success', 'Payment created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load(['user', 'payable']);
        
        return Inertia::render('Admin/Payment/Show', [
            'title' => 'Payment',
            'desc'  => 'Data Payment',
            'payment' => new PaymentResource($payment)
        ]);
    }
}
