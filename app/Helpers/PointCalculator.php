<?php

namespace App\Helpers;

use App\Models\PointRule;

class PointCalculator
{
    public static function calculate(string $level, string $result): int
    {
        try {
            $rule = PointRule::where('level', $level)
                ->where('result', $result)
                ->where('is_active', true)
                ->first();

            if ($rule) {
                return (int) $rule->points;
            }
        } catch (\Throwable $e) {
            // fallback to matrix
        }

        $matrix = [
            'Internasional' => ['Juara 1' => 100, 'Juara 2' => 85, 'Juara 3' => 70, 'Peserta/Finalis' => 30],
            'Nasional'      => ['Juara 1' => 80,  'Juara 2' => 65, 'Juara 3' => 50, 'Peserta/Finalis' => 20],
            'Provinsi'      => ['Juara 1' => 60,  'Juara 2' => 45, 'Juara 3' => 35, 'Peserta/Finalis' => 15],
            'Kabupaten/Kota'=> ['Juara 1' => 40,  'Juara 2' => 30, 'Juara 3' => 20, 'Peserta/Finalis' => 10],
            'Sekolah'       => ['Juara 1' => 20,  'Juara 2' => 15, 'Juara 3' => 10, 'Peserta/Finalis' => 5],
        ];

        return $matrix[$level][$result] ?? 10;
    }
}
