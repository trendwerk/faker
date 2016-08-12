<?php
namespace Trendwerk\Faker;

use Nelmio\Alice\Fixtures\Loader;

final class Faker
{
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }

    public function run()
    {
        $loader = new Loader();
        $posts = $loader->load($this->file);

        foreach ($posts as $post) {
            $this->persist($post);
        }

        return count($posts);
    }

    private function persist($post)
    {
        $postId = wp_insert_post($post->getPostData());

        update_post_meta($postId, '_fake', true);

        foreach ($post->getMeta() as $key => $value) {
            update_post_meta($postId, $key, $value);
        }
    }
}
