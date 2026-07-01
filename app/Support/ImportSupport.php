<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Str;

class ImportSupport
{
    /**
     * Inclusive list of Ymd day strings between $start and $end (Ymd format).
     */
    public static function dayRanges(string $start, string $end): array
    {
        $startDate = Carbon::createFromFormat('Ymd', $start)->startOfDay();
        $endDate = Carbon::createFromFormat('Ymd', $end)->startOfDay();

        if ($endDate->lt($startDate)) {
            return [];
        }

        $days = [];
        for ($d = $startDate->copy(); $d->lte($endDate); $d->addDay()) {
            $days[] = $d->format('Ymd');
        }

        return $days;
    }

    public const SORTIR_KEYS = ['AUFNR', 'MATNR', 'MBLNR', 'MJAHR'];

    public const SORTIR_COMPARE = [
        'WERKS', 'LGORT', 'BWART', 'MENGE', 'ERFMG', 'ERFME',
        'MAKTX', 'BUDAT', 'WRHZET', 'ARBPL', 'MVGR4', 'IDNRK',
    ];

    public static function sortirKey(object $item): string
    {
        return implode('|', [$item->AUFNR, $item->MATNR, $item->MBLNR, $item->MJAHR]);
    }

    public static function diffSortir(array $incoming, array $existingByKey): array
    {
        $insert = [];
        $update = [];
        $seen = [];
        $now = Carbon::now()->toDateTimeString();

        foreach ($incoming as $item) {
            $key = self::sortirKey($item);
            if (isset($seen[$key])) {
                continue; // duplicate incoming row, first wins
            }
            $seen[$key] = true;

            if (isset($existingByKey[$key])) {
                $existing = $existingByKey[$key];
                $changed = [];
                foreach (self::SORTIR_COMPARE as $field) {
                    if ((string) ($existing[$field] ?? '') !== (string) ($item->$field ?? '')) {
                        $changed[$field] = $item->$field;
                    }
                }
                if (! empty($changed)) {
                    $changed['updated_at'] = $now;
                    $update[] = ['id' => $existing['id'], 'data' => $changed];
                }
            } else {
                $insert[] = [
                    'AUFNR' => $item->AUFNR, 'MATNR' => $item->MATNR, 'WERKS' => $item->WERKS,
                    'LGORT' => $item->LGORT, 'BWART' => $item->BWART, 'MENGE' => $item->MENGE,
                    'ERFMG' => $item->ERFMG, 'ERFME' => $item->ERFME, 'MAKTX' => $item->MAKTX,
                    'MBLNR' => $item->MBLNR, 'MJAHR' => $item->MJAHR, 'BUDAT' => $item->BUDAT,
                    'WRHZET' => $item->WRHZET, 'ARBPL' => $item->ARBPL, 'MVGR4' => $item->MVGR4,
                    'IDNRK' => $item->IDNRK,
                    'created_at' => $now, 'updated_at' => $now,
                ];
            }
        }

        return ['insert' => $insert, 'update' => $update];
    }

    public static function kilnKeyParts(object $item): array
    {
        return [
            'order_id' => intval($item->AUFNR),
            'kode_material' => intval($item->MATNR),
            'mesin_id' => 'RK ' . Str::substr($item->VERID, -2),
        ];
    }

    public static function kilnKey(object $item): string
    {
        $p = self::kilnKeyParts($item);

        return $p['order_id'] . '|' . $p['kode_material'] . '|' . $p['mesin_id'];
    }

    public static function diffKiln(array $incoming, array $existingByKey): array
    {
        $now = Carbon::now()->toDateTimeString();
        $work = [];    // key => working row
        $origin = [];  // key => 'db' | 'new'

        foreach ($incoming as $item) {
            $key = self::kilnKey($item);
            $parts = self::kilnKeyParts($item);
            $menge = (float) $item->MENGE;
            $createdAt = Carbon::createFromFormat('Ymd', $item->BUDAT)->toDateTimeString();

            if (isset($work[$key])) {
                $work[$key]['jumlah'] = (float) $work[$key]['jumlah'] + $menge;
                $work[$key]['size'] = $item->BEZEI5;
                $work[$key]['jenis'] = $item->BEZEI1;
                $work[$key]['created_at'] = $createdAt;
            } elseif (isset($existingByKey[$key])) {
                $existing = $existingByKey[$key];
                $work[$key] = [
                    'id' => $existing['id'],
                    'order_id' => $parts['order_id'],
                    'kode_material' => $parts['kode_material'],
                    'mesin_id' => $parts['mesin_id'],
                    'size' => $item->BEZEI5,
                    'jenis' => $item->BEZEI1,
                    'jumlah' => (float) $existing['jumlah'] + $menge,
                    'created_at' => $createdAt,
                ];
                $origin[$key] = 'db';
            } else {
                $work[$key] = [
                    'order_id' => $parts['order_id'],
                    'kode_material' => $parts['kode_material'],
                    'mesin_id' => $parts['mesin_id'],
                    'size' => $item->BEZEI5,
                    'jenis' => $item->BEZEI1,
                    'jumlah' => $menge,
                    'created_at' => $createdAt,
                ];
                $origin[$key] = 'new';
            }
        }

        $insert = [];
        $update = [];

        foreach ($work as $key => $row) {
            if (($origin[$key] ?? 'new') === 'db') {
                $update[] = ['id' => $row['id'], 'data' => [
                    'size' => $row['size'],
                    'jenis' => $row['jenis'],
                    'jumlah' => $row['jumlah'],
                    'created_at' => $row['created_at'],
                    'updated_at' => $now,
                ]];
            } else {
                $insert[] = [
                    'shift_id' => 1,
                    'order_id' => $row['order_id'],
                    'user_id' => 10,
                    'kode_material' => $row['kode_material'],
                    'mesin_id' => $row['mesin_id'],
                    'lane' => '',
                    'size' => $row['size'],
                    'jenis' => $row['jenis'],
                    'from' => 'Car',
                    'no' => '3',
                    'outKiln' => '0',
                    'start' => '00:00',
                    'stop' => '00:00',
                    'menit' => '0 Menit',
                    'jumlah' => $row['jumlah'],
                    'created_at' => $row['created_at'],
                ];
            }
        }

        return ['insert' => $insert, 'update' => $update];
    }
}
