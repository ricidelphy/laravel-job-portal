<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProposalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'job_name'             => $this->job->job_name,
            'job_description'      => $this->job->job_description,
            'sallary'              => $this->job->sallary,
            'job_published'        => $this->job->published,
            'category'             => $this->job->category->category_name,
            'freelancer'           => $this->freelancer,
            'status'               => $this->status,
            'send'                 => Carbon::parse($this->created_at)->translatedFormat('d F Y'),

        ];
    }
}
