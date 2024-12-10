<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
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
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'usage_instructions' => $this->usage_instructions,
            'brand' => $this->brand,
            'model' => $this->model,
            'purchase_date' => Carbon::parse($this->purchase_date)->format('Y-m-d'),
            'last_maintenance_date' => Carbon::parse($this->last_maintenance_date)->format('Y-m-d'),
            'condition' => $this->condition,
            'is_active' => $this->is_active,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'category' => new EquipmentCategoryResource($this->whenLoaded('category'))
        ];
    }
}
