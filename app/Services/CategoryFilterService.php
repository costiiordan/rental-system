<?php

namespace App\Services;

use App\Models\AttributeValues;
use App\Models\Constants\AttributeReference;
use Illuminate\Http\Request;

class CategoryFilterService
{
    protected ?AttributeValues $category;

    public function __construct(Request $request)
    {
        $this->initCategory($request);
    }

    public function getCategory(): ?AttributeValues
    {
        return $this->category;
    }

    private function initCategory(Request $request): void
    {
        $categoryReference = $request->get('category');

        if (!$categoryReference) {
            $this->category = null;

            return;
        }

        $this->category = AttributeValues::query()
            ->whereHas('attribute', function ($query) {
                $query->where('reference', AttributeReference::CATEGORY);
            })
            ->where('reference', '=', $categoryReference)
            ->first();
    }
}
