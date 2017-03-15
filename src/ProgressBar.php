<?php
namespace Trendwerk\Faker;

use function WP_CLI\Utils\make_progress_bar;

final class ProgressBar
{
    private $progress;

    public function start($count)
    {
        $this->progress = make_progress_bar('Generating fake data...', $count);
    }

    public function tick()
    {
        $this->progress->tick();
    }

    public function finish()
    {
        $this->progress->finish();
    }
}
