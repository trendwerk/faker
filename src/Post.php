<?php
namespace Trendwerk\Faker;

use Nelmio\Alice\Fixtures\Loader;

final class Post
{
    public $meta;
    public $post_author;
    public $post_content;
    public $post_status;
    public $post_title;
    public $post_type;

    public function getPostData()
    {
        $data = get_object_vars($this);

        unset($data[$this->getMetaField()]);

        return $data;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    private function getMetaField()
    {
        return 'meta';
    }
}
