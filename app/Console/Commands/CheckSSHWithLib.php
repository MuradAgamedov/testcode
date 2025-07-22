<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use phpseclib3\Net\SSH2;
use phpseclib3\Crypt\PublicKeyLoader;

class CheckSSHWithLib extends Command
{
    protected $signature = 'ssh:check-lib';
    protected $description = 'Check SSH connection using phpseclib';

public function handle(): int
{
    $host = env('SSH_HOST');
    $user = env('SSH_USER');
    $password = env('SSH_PASSWORD');
    $keyPath = env('SSH_KEY_PATH');
    $repoDir = env('GIT_DIR', '/var/www/codepays');

    $gitUsername = env('GIT_USERNAME');
    $gitToken = env('GIT_TOKEN');
    $gitRepoUrl = env('GIT_REPO_URL');

    $ssh = new SSH2($host);

    if ($keyPath) {
        try {
            $key = PublicKeyLoader::loadPrivateKey(file_get_contents($keyPath));
            if (!$ssh->login($user, $key)) {
                $this->error('❌ SSH login uğursuz oldu (key ilə).');
                return self::FAILURE;
            }
        } catch (\Exception $e) {
            $this->error('Key yüklənə bilmədi: ' . $e->getMessage());
            return self::FAILURE;
        }
    } else {
        if (!$ssh->login($user, $password)) {
            $this->error('❌ SSH login uğursuz oldu (password ilə).');
            return self::FAILURE;
        }
    }

    // Git URL-i tokenlə formalaşdır
    $fullGitUrl = "https://{$gitUsername}:{$gitToken}@{$gitRepoUrl}";


    $commands = [
    "cd $repoDir && git remote set-url origin $fullGitUrl",
    "cd $repoDir && git pull origin main"
    ];


    foreach ($commands as $command) {
        $this->info("➡️  $command");
        $result = $ssh->exec($command);
        $this->line($result);
    }

    $this->info("✅ Git pull tamamlandı.");
    return self::SUCCESS;
}
}