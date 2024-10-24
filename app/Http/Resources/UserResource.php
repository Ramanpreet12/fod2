<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role,
            'address' => $this->address,
            // Custom formatted attributes
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'is_verified' => $this->email_verified_at !== null,
            // Conditional attributes
            'vehicle_details' => $this->when($this->role === 'delivery_boy', [
                'vehicle_type' => $this->vehicle_type,
                'vehicle_number' => $this->vehicle_number,
                'license_number' => $this->license_number,
            ]),
            // // You can also include relationships
            // 'orders_count' => $this->when($this->role === 'customer', 
            //     $this->orders()->count()
            // ),

              // Static value for customer role
    'total_orders' => $this->when($this->role === 'customer', 0),  // or any static number like 5
    // OR you could add status instead
    'status' => $this->when($this->role === 'customer', 'active'),
        ];
    }

    public function with(Request $request): array
    {
        return [
            'status' => 'success',
            'version' => '1.0',
        ];
    }
}
