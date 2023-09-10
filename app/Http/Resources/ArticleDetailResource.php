<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Jenssegers\Date\Date;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;

class ArticleDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "slug" => $this->slug,
            "title" => $this->title,
            "description" => $this->description,
            "image" => url("storage/$this->image"),
            "publish_date" => Carbon::parse($this->publish)->isoFormat('DD-MMMM-Y'),
        ];
    }
}
