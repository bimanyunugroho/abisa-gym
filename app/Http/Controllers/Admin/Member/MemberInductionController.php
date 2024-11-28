<?php

namespace App\Http\Controllers\Admin\Member;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberInductionResource;
use App\Models\MemberInduction;
use App\Http\Requests\StoreMemberInductionRequest;
use App\Http\Requests\UpdateMemberInductionRequest;
use App\Models\EquipmentCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberInductionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $memberInductions = MemberInduction::query()
            ->with(['user', 'trainer', 'equipmentCategory'])
            ->when($request->input('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('trainer', function ($trainerQuery) use ($search) {
                        $trainerQuery->where('name', 'ilike', "%{$search}%");
                    })
                    ->orWhereHas('equipmentCategory', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'ilike', "%{$search}%");
                    })
                    ->orWhere('induction_date', 'ilike', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $transformMemberInductions = $memberInductions->map(function ($memberInduction) {
            return new MemberInductionResource($memberInduction);
        });

        return Inertia::render('Admin/Member/Induction/Index', [
            'title' => 'Induksi Anggota',
            'desc'  => 'Data Induksi Anggota',
            'memberInductions'  => [
                'data'  => $transformMemberInductions,
                'links' => PaginationHelper::formatPaginationLinks($memberInductions),
                'current_page'  => $memberInductions->currentPage(),
                'per_page' => $memberInductions->perPage(),
                'total' => $memberInductions->total()
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
        $trainers = User::where('role', 'TRAINER')->get();
        $equipmentCategories = EquipmentCategory::all();

        return Inertia::render('Admin/Member/Induction/Add', [
            'title' => 'Tambah Induksi Anggota',
            'desc'  => 'Form Tambah Induksi Anggota',
            'users' => $users,
            'trainers' => $trainers,
            'equipmentCategories' => $equipmentCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberInductionRequest $request)
    {
        $memberInduction = MemberInduction::create($request->validated());

        return redirect()->route('admin.member-inductions.index')->with('success', 'Induksi Anggota berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MemberInduction $memberInduction)
    {
        $memberInduction->load(['user', 'trainer', 'equipmentCategory']);

        return Inertia::render('Admin/Member/Induction/Show', [
            'title' => 'Detail Induksi Anggota',
            'desc'  => 'Detail Induksi Anggota',
            'memberInduction' => new MemberInductionResource($memberInduction)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MemberInduction $memberInduction)
    {
        $memberInduction->load(['user', 'trainer', 'equipmentCategory']);

        $users = User::where('role', 'MEMBER')->get();
        $trainers = User::where('role', 'TRAINER')->get();
        $equipmentCategories = EquipmentCategory::all();

        return Inertia::render('Admin/Member/Induction/Edit', [
            'title' => 'Edit Induksi Anggota',
            'desc'  => 'Form Edit Induksi Anggota',
            'users' => $users,
            'trainers' => $trainers,
            'equipmentCategories' => $equipmentCategories,
            'memberInduction' => new MemberInductionResource($memberInduction)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberInductionRequest $request, MemberInduction $memberInduction)
    {
        $memberInduction->update($request->validated());

        return redirect()->route('admin.member-inductions.index')->with('success', 'Induksi Anggota berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberInduction $memberInduction)
    {
        $memberInduction->delete();

        return redirect()->route('admin.member-inductions.index')->with('success', 'Induksi Anggota berhasil dihapus');
    }
}
