<?php

namespace App\Http\Controllers\Admin\Master;

use App\Enums\ConditionEnum;
use App\Helpers\PaginationHelper;
use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Models\EquipmentCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $equipments = Equipment::query()
            ->with('category')
            ->when($request->input('search'), function($query, $search) {
                return $query->where('name', 'ilike', "%{$search}%")
                    ->orWhereHas('category', function ($equipmentCategoryQuery) use ($search) {
                        $equipmentCategoryQuery->where('name', 'ilike', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        $transformEquipment = $equipments->map(function($equipment) {
            return new EquipmentResource($equipment);
        });

        return Inertia::render('Admin/Master/Equipment/Index', [
            'title' => 'Master Alat',
            'desc'  => 'Data Alat',
            'equipments'  => [
                'data'  => $transformEquipment,
                'links' => PaginationHelper::formatPaginationLinks($equipments),
                'current_page'  => $equipments->currentPage(),
                'per_page' => $equipments->perPage(),
                'total' => $equipments->total()
            ],
            'filters'   => $request->only(['search']) ?: ['search' => '']
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $conditionLevels = collect(ConditionEnum::cases())->map(function ($condition) {
            return [
                'label' => $condition->label(),
                'value' => $condition->value
            ];
        });

        $equipmentCategories = EquipmentCategory::all();

        return Inertia::render('Admin/Master/Equipment/Add', [
            'title' => 'Tambah Alat',
            'desc'  => 'Form Tambah Alat',
            'conditionLevels' => $conditionLevels,
            'equipmentCategories' => $equipmentCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquipmentRequest $request)
    {
        $equipment = Equipment::create($request->validated());

        return redirect()->route('admin.equipments.index')
            ->with('success', 'Alat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        $equipment->load('category');
        
        return Inertia::render('Admin/Master/Equipment/Show', [
            'title' => 'Detail Alat',
            'desc'  => 'Detail Alat',
            'equipment' => new EquipmentResource($equipment),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        $conditionLevels = collect(ConditionEnum::cases())->map(function ($condition) {
            return [
                'label' => $condition->label(),
                'value' => $condition->value
            ];
        });

        $equipmentCategories = EquipmentCategory::all();

        return Inertia::render('Admin/Master/Equipment/Edit', [
            'title' => 'Edit Alat',
            'desc'  => 'Form Edit Alat',
            'conditionLevels' => $conditionLevels,
            'equipment' => new EquipmentResource($equipment),
            'equipmentCategories' => $equipmentCategories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        $equipment->update($request->validated());

        return redirect()->route('admin.equipments.index')
            ->with('success', 'Alat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        $equipment->delete();

        return redirect()->route('admin.equipments.index')
            ->with('success', 'Alat berhasil dihapus');
    }
}
