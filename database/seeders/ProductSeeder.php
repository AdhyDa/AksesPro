<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Schema::enableForeignKeyConstraints();

        // Load unified researched prices and products from harga_resmi.csv
        $researchPath = base_path('harga_resmi.csv');
        if (! file_exists($researchPath)) {
            $this->command->error("CSV file not found at: {$researchPath}");

            return;
        }

        if (($handle = fopen($researchPath, 'r')) !== false) {
            $lineCount = 0;
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $lineCount++;
                // Skip the first 4 lines (title, subtitle, blank, column header)
                if ($lineCount <= 4) {
                    continue;
                }

                // Skip empty or malformed rows
                if (empty($row) || ! isset($row[0]) || trim($row[0]) === '') {
                    continue;
                }

                $name = trim($row[0]);

                // Get AksesPro price from Column Index 1
                if (! isset($row[1]) || trim($row[1]) === '') {
                    continue;
                }
                $aksesproPrice = $this->cleanPrice($row[1]);
                if ($aksesproPrice <= 0) {
                    continue;
                }

                // Get official researched price from Column Index 3
                $officialPriceStr = $row[3] ?? '';
                $originalPrice = $this->parseOfficialPrice($officialPriceStr, $aksesproPrice);

                $category = $this->estimateCategory($name);
                $durationDays = $this->parseDurationDays($name);

                Product::create([
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'category' => $category,
                    'original_price' => $originalPrice,
                    'aksespro_price' => $aksesproPrice,
                    'duration_days' => $durationDays,
                    'stock' => 20,
                    'max_stock' => 20,
                    'is_active' => true,
                    'description' => "Akses premium {$name}. Bergaransi penuh dan legal 100% dari AksesPro.",
                ]);
            }
            fclose($handle);
        }
    }

    /**
     * Clean and parse regular price strings.
     */
    private function cleanPrice(string $priceStr): int
    {
        if (preg_match('/Rp\s*([\d\.,]+)/i', $priceStr, $matches)) {
            return (int) str_replace(['.', ','], '', $matches[1]);
        }

        return (int) preg_replace('/[^0-9]/', '', $priceStr);
    }

    /**
     * Parse official price string into integer with fallback.
     */
    private function parseOfficialPrice(string $priceStr, int $aksesproPrice): int
    {
        $priceStr = trim($priceStr);
        if ($priceStr === '' || str_contains(strtolower($priceStr), 'tidak tersedia')) {
            // Default fallback is 4 * aksespro_price
            return $aksesproPrice * 4;
        }

        // Match the first numeric sequence after "Rp"
        if (preg_match('/Rp\s*([\d\.,]+)/i', $priceStr, $matches)) {
            $cleanNum = str_replace(['.', ','], '', $matches[1]);

            return (int) $cleanNum;
        }

        // Default fallback if matching fails
        return $aksesproPrice * 4;
    }

    /**
     * Estimate category based on product name.
     */
    private function estimateCategory(string $productName): string
    {
        $upperName = strtoupper($productName);

        if (str_contains($upperName, 'CANVA') || str_contains($upperName, 'CAPCUT') || str_contains($upperName, 'PICSART') || str_contains($upperName, 'REMINI')) {
            return 'Desain';
        }

        if (str_contains($upperName, 'APPLE MUSIC') || str_contains($upperName, 'SPOTIFY')) {
            return 'Musik';
        }

        if (str_contains($upperName, 'CHATGPT') || str_contains($upperName, 'ZOOM') || str_contains($upperName, 'NOTION') || str_contains($upperName, 'OFFICE')) {
            return 'Produktivitas';
        }

        return 'Streaming';
    }

    /**
     * Parse duration in days.
     */
    private function parseDurationDays(string $productName): int
    {
        $upperName = strtoupper($productName);

        if (str_contains($upperName, 'LIFETIME')) {
            return 9999;
        }

        // Check for 'hari' / 'days'
        if (preg_match('/(\d+)\s*(?:HARI|DAY|DAYS)/', $upperName, $matches)) {
            return (int) $matches[1];
        }

        // Check for 'bln' / 'bulan' / 'month'
        if (preg_match('/(\d+)\s*(?:BLN|BULAN|MONTH|MONTHS)/', $upperName, $matches)) {
            return (int) $matches[1] * 30;
        }

        // Check for 'thn' / 'tahun' / 'yr' / 'year'
        if (preg_match('/(\d+)\s*(?:THN|TAHUN|YR|YEAR|YEARS)/', $upperName, $matches)) {
            return (int) $matches[1] * 365;
        }

        return 30; // Default fallback to 30 days
    }
}
