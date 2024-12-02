<?php

namespace App\Http\Controllers\Admin\Member;

use App\Enums\StatusMemberEnum;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberRegistrationResource;
use App\Models\MemberRegistration;
use App\Http\Requests\StoreMemberRegistrationRequest;
use App\Http\Requests\UpdateMemberRegistrationRequest;
use App\Models\MembershipPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $memberRegistrations = MemberRegistration::query()
            ->with(['user', 'membershipPlan'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('membershipPlan', function ($membershipPlanQuery) use ($search) {
                        $membershipPlanQuery->where('name', 'ilike', "%{$search}%");
                    });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $transformMemberRegistrations = $memberRegistrations->map(function ($memberRegistration) {
            return new MemberRegistrationResource($memberRegistration);
        });

        return Inertia::render('Admin/Member/Registration/Index', [
            'title' => 'Master Registrasi Anggota',
            'desc'  => 'Data Master Registrasi Anggota',
            'memberRegistrations'  => [
                'data'  => $transformMemberRegistrations,
                'links' => PaginationHelper::formatPaginationLinks($memberRegistrations),
                'current_page'  => $memberRegistrations->currentPage(),
                'per_page' => $memberRegistrations->perPage(),
                'total' => $memberRegistrations->total()
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
        $membershipPlans = MembershipPlan::all();

        $statuses = collect(StatusMemberEnum::cases())->map(function ($status) {
            return [
                'label' => $status->label(),
                'value' => $status->value
            ];
        });

        return Inertia::render('Admin/Member/Registration/Add', [
            'title' => 'Tambah Registrasi Anggota',
            'desc'  => 'Form Tambah Registrasi Anggota',
            'users' => $users,
            'membershipPlans' => $membershipPlans,
            'statuses' => $statuses
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRegistrationRequest $request)
    {
        $memberRegistration = MemberRegistration::create($request->validated());

        return redirect()->route('admin.member-registrations.index')->with('success', 'Registrasi Anggota berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MemberRegistration $memberRegistration)
    {
        $memberRegistration->load(['user', 'membershipPlan']);


        return Inertia::render('Admin/Member/Registration/Show', [
            'title' => 'Detail Registrasi Anggota',
            'desc'  => 'Detail Registrasi Anggota',
            'memberRegistration' => new MemberRegistrationResource($memberRegistration),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MemberRegistration $memberRegistration)
    {
        $users = User::where('role', 'MEMBER')->get();
        $membershipPlans = MembershipPlan::all();
        $memberRegistration->load(['user', 'membershipPlan']);

        $statuses = collect(StatusMemberEnum::cases())->map(function ($status) {
            return [
                'label' => $status->label(),
                'value' => $status->value
            ];
        });

        return Inertia::render('Admin/Member/Registration/Edit', [
            'title' => 'Edit Registrasi Anggota',
            'desc'  => 'Form Edit Registrasi Anggota',
            'memberRegistration' => new MemberRegistrationResource($memberRegistration),
            'users' => $users,
            'membershipPlans' => $membershipPlans,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRegistrationRequest $request, MemberRegistration $memberRegistration)
    {
        $memberRegistration->update($request->validated());

        return redirect()->route('admin.member-registrations.index')->with('success', 'Registrasi Anggota berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberRegistration $memberRegistration)
    {
        $memberRegistration->delete();

        return redirect()->route('admin.member-registrations.index')->with('success', 'Registrasi Anggota berhasil dihapus');
    }
}
