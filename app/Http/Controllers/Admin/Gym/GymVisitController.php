<?php

namespace App\Http\Controllers\Admin\Gym;

use App\Enums\RoleEnum;
use App\Enums\VisitTypeEnum;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\GymVisitResource;
use App\Models\GymVisit;
use App\Http\Requests\StoreGymVisitRequest;
use App\Http\Requests\UpdateGymVisitRequest;
use App\Models\MemberRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GymVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $gymVisits = GymVisit::query()
            ->with(['user', 'guestOf', 'memberRegistration'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('memberRegistration', function ($memberRegistrationQuery) use ($search) {
                        $memberRegistrationQuery->where('name', 'ilike', "%{$search}%");
                    })
                    ->orWhere('guestOf', function ($guestOfQuery) use ($search) {
                        $guestOfQuery->where('name', 'ilike', "%{$search}%");
                    });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $transformGymVisits = $gymVisits->map(function ($gymVisit) {
            return new GymVisitResource($gymVisit);
        });

        return Inertia::render('Admin/Gym/Visit/Index', [
            'title' => 'Kunjungan Gym',
            'desc'  => 'Data Kunjungan Gym',
            'gymVisits'  => [
                'data'  => $transformGymVisits,
                'links' => PaginationHelper::formatPaginationLinks($gymVisits),
                'current_page'  => $gymVisits->currentPage(),
                'per_page' => $gymVisits->perPage(),
                'total' => $gymVisits->total()
            ],
            'filters'   => $request->only(['search']) ?: ['search' => '']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $memberRegistrations = MemberRegistration::query()->with(['user', 'membershipPlan', 'membershipPlan.memberLevel'])->get();
        $users = User::where('role', RoleEnum::MEMBER)->get();
        $guests = User::where('role', RoleEnum::MEMBER)->get();

        $visitTypes = collect(VisitTypeEnum::cases())->map(function ($visitType) {
            return [
                'label' => $visitType->label(),
                'value' => $visitType->value
            ];
        });

        return Inertia::render('Admin/Gym/Visit/Add', [
            'title' => 'Tambah Kunjungan Gym',
            'desc'  => 'Tambah Kunjungan Gym',
            'users' => $users,
            'memberRegistrations' => $memberRegistrations,
            'visitTypes' => $visitTypes,
            'guests' => $guests
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGymVisitRequest $request)
    {
        $gymVisit = GymVisit::create($request->validated());

        return redirect()->route('admin.gym-visits.index')->with('success', 'Gym visit created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(GymVisit $gymVisit)
    {
        $gymVisit->load(['user', 'guestOf', 'memberRegistration']);
        return Inertia::render('Admin/Gym/Visit/Show', [
            'title' => 'Detail Kunjungan Gym',
            'desc'  => 'Detail Kunjungan Gym',
            'gymVisit' => new GymVisitResource($gymVisit)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GymVisit $gymVisit)
    {
        $memberRegistrations = MemberRegistration::query()->with(['user', 'membershipPlan', 'membershipPlan.memberLevel'])->get();
        $gymVisit->load(['user', 'guestOf', 'memberRegistration']);
        $users = User::where('role', RoleEnum::MEMBER)->get();
        $guests = User::where('role', RoleEnum::MEMBER)->get();

        $visitTypes = collect(VisitTypeEnum::cases())->map(function ($visitType) {
            return [
                'label' => $visitType->label(),
                'value' => $visitType->value
            ];
        });

        return Inertia::render('Admin/Gym/Visit/Edit', [
            'title' => 'Edit Kunjungan Gym',
            'desc'  => 'Edit Kunjungan Gym',
            'users' => $users,
            'memberRegistrations' => $memberRegistrations,
            'guests' => $guests,
            'visitTypes' => $visitTypes,
            'gymVisit' => new GymVisitResource($gymVisit)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGymVisitRequest $request, GymVisit $gymVisit)
    {
        $gymVisit->update($request->validated());

        return redirect()->route('admin.gym-visits.index')->with('success', 'Gym visit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GymVisit $gymVisit)
    {
        $gymVisit->delete();

        return redirect()->route('admin.gym-visits.index')->with('success', 'Gym visit deleted successfully');
    }
}
