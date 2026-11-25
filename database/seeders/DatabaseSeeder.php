<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Band;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Contas demonstrativas. Alterar as palavras-passe antes de publicar.
        User::firstOrCreate(
            ['email' => 'admin@rockband.test'],
            ['name' => 'Administrador', 'password' => Hash::make('Admin123!'), 'user_type' => User::TYPE_ADMIN]
        );

        User::firstOrCreate(
            ['email' => 'user@rockband.test'],
            ['name' => 'Utilizador', 'password' => Hash::make('User12345!'), 'user_type' => User::TYPE_GENERIC_USER]
        );

        $data = [
            [
                'name_of_band' => 'Green Day',
                'photo_of_band' => 'images/bands/green-day.webp',
                'albums' => [
                    ['album_name' => 'American Idiot', 'album_cover' => 'images/albums/american-idiot.png', 'year' => 2004],
                    ['album_name' => '21st Century Breakdown', 'album_cover' => 'images/albums/21st-century-breakdown.jpg', 'year' => 2009],
                ],
            ],
            [
                'name_of_band' => 'Patti Smith',
                'photo_of_band' => 'images/bands/patti-smith.jpeg',
                'albums' => [
                    ['album_name' => 'Horses', 'album_cover' => 'images/albums/horses.jpg', 'year' => 1975],
                    ['album_name' => 'Wave', 'album_cover' => 'images/albums/wave.jpg', 'year' => 1979],
                ],
            ],
            [
                'name_of_band' => 'GNR',
                'photo_of_band' => 'images/bands/gnr.webp',
                'albums' => [
                    ['album_name' => 'Rock in Rio Douro', 'album_cover' => 'images/albums/rock-in-rio-douro.jpg', 'year' => 1992],
                    ['album_name' => 'Popless', 'album_cover' => 'images/albums/popless.jpg', 'year' => 2000],
                ],
            ],
        ];

        foreach ($data as $item) {
            $band = Band::firstOrCreate(
                ['name_of_band' => $item['name_of_band']],
                ['photo_of_band' => $item['photo_of_band'], 'number_of_albuns' => 0]
            );

            foreach ($item['albums'] as $itemAlbum) {
                Album::firstOrCreate(
                    ['band_id' => $band->id, 'album_name' => $itemAlbum['album_name']],
                    [
                        'album_cover' => $itemAlbum['album_cover'],
                        // Só foi fornecido o ano: 01/01 é o valor técnico do campo DATE.
                        'release_date' => $itemAlbum['year'].'-01-01',
                        'record_lable' => null,
                    ]
                );
            }

            $band->update(['number_of_albuns' => $band->albums()->count()]);
        }
    }
}
