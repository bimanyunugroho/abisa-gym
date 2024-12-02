<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberInductionResource extends JsonResource
{
    /**
     * Initialize the resource instance.
     *
     * @return void
     */
    public function __construct($resource)
    {
        parent::__construct($resource);
        static::withoutWrapping();
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => new UserResource($this->user),
            'trainer' => new UserResource($this->trainer),
            'equipment_category' => new EquipmentCategoryResource($this->equipmentCategory),
            'user_id' => $this->user_id,
            'trainer_id' => $this->trainer_id,
            'equipment_category_id' => $this->equipment_category_id,
            'induction_date' => Carbon::parse($this->induction_date)->format('Y-m-d'),
            'slug' => $this->slug,
            'notes' => $this->notes,
            'is_completed' => $this->is_completed,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
