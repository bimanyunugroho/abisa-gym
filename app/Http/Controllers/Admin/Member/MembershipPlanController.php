<?php

namespace App\Http\Controllers\Admin\Member;

use App\Enums\DurationTypeEnum;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\MembershipPlanResource;
use App\Models\MembershipPlan;
use App\Http\Requests\StoreMembershipPlanRequest;
use App\Http\Requests\UpdateMembershipPlanRequest;
use App\Models\MemberLevel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MembershipPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $membershipPlans = MembershipPlan::query()
            ->with('memberLevel')
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('memberLevel', function ($memberLevelQuery) use ($search) {
                        $memberLevelQuery->where('name', 'ilike', "%{$search}%");
                    })
                    ->orWhere('name', 'ilike', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $transformMembershipPlans = $membershipPlans->map(function ($membershipPlan) {
            return new MembershipPlanResource($membershipPlan);
        });

        return Inertia::render('Admin/Member/Plan/Index', [
            'title' => 'Master Plan Anggota',
            'desc'  => 'Data Master Plan Anggota',
            'membershipPlans'  => [
                'data'  => $transformMembershipPlans,
                'links' => PaginationHelper::formatPaginationLinks($membershipPlans),
                'current_page'  => $membershipPlans->currentPage(),
                'per_page' => $membershipPlans->perPage(),
                'total' => $membershipPlans->total()
            ],
            'filters'   => $request->only(['search']) ?: ['search' => '']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $memberLevels = MemberLevel::all();

        $durationTypes = collect(DurationTypeEnum::cases())->map(function ($durationType) {
            return [
                'label' => $durationType->label(),
                'value' => $durationType->value
            ];
        });

        return Inertia::render('Admin/Member/Plan/Add', [
            'title' => 'Tambah Plan Anggota',
            'desc'  => 'Form Tambah Plan Anggota',
            'memberLevels' => $memberLevels,
            'durationTypes' => $durationTypes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMembershipPlanRequest $request)
    {
        $membershipPlan = MembershipPlan::create($request->validated());

        return redirect()->route('admin.membership-plans.index')->with('success', 'Plan Anggota berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MembershipPlan $membershipPlan)
    {
        $membershipPlan->load('memberLevel');

        return Inertia::render('Admin/Member/Plan/Show', [
            'title' => 'Detail Plan Anggota',
            'desc'  => 'Detail Plan Anggota',
            'membershipPlan' => new MembershipPlanResource($membershipPlan)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MembershipPlan $membershipPlan)
    {
        $memberLevels = MemberLevel::all();

        $durationTypes = collect(DurationTypeEnum::cases())->map(function ($durationType) {
            return [
                'label' => $durationType->label(),
                'value' => $durationType->value
            ];
        });

        $membershipPlan->load('memberLevel');

        return Inertia::render('Admin/Member/Plan/Edit', [
            'title' => 'Edit Plan Anggota',
            'desc'  => 'Form Edit Plan Anggota',
            'memberLevels' => $memberLevels,
            'durationTypes' => $durationTypes,
            'membershipPlan' => new MembershipPlanResource($membershipPlan)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMembershipPlanRequest $request, MembershipPlan $membershipPlan)
    {
        $membershipPlan->update($request->validated());

        return redirect()->route('admin.membership-plans.index')->with('success', 'Plan Anggota berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MembershipPlan $membershipPlan)
    {
        $membershipPlan->delete();

        return redirect()->route('admin.membership-plans.index')->with('success', 'Plan Anggota berhasil dihapus');
    }
}
