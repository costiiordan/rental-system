<?php

use App\Models\Item;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $taken = Item::whereNotNull('sku')->pluck('sku')->all();
        $taken = array_combine($taken, $taken);

        Item::whereNull('sku')->get()->each(function (Item $item) use (&$taken) {
            $base = Str::slug($item->getTranslation('name', 'ro')) ?: 'item-'.$item->id;

            $candidate = $base;
            $suffix = 2;
            while (isset($taken[$candidate])) {
                $candidate = $base.'-'.$suffix++;
            }

            $item->sku = $candidate;
            $item->save();

            $taken[$candidate] = $candidate;
        });

        DB::statement('ALTER TABLE items ALTER COLUMN sku SET NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE items ALTER COLUMN sku DROP NOT NULL');
    }
};
