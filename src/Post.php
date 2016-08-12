<?php
namespace Trendwerk\Faker;

use Nelmio\Alice\Fixtures\Loader;

final class Post
{
    public $acf;
    public $comment_status;
    public $guid;
    public $menu_order;
    public $meta;
    public $ping_status;
    public $post_author = 1;
    public $post_content;
    public $post_content_filtered;
    public $post_date;
    public $post_date_gmt;
    public $post_excerpt;
    public $post_mime_type;
    public $post_modified;
    public $post_modified_gmt;
    public $post_name;
    public $post_parent;
    public $post_password;
    public $post_status = 'publish';
    public $post_title;
    public $post_type;
    public $to_ping;

    public function getPostData()
    {
        $data = get_object_vars($this);

        unset($data['meta']);
        unset($data['acf']);

        return array_filter($data);
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function getAcf()
    {
        return $this->acf;
    }
}
