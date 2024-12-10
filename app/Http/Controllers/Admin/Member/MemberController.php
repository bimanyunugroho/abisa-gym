<?php

namespace App\Http\Controllers\Admin\Member;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allowedRoles = collect(RoleEnum::forMemberForm())
            ->pluck('value')
            ->toArray();

        $members = User::query()
            ->whereIn('role', $allowedRoles)
            ->when($request->input('search'), function ($query, $search) {
                $query->where('name', 'ilike', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $transformMembers = $members->map(function ($member) {
            return new MemberResource($member);
        });

        return Inertia::render('Admin/Member/Member/Index', [
            'title' => 'Induksi Anggota',
            'desc'  => 'Data Induksi Anggota',
            'members'  => [
                'data'  => $transformMembers,
                'links' => PaginationHelper::formatPaginationLinks($members),
                'current_page'  => $members->currentPage(),
                'per_page' => $members->perPage(),
                'total' => $members->total()
            ],
            'filters'   => $request->only(['search']) ?: ['search' => '']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = RoleEnum::forMemberForm();

        $genders = collect(GenderEnum::cases())->map(function ($gender) {
            return [
                'label' => $gender->label(),
                'value' => $gender->value
            ];
        });

        return Inertia::render('Admin/Member/Member/Add', [
            'title' => 'Tambah Anggota',
            'desc'  => 'Form Tambah Anggota',
            'roles' => $roles,
            'genders' => $genders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberRequest $request)
    {
        $member = User::create($request->validated());

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $member)
    {
        return Inertia::render('Admin/Member/Member/Show', [
            'title' => 'Detail Anggota',
            'desc'  => 'Detail Anggota',
            'member' => new MemberResource($member)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $member)
    {
        $roles = RoleEnum::forMemberForm();

        $genders = collect(GenderEnum::cases())->map(function ($gender) {
            return [
                'label' => $gender->label(),
                'value' => $gender->value
            ];
        });

        return Inertia::render('Admin/Member/Member/Edit', [
            'title' => 'Edit Anggota',
            'desc'  => 'Form Edit Anggota',
            'roles' => $roles,
            'genders' => $genders,
            'member' => new MemberResource($member)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, User $member)
    {
        $member->update($request->validated());

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $member)
    {
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus');
    }
}
