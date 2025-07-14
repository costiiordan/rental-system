<?php

use App\Models\Constants\AttributeReference;
use App\Models\Constants\CategoryReference;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $categoryAttributeId = \App\Models\Attribute::where('reference', AttributeReference::CATEGORY)->value('id');

        $this->updateReference($categoryAttributeId, str_replace('-', '_', CategoryReference::KIDS), CategoryReference::KIDS);
        $this->updateReference($categoryAttributeId, str_replace('-', '_', CategoryReference::ENDURO_KIDS), CategoryReference::ENDURO_KIDS);
        $this->updateReference($categoryAttributeId, str_replace('-', '_', CategoryReference::SUPER_ENDURO_BIKE_PARK), CategoryReference::SUPER_ENDURO_BIKE_PARK);
        $this->updateReference($categoryAttributeId, str_replace('-', '_', CategoryReference::DOWNHILL), CategoryReference::DOWNHILL);
        $this->updateReference($categoryAttributeId, str_replace('-', '_', CategoryReference::ELECTRIC_MOUNTAIN_BIKE), CategoryReference::ELECTRIC_MOUNTAIN_BIKE);
        $this->updateReference($categoryAttributeId, str_replace('-', '_', CategoryReference::ACCESORIES), CategoryReference::ACCESORIES);
        $this->updateReference($categoryAttributeId, str_replace('-', '_', CategoryReference::ELECTRIC_ENDURO), CategoryReference::ELECTRIC_ENDURO);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $categoryAttributeId = \App\Models\Attribute::where('reference', AttributeReference::CATEGORY)->value('id');

        $this->updateReference($categoryAttributeId, CategoryReference::KIDS, str_replace('-', '_', CategoryReference::KIDS));
        $this->updateReference($categoryAttributeId, CategoryReference::ENDURO_KIDS, str_replace('-', '_', CategoryReference::ENDURO_KIDS));
        $this->updateReference($categoryAttributeId, CategoryReference::SUPER_ENDURO_BIKE_PARK, str_replace('-', '_', CategoryReference::SUPER_ENDURO_BIKE_PARK));
        $this->updateReference($categoryAttributeId, CategoryReference::DOWNHILL, str_replace('-', '_', CategoryReference::DOWNHILL));
        $this->updateReference($categoryAttributeId, CategoryReference::ELECTRIC_MOUNTAIN_BIKE, str_replace('-', '_', CategoryReference::ELECTRIC_MOUNTAIN_BIKE));
        $this->updateReference($categoryAttributeId, CategoryReference::ACCESORIES, str_replace('-', '_', CategoryReference::ACCESORIES));
        $this->updateReference($categoryAttributeId, CategoryReference::ELECTRIC_ENDURO, str_replace('-', '_', CategoryReference::ELECTRIC_ENDURO));
    }

    private function updateReference(int $attributeId, string $oldReference, string $newReference): void
    {
        DB::table('attribute_values')
            ->where('attribute_id', $attributeId)
            ->where('reference', $oldReference)
            ->update(['reference' => $newReference]);
    }
};
