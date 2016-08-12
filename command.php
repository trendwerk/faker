<?php
if (! class_exists('WP_CLI')) {
	return;
}

WP_CLI::add_command('faker', function () {
    WP_CLI::success('Hello.');
});
