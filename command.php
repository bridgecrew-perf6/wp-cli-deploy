<?php

use Mustangostang\Spyc;

if (!class_exists('WP_CLI')) {
    return;
}

/**
 * Rsync files
 *
 * @when after_wp_load
 */
WP_CLI::add_command(
    'deploy',
    function ($args, $assoc_args) {
        try {
            if (empty($args[0])) {
                WP_CLI::error('Please provide an environment. Example: wp deploy prod');
            }

            $env = '@' . $args[0];

            $aliases = WP_CLI::get_configurator()->get_aliases();

            if (!isset($aliases[$env])) {
                WP_CLI::error("Environment $env doesn't seem present in your WP-CLI config.");
            }

            if (!isset($aliases[$env]['ssh'])) {
                WP_CLI::error("The $env environment doesn't have a 'ssh' setting in your WP-CLI config.");
            }

            // do some url parsing
            $sshUrl = rtrim($aliases[$env]['ssh'], '/');
            $sshUrlParts = parse_url($sshUrl);

            $command = sprintf(
                'ssh %s@%s -p %s "cd %s && git pull"',
                $sshUrlParts['user'],
                $sshUrlParts['host'],
                empty($sshUrlParts['port']) ? 21 : $sshUrlParts['port'],
                $sshUrlParts['path']
            );

            // Transfer all uploaded files
            WP_CLI::log('');
            WP_CLI::log('Pulling remote...');
            passthru($command);

            WP_CLI::success("Deploy complete.");
        } catch (Exception $error) {
            WP_CLI::error($error->getMessage());
        }
    }
);
