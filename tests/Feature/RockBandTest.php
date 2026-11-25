<?php

namespace Tests\Feature;

use App\Models\Album;
use App\Models\Band;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RockBandTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitantes_podem_ver_bandas_e_albuns(): void
    {
        $band = Band::create(['name_of_band' => 'Green Day', 'number_of_albuns' => 1]);
        $band->albums()->create(['album_name' => 'American Idiot', 'release_date' => '2004-01-01']);

        $this->get(route('bands.all'))->assertOk()->assertSee('Green Day');
        $this->get(route('bands.show', $band))->assertOk()->assertSee('American Idiot');
    }

    public function test_visitantes_nao_podem_editar_ou_abrir_dashboard(): void
    {
        $band = Band::create(['name_of_band' => 'Exemplo', 'number_of_albuns' => 0]);

        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('bands.edit', $band))->assertRedirect(route('login'));
        $this->put(route('bands.update', $band), ['name_of_band' => 'Outro'])->assertRedirect(route('login'));
    }

    public function test_user_pode_editar_mas_nao_inserir_nem_apagar(): void
    {
        $user = User::factory()->create(['user_type' => User::TYPE_GENERIC_USER]);
        $band = Band::create(['name_of_band' => 'Antes', 'number_of_albuns' => 0]);
        $album = $band->albums()->create(['album_name' => 'Antes', 'release_date' => '2000-01-01']);

        $this->actingAs($user)->put(route('bands.update', $band), [
            'name_of_band' => 'Depois',
        ])->assertRedirect(route('bands.all'));
        $this->assertDatabaseHas('bands', ['id' => $band->id, 'name_of_band' => 'Depois']);

        $this->actingAs($user)->put(route('albums.update', $album), [
            'album_name' => 'Disco novo', 'release_year' => 2001,
        ])->assertRedirect(route('bands.show', $band));
        $this->assertDatabaseHas('albums', ['id' => $album->id, 'album_name' => 'Disco novo']);

        $this->actingAs($user)->get(route('bands.add'))->assertForbidden();
        $this->actingAs($user)->post(route('bands.store'), ['name_of_band' => 'Ilegal'])->assertForbidden();
        $this->actingAs($user)->delete(route('bands.delete', $band))->assertForbidden();
        $this->actingAs($user)->delete(route('albums.delete', $album))->assertForbidden();
        $this->actingAs($user)->get(route('albums.add', $band))->assertForbidden();
    }

    public function test_administrador_pode_criar_e_apagar_bandas_e_albuns(): void
    {
        $admin = User::factory()->create(['user_type' => User::TYPE_ADMIN]);

        $this->actingAs($admin)->post(route('bands.store'), [
            'name_of_band' => 'Banda Nova',
        ])->assertRedirect(route('bands.all'));
        $band = Band::where('name_of_band', 'Banda Nova')->firstOrFail();

        $this->actingAs($admin)->post(route('albums.store', $band), [
            'album_name' => 'Disco 1', 'release_year' => 2020,
        ])->assertRedirect(route('bands.show', $band));
        $this->assertDatabaseHas('bands', ['id' => $band->id, 'number_of_albuns' => 1]);
        $album = Album::where('band_id', $band->id)->firstOrFail();

        $this->actingAs($admin)->delete(route('albums.delete', $album))
            ->assertRedirect(route('bands.show', $band));
        $this->assertDatabaseHas('bands', ['id' => $band->id, 'number_of_albuns' => 0]);

        $this->actingAs($admin)->delete(route('bands.delete', $band))
            ->assertRedirect(route('bands.all'));
        $this->assertDatabaseMissing('bands', ['id' => $band->id]);
    }

    public function test_registo_publico_nao_pode_criar_um_admin(): void
    {
        $this->post(route('register.store'), [
            'name' => 'Pessoa',
            'email' => 'pessoa@example.test',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'user_type' => User::TYPE_ADMIN,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'pessoa@example.test',
            'user_type' => User::TYPE_GENERIC_USER,
        ]);
        $this->get(route('dashboard'))->assertOk()->assertSee('Olá, Pessoa');
    }
    public function test_api_respeita_permissoes(): void
    {
        $band = Band::create(['name_of_band' => 'API', 'number_of_albuns' => 0]);
        $this->getJson('/api/bands')->assertOk();
        $this->putJson('/api/bands/'.$band->id, ['name_of_band' => 'Novo'])->assertUnauthorized();
        $user = User::factory()->create(['user_type' => User::TYPE_GENERIC_USER]);
        \Laravel\Sanctum\Sanctum::actingAs($user);
        $this->putJson('/api/bands/'.$band->id, ['name_of_band' => 'Novo'])->assertOk();
        $this->postJson('/api/bands', ['name_of_band' => 'Outra'])->assertForbidden();
        $this->deleteJson('/api/bands/'.$band->id)->assertForbidden();
    }

    public function test_login_fortify(): void
    {
        $user = User::factory()->create(['password' => 'Password123!']);
        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'Password123!'])
            ->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }
}
