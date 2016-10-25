<?php
namespace Trendwerk\Faker\Entity;

class Post extends Entity
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
    public $terms;
    public $to_ping;

    public function getPostData()
    {
        $data = get_object_vars($this);

        unset($data['acf']);
        unset($data['meta']);
        unset($data['terms']);

        return array_filter($data);
    }

    public function getAcf()
    {
        return $this->acf;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function getTerms()
    {
        return $this->terms;
    }

    public function save()
    {
    }
}
