<?php
namespace Tests\Feature;
use App\Models\User;
use App\Models\KategoriDonasi;
use App\Models\PenggalangDana;
use App\Models\ProgramDonasi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test; // <-- Menggunakan Attribute baru
class AdminProgramDonasiTest extends TestCase
{
    use RefreshDatabase;
    protected $admin;
    protected $kategori;
    protected $penggalang;
    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['is_admin' => true]);
        
        $this->kategori = KategoriDonasi::create([
            'name' => 'Kemanusiaan',
            'slug' => 'kemanusiaan',
            'deskripsi' => 'Bantuan kemanusiaan'
        ]);
        $this->penggalang = PenggalangDana::create([
            'nama' => 'Yayasan Amal',
            'tipe' => 'yayasan', 
            'kontak' => '0812345678',
        ]);
    }
    #[Test] 
    public function admin_bisa_melihat_daftar_program_donasi()
    {
        $response = $this->actingAs($this->admin)
                         ->get(route('admin.programs.index'));
        $response->assertStatus(200);
        $response->assertSee('Program Donasi');
    }
    #[Test]
    public function admin_bisa_membuat_program_donasi_baru()
    {
        $data = [
            'title' => 'Bantu Korban Banjir',
            'kategori_id' => $this->kategori->id,
            'penggalang_id' => $this->penggalang->id,
            'target_amount' => 50000000,
            'start_date' => now()->format('Y-m-d'),
            'end_date' => now()->addMonth()->format('Y-m-d'),
            'short_description' => 'Deskripsi singkat bantuan banjir',
            'status' => 'active',
        ];
        $response = $this->actingAs($this->admin)
                         ->post(route('admin.programs.store'), $data);
        $response->assertRedirect(route('admin.programs.index'));
        
        $this->assertDatabaseHas('program_donasi', [
            'title' => 'Bantu Korban Banjir',
            'target_amount' => 50000000
        ]);
    }
    #[Test]
    public function admin_bisa_mengupdate_program_donasi()
    {
        $program = ProgramDonasi::create([
            'title' => 'Program Lama',
            'slug' => 'program-lama',
            'kategori_id' => $this->kategori->id,
            'penggalang_id' => $this->penggalang->id,
            'target_amount' => 1000000,
            'start_date' => now()->format('Y-m-d'),
            'status' => 'active',
        ]);
        $response = $this->actingAs($this->admin)
                         ->put(route('admin.programs.update', $program), [
                             'title' => 'Program Diperbarui',
                             'kategori_id' => $this->kategori->id,
                             'penggalang_id' => $this->penggalang->id,
                             'target_amount' => 2000000,
                             'start_date' => $program->start_date,
                         ]);
        $response->assertRedirect(route('admin.programs.index'));
        
        $this->assertDatabaseHas('program_donasi', [
            'id' => $program->id,
            'title' => 'Program Diperbarui'
        ]);
    }
    #[Test]
    public function admin_bisa_menghapus_program_donasi()
    {
        $program = ProgramDonasi::create([
            'title' => 'Program Mau Dihapus',
            'slug' => 'hapus-me',
            'kategori_id' => $this->kategori->id,
            'penggalang_id' => $this->penggalang->id,
            'target_amount' => 1000,
            'start_date' => now()->format('Y-m-d'),
            'status' => 'active',
        ]);
        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.programs.destroy', $program));
        $response->assertRedirect(route('admin.programs.index'));
        
        $this->assertDatabaseMissing('program_donasi', [
            'id' => $program->id
        ]);
    }
}