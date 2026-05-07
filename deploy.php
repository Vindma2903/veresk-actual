<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:Naskalin/veresk.git');
set('clear_paths', ['deploy.php']);
set('keep_releases', 2);
set('writable_mode', 'chmod');
set('ssh_multiplexing', false);
set('bin/php', '/usr/local/php/cgi/8.1/bin/php');
set('bin/composer', function () {
    return '/usr/local/php/cgi/8.1/bin/php ~/.local/bin/composer';
});
set('allow_anonymous_stats', false);
set('git_tty', true);
//set('bin/npm', static function () {
//    return run('which npm');
//});

add('shared_files', []);
add('shared_dirs', ['storage', 'public/assets']);
add('writable_dirs', []);

// Hosts

host('max13nue.beget.tech')
    ->setRemoteUser('max13nue')
    ->setIdentityFile('~/.ssh/id_rsa')
    ->set('deploy_path', '~/veresk2');

task('beget:symlink', static function () {
    run('{{bin/symlink}} {{deploy_path}}/current/public {{deploy_path}}/public_html');
});

task('npm:prod', static function () {
    exec('cmd.exe /c npm run build');
    upload('./public/build', '{{release_path}}/public');
});

task('app:commands', static function() {
    run('{{bin/php}} {{release_path}}/artisan app:sitemap');
});

// Hooks

after('deploy:failed', 'deploy:unlock');
after('deploy:symlink', 'beget:symlink');
after('deploy:symlink', 'app:commands');
after('deploy:update_code', 'npm:prod');
