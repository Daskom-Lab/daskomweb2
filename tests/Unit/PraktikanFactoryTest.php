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

    /**
     * UpdatePraktikanRequest membatasi nomor_telepon maksimal 15 karakter.
     * faker->phoneNumber() bisa lebih panjang (mis. "+1 (555) 123-4567 ext. 89"),
     * sehingga test yang mengirim ulang data factory gagal 422 secara acak.
     */
    public function test_phone_numbers_fit_the_validation_limit(): void
    {
        $nomorTelepon = Praktikan::factory()->count(50)->create()->pluck('nomor_telepon');

        foreach ($nomorTelepon as $nomor) {
            $this->assertLessThanOrEqual(
                15,
                mb_strlen($nomor),
                "Nomor telepon dari factory melebihi batas validasi 15 karakter: {$nomor}"
            );
        }
    }
}
