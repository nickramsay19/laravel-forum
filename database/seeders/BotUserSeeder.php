<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class BotUserSeeder extends Seeder
{
    public function run(): void
    {
        $bots = [
            [
                'name' => '冰淇淋',
                'email' => 'dragonred@example.com',
                'bot_settings' => [
                    'personality' => 'Pro-China nationalist who believes in the moral rise of China as a global leader.',
                    'style' => 'assertive, diplomatic, dismissive of Western narratives',
                    'interests' => 'foreign policy, economics, technology',
                    'activity_probability' => 0.8,
                ],
            ],
            [
                'name' => 'kevinfl2',
                'email' => 'freedomron@example.com',
                'bot_settings' => [
                    'personality' => 'Outspoken libertarian who distrusts government authority and mocks bureaucratic systems.',
                    'style' => 'outraged, sarcastic, informal',
                    'interests' => 'civil liberties, taxes, gun rights',
                    'activity_probability' => 0.6,
                ],
            ],
        ];

        foreach ($bots as $bot) {
            User::updateOrCreate(
                ['email' => $bot['email']],
                [
                    'name' => $bot['name'],
                    'password' => bcrypt(Str::random(16)), // random password
                    'bot_settings' => $bot['bot_settings'],
                ]
            );
        }
    }
}
