<?php

namespace App\Http\Controllers\Admin\Master;

use App\Enums\DifficultyEnum;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentCategoryResource;
use App\Models\EquipmentCategory;
use App\Http\Requests\StoreEquipmentCategoryRequest;
use App\Http\Requests\UpdateEquipmentCategoryRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EquipmentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $equipmentCategories = EquipmentCategory::query()
            ->when($request->input('search'), function($query, $search) {
                return $query->where('name', 'ilike', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $transformEquipmentCategories = $equipmentCategories->map(function($equipmentCategory) {
            return new EquipmentCategoryResource($equipmentCategory);
        });
            
        return Inertia::render('Admin/Master/EquipmentCategory/Index', [
            'title' => 'Master Kategori Alat',
            'desc'  => 'Data Kategori Alat',
            'equipmentCategories'  => [
                'data'  => $transformEquipmentCategories,
                'links' => PaginationHelper::formatPaginationLinks($equipmentCategories),
                'current_page'  => $equipmentCategories->currentPage(),
                'per_page' => $equipmentCategories->perPage(),
                'total' => $equipmentCategories->total()
            ],
            'filters'   => $request->only(['search']) ?: ['search' => '']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $difficultyLevels = collect(DifficultyEnum::cases())->map(function ($difficulty) {
            return [
                'label' => $difficulty->label(),
                'value' => $difficulty->value
            ];
        });

        return Inertia::render('Admin/Master/EquipmentCategory/Add', [
            'title' => 'Tambah Kategori Alat',
            'desc'  => 'Form Tambah Kategori Alat',
            'difficultyLevels' => $difficultyLevels
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentCategoryRequest $request)
    {
        $equipmentCategory = EquipmentCategory::create($request->validated());

        return redirect()->route('admin.equipment-categories.index')
            ->with('success', 'Kategori alat berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EquipmentCategory $equipmentCategory)
    {
        $difficultyLevels = collect(DifficultyEnum::cases())->map(function ($difficulty) {
            return [
                'label' => $difficulty->label(),
                'value' => $difficulty->value
            ];
        });

        return Inertia::render('Admin/Master/EquipmentCategory/Edit', [
            'title' => 'Edit Kategori Alat',
            'desc'  => 'Form Edit Kategori Alat',
            'difficultyLevels' => $difficultyLevels,
            'equipmentCategory' => new EquipmentCategoryResource($equipmentCategory)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentCategoryRequest $request, EquipmentCategory $equipmentCategory)
    {
        $equipmentCategory->update($request->validated());

        return redirect()->route('admin.equipment-categories.index')
            ->with('success', 'Kategori alat berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipmentCategory $equipmentCategory)
    {
        $equipmentCategory->delete();

        return redirect()->route('admin.equipment-categories.index')
            ->with('success', 'Kategori alat berhasil dihapus');
    }
}
