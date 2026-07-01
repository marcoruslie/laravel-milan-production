<?php

namespace Tests\Unit;

use App\Support\ImportSupport;
use PHPUnit\Framework\TestCase;

class ImportSupportTest extends TestCase
{
    public function test_day_ranges_lists_each_day_inclusive()
    {
        $this->assertSame(
            ['20260701', '20260702', '20260703'],
            ImportSupport::dayRanges('20260701', '20260703')
        );
    }

    public function test_day_ranges_single_day()
    {
        $this->assertSame(['20260701'], ImportSupport::dayRanges('20260701', '20260701'));
    }

    public function test_day_ranges_returns_empty_when_end_before_start()
    {
        $this->assertSame([], ImportSupport::dayRanges('20260703', '20260701'));
    }

    private function sortirItem(array $overrides = []): object
    {
        return (object) array_merge([
            'AUFNR' => '1', 'MATNR' => '2', 'MBLNR' => '3', 'MJAHR' => '2026',
            'WERKS' => 'W', 'LGORT' => 'L', 'BWART' => 'B', 'MENGE' => '10',
            'ERFMG' => '1', 'ERFME' => 'BOX', 'MAKTX' => 'TILE', 'BUDAT' => '20260701',
            'WRHZET' => 'Z', 'ARBPL' => 'A', 'MVGR4' => 'Q01', 'IDNRK' => '99',
        ], $overrides);
    }

    public function test_diff_sortir_inserts_new_row()
    {
        $diff = ImportSupport::diffSortir([$this->sortirItem()], []);

        $this->assertCount(1, $diff['insert']);
        $this->assertCount(0, $diff['update']);
        $this->assertSame('10', $diff['insert'][0]['MENGE']);
        $this->assertArrayHasKey('created_at', $diff['insert'][0]);
    }

    public function test_diff_sortir_no_change_when_identical()
    {
        $existing = ['id' => 5, 'AUFNR' => '1', 'MATNR' => '2', 'MBLNR' => '3', 'MJAHR' => '2026',
            'WERKS' => 'W', 'LGORT' => 'L', 'BWART' => 'B', 'MENGE' => '10', 'ERFMG' => '1',
            'ERFME' => 'BOX', 'MAKTX' => 'TILE', 'BUDAT' => '20260701', 'WRHZET' => 'Z',
            'ARBPL' => 'A', 'MVGR4' => 'Q01', 'IDNRK' => '99'];
        $diff = ImportSupport::diffSortir([$this->sortirItem()], ['1|2|3|2026' => $existing]);

        $this->assertCount(0, $diff['insert']);
        $this->assertCount(0, $diff['update']);
    }

    public function test_diff_sortir_updates_changed_fields()
    {
        $existing = ['id' => 5, 'AUFNR' => '1', 'MATNR' => '2', 'MBLNR' => '3', 'MJAHR' => '2026',
            'WERKS' => 'W', 'LGORT' => 'L', 'BWART' => 'B', 'MENGE' => '10', 'ERFMG' => '1',
            'ERFME' => 'BOX', 'MAKTX' => 'TILE', 'BUDAT' => '20260701', 'WRHZET' => 'Z',
            'ARBPL' => 'A', 'MVGR4' => 'Q01', 'IDNRK' => '99'];
        $diff = ImportSupport::diffSortir([$this->sortirItem(['MENGE' => '20'])], ['1|2|3|2026' => $existing]);

        $this->assertCount(0, $diff['insert']);
        $this->assertCount(1, $diff['update']);
        $this->assertSame(5, $diff['update'][0]['id']);
        $this->assertSame('20', $diff['update'][0]['data']['MENGE']);
    }

    public function test_diff_sortir_dedupes_incoming_first_wins()
    {
        $diff = ImportSupport::diffSortir([$this->sortirItem(), $this->sortirItem(['MENGE' => '99'])], []);

        $this->assertCount(1, $diff['insert']);
        $this->assertSame('10', $diff['insert'][0]['MENGE']);
    }

    private function kilnItem(array $overrides = []): object
    {
        return (object) array_merge([
            'AUFNR' => '1001', 'MATNR' => '2002', 'VERID' => 'XX03',
            'BEZEI5' => '30X60', 'BEZEI1' => 'GLOSSY', 'MENGE' => '5', 'BUDAT' => '20260701',
        ], $overrides);
    }

    public function test_diff_kiln_inserts_new_with_menge_as_jumlah()
    {
        $diff = ImportSupport::diffKiln([$this->kilnItem()], []);

        $this->assertCount(1, $diff['insert']);
        $this->assertCount(0, $diff['update']);
        $this->assertSame(1001, $diff['insert'][0]['order_id']);
        $this->assertSame('RK 03', $diff['insert'][0]['mesin_id']);
        $this->assertEquals(5, $diff['insert'][0]['jumlah']);
        $this->assertSame(1, $diff['insert'][0]['shift_id']);
    }

    public function test_diff_kiln_accumulates_duplicate_incoming()
    {
        $diff = ImportSupport::diffKiln(
            [$this->kilnItem(['MENGE' => '5']), $this->kilnItem(['MENGE' => '7'])],
            []
        );

        $this->assertCount(1, $diff['insert']);
        $this->assertEquals(12, $diff['insert'][0]['jumlah']);
    }

    public function test_diff_kiln_adds_to_existing_jumlah()
    {
        $existing = ['id' => 9, 'size' => '30X60', 'jenis' => 'GLOSSY', 'jumlah' => '10',
            'created_at' => '2026-07-01 00:00:00'];
        $diff = ImportSupport::diffKiln([$this->kilnItem(['MENGE' => '5'])], ['1001|2002|RK 03' => $existing]);

        $this->assertCount(0, $diff['insert']);
        $this->assertCount(1, $diff['update']);
        $this->assertSame(9, $diff['update'][0]['id']);
        $this->assertEquals(15, $diff['update'][0]['data']['jumlah']);
    }
}
