<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $dateOfBirth = $this->card->family_header_id ? $this->card->family->dateOfBirth : $this->card->member->dateOfBirth;
        $dob = new \DateTime($dateOfBirth);
        $ageInterval = now()->diff($dob);
        $age = $ageInterval->y;

        return [
            'id' => $this->id,
            'first_name' => $this->card->family_header_id ? $this->card->family->first_name : $this->card->member->first_name,
            'last_name' => $this->card->family_header_id ? $this->card->family->last_name : $this->card->member->last_name,
            'gender' => $this->card->family_header_id ? $this->card->family->gender : $this->card->member->gender,
            'age' => $age,
            'signs' => json_decode($this->signs),
            'patient_data' => json_decode($this->patient_data),
            'date' => $this->created_at->format('d M, Y'),
            'price' => number_format($this->price),
        ];
    }
}
