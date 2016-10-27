<?php
namespace Trendwerk\Faker\Entity;

abstract class Attachment extends Post
{
    public $data;
    public $post_type = 'attachment';
    public $post_status = 'inherit';
}
