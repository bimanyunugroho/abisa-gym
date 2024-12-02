<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipPlanResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'member_level_id' => $this->member_level_id,
            'description' => $this->description,
            'price' => $this->price,
            'duration_days' => $this->duration_days,
            'duration_type' => $this->duration_type,
            'visit_limit' => $this->visit_limit,
            'access_all_branches' => $this->access_all_branches,
            'available_times' => $this->available_times,
            'is_active' => $this->is_active,
            'member_level' => new MemberLevelResource($this->whenLoaded('memberLevel')),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
        ];
    }
}
