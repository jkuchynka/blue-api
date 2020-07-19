<?php

namespace App\Filtersets\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FiltersetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'group' => $this->group,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'filters' => $this->whenLoaded('filters', function () {
                return $this->filters->map(function ($filter) {
                    return [
                        'id' => $filter->id,
                        'field' => $filter->field,
                        'operator' => $filter->operator,
                        'value' => $filter->value,
                        'created_at' => $filter->created_at,
                        'updated_at' => $filter->updated_at
                    ];
                });
            })
        ];
    }
}
