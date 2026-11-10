<?php

namespace Tests\Unit;

use App\Models\Praktikan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Kolom praktikans.nim ber-index unique. Factory harus menghasilkan NIM yang
 * unik; sebelumnya numerify() tanpa unique() sesekali bertabrakan dengan baris
 * yang sudah ada sehingga request "update praktikan" acak gagal dengan 422.
 */
class PraktikanFactoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_generated_nims_are_unique(): void
    {
        $praktikans = Praktikan::factory()->count(25)->create();

        $nims = $praktikans->pluck('nim');

        $this->assertCount(25, $nims->unique(), 'Factory menghasilkan NIM duplikat.');
    }

    public function test_nim_matches_ten_digit_format(): void
    {
        $praktikan = Praktikan::factory()->create();

        $this->assertMatchesRegularExpression('/^\d{10}$/', $praktikan->nim);
    }
}
