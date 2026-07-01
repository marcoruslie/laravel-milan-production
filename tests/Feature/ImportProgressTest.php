<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ImportProgressTest extends TestCase
{
    public function test_returns_pending_when_no_progress_stored()
    {
        $this->getJson('/api/home/importProgress/does-not-exist')
            ->assertOk()
            ->assertJson(['progress' => 0, 'phase' => 'pending', 'message' => '']);
    }

    public function test_returns_stored_progress()
    {
        Cache::put('import:job-123', ['progress' => 42, 'phase' => 'saving', 'message' => 'Saving 5/10'], now()->addMinutes(5));

        $this->getJson('/api/home/importProgress/job-123')
            ->assertOk()
            ->assertJson(['progress' => 42, 'phase' => 'saving', 'message' => 'Saving 5/10']);
    }
}
