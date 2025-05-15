<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

use App\Models\User;
use App\Models\Post;

class HourlyBotActivity extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hourly-bot-activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() {
        $users = User::all();

        // generate example posts for prompt
        $examplePosts = Post::with(['author'])
            ->whereHas('author', fn ($q) => $q->whereNotNull('bot_settings'))
            ->get()
            ->map(function ($post) {
                $settings = $post->author->bot_settings ?? [];

                return <<<EOT
        {
            "author": "{$post->author->name}",
            "personality": "{$settings['personality']}",
            "style": "{$settings['style']}",
            "interests": "{$settings['interests']}",
            "title": "{$post->title}",
            "body": "{$post->body}"
        }
        EOT;
            })
            ->implode("\n\n");

        \Log::info('generated example posts: ' . $examplePosts);

        foreach ($users as $user) {
            $settings = $user->bot_settings;

            if (!is_array($settings) || empty($settings)) {
                continue; // skip if null or invalid
            }

            $probability = $settings['activity_probability'] ?? null;

            if (!is_numeric($probability)) {
                continue; // skip if missing or malformed
            }

            $rand = mt_rand() / mt_getrandmax(); // random float [0, 1)

            if ($rand > $probability) {
                continue;
            }

            \Log::info("======= Proceeding for user {$user->id} with rand $rand <= $probability =======");
            
            // generate prompt
            $prompt = <<<EOT
            You are an AI simulating a bot user on a political forum. Your personality and tone are described below:

            {
                "personality": "{$user->bot_settings['personality']}",
                "style": "{$user->bot_settings['style']}",
                "interests": "{$user->bot_settings['interests']}"
            }

            Below are some example posts by various other users.
            Examples:
            EOT;

            $prompt .= $examplePosts;

            $prompt .= <<<EOT

            Now generate a single post that reflects your personality and interests. Return only valid JSON in this format:

            Return a single JSON object. Do not include extra text or formatting. Do not use triple backticks. Do not pretty print. Return the entire object on a single line like: {"title":"...","body":"..."}
            EOT;

            \Log::info('generated prompt: ' . $prompt);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
            ]);

            $content = $response->json()['choices'][0]['message']['content'] ?? null;
            //\Log::info($content);
            $content = preg_replace('/^```(?:json)?\s*|```$/', '', trim($content));

            \Log::info('GOT CONTENT');
            \Log::info($content);

            // Try to parse JSON from the response
            $postData = json_decode($content, true);

            \Log::info('PARSED POST DATA:');
            \Log::info($postData);

            if (json_last_error() !== JSON_ERROR_NONE) {
                \Log::error('JSON decode error: ' . json_last_error_msg());
                \Log::error('Response was: ' . $content);
            }


            if (json_last_error() === JSON_ERROR_NONE && isset($postData['title'], $postData['body'])) {
                Post::factory()->create([
                    'author_id' => $user->id,
                    'title' => $postData['title'],
                    'body' => $postData['body'],
                ]);
            } else {
                \Log::info('error!');
            }
        }
    }
}
