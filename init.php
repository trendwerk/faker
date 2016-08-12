<?php
namespace Trendwerk\Faker;

use WP_CLI;

if (! class_exists('WP_CLI')) {
	return;
}

WP_CLI::add_command('faker', __NAMESPACE__ . '\\Command');
