<?php
namespace Trendwerk\Faker\Entity;

use WP_Query;

abstract class Attachment extends Post
{
    public $data;
    public $post_type = 'attachment';
    public $post_status = 'inherit';

    public static function delete()
    {
        $query = new WP_Query([
            'fields'         => 'ids',
            'meta_query'     => [
                [
                    'key'    => '_fake',
                    'value'  => true,
                ],
            ],
            'post_status'    => 'any',
            'post_type'      => 'attachment',
            'posts_per_page' => -1,
        ]);

        foreach ($query->posts as $id) {
            wp_delete_attachment($id, true);
        }

        return count($query->posts);
    }
}
