<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'https://github.com/The-Alps-Hotel-Nakuru/leadership-center.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('server/')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/The Alps Hotel Nakuru LC');

// Hooks

after('deploy:failed', 'deploy:unlock');
