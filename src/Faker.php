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
        $loader = new Loader(get_locale(), [new Provider\Term(), new Provider\PostThumbnail()]);
        $posts = $loader->load($this->file);

        foreach ($posts as $post) {
            $this->persist($post);
        }

        return count($posts);
    }

    private function persist(Post $post)
    {
        $postId = wp_insert_post($post->getPostData());

        update_post_meta($postId, '_fake', true);

        if ($thumbnailId = $post->getPostThumbnail()) {
            set_post_thumbnail( $postId, $thumbnailId );
        }

        if ($post->getMeta()) {
            foreach ($post->getMeta() as $key => $value) {
                update_post_meta($postId, $key, $value);
            }
        }

        if (class_exists('acf') && $post->getAcf()) {
            foreach ($post->getAcf() as $name => $value) {
                $field = acf_get_field($name);
                update_field($field['key'], $value, $postId);
            }
        }

        if ($post->getTerms()) {
            foreach ($post->getTerms() as $taxonomy => $termIds) {
                wp_set_object_terms($postId, $termIds, $taxonomy);
            }
        }
    }
}
