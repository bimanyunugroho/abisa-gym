<?php

namespace App\Http\Controllers\Admin\Member;

use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\MemberLevelResource;
use App\Models\MemberLevel;
use App\Http\Requests\StoreMemberLevelRequest;
use App\Http\Requests\UpdateMemberLevelRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $memberLevels = MemberLevel::query()
            ->when($request->input('search'), function($query, $search) {
                return $query->where('name', 'ilike', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $transformMemberLevels = $memberLevels->map(function ($memberLevel) {
            return new MemberLevelResource($memberLevel);
        });

        return Inertia::render('Admin/Member/Level/Index', [
            'title' => 'Master Level Anggota',
            'desc'  => 'Data Master Level Anggota',
            'memberLevels'  => [
                'data'  => $transformMemberLevels,
                'links' => PaginationHelper::formatPaginationLinks($memberLevels),
                'current_page'  => $memberLevels->currentPage(),
                'per_page' => $memberLevels->perPage(),
                'total' => $memberLevels->total()
            ],
            'filters'   => $request->only(['search']) ?: ['search' => '']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Member/Level/Add', [
            'title' => 'Tambah Level Anggota',
            'desc'  => 'Form Tambah Level Anggota'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMemberLevelRequest $request)
    {
        $memberLevel = MemberLevel::create($request->validated());

        return redirect()->route('admin.member-levels.index')
            ->with('success', 'Level angota berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(MemberLevel $memberLevel)
    {
        return Inertia::render('Admin/Member/Level/Show', [
            'title' => 'Detail Level Anggota',
            'desc'  => 'Detail Level Anggota',
            'memberLevel' => new MemberLevelResource($memberLevel)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MemberLevel $memberLevel)
    {
        return Inertia::render('Admin/Member/Level/Edit', [
            'title' => 'Edit Level Anggota',
            'desc'  => 'Form Edit Level Anggota',
            'memberLevel' => new MemberLevelResource($memberLevel)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberLevelRequest $request, MemberLevel $memberLevel)
    {
        $memberLevel->update($request->validated());

        return redirect()->route('admin.member-levels.index')
            ->with('success', 'Level angota berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberLevel $memberLevel)
    {
        $memberLevel->delete();

        return redirect()->route('admin.member-levels.index')
            ->with('success', 'Level angota berhasil dihapus');
    }
}
