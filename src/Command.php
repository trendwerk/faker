<?php
namespace Trendwerk\Faker;

use WP_CLI;

final class Command
{
    /**
     * Generate fake data based on an Alice YAML file.
     *
     * @synopsis <file>
     */
    public function fake(array $args = [])
    {
        $fileName = $args[0];

        if (! file_exists($fileName)) {
            WP_CLI::error('Input file not found.');
        }

        $faker = new Faker($fileName);
        $count = $faker->run();

        WP_CLI::success(sprintf('Generated %d new posts.', $count));
    }

    /**
     * Delete all fake data
     */
    public function delete()
    {

        $postIds       = self::deletePosts();
        $attachmentIds = self::deleteAttachments();

        if( !$postIds ) {
            WP_CLI::log('No fake posts found.');
        } else {
            WP_CLI::success(sprintf('Deleted %d post(s).', count($postIds)));
        }

        if( !$attachmentIds ) {
            WP_CLI::log('No fake attachments found.');
        } else {
            WP_CLI::success(sprintf('Deleted %d attachment(s).', count($postIds)));
        }

    }

    /**
     * Delete attachments
     * @return array Array of deleted attachment IDs
     */
    private static function deleteAttachments()
    {
        return self::deletePostsType('attachment');
    }

    /**
     * Delete posts
     * @return array Array of deleted post IDs
     */
    private static function deletePosts()
    {
        return self::deletePostsType();
    }

    /**
     * Delete posts or attachments
     * @param  string $type Post type to delete
     * @return array Array of deleted IDs
     */
    private static function deletePostsType( $type = 'post' )
    {

        $key = [
            'post'       => '_fake',
            'attachment' => '_fake_attachment',
        ];

        if( !in_array($type, array_keys($key)) ) {
            return false;
        }

        global $wpdb;
        // Get all fake post IDs
        $postIds = $wpdb->get_col($wpdb->prepare("
            SELECT post_id
            FROM {$wpdb->prefix}postmeta
            WHERE meta_key = %s
            AND meta_value = '1'
        ", $key[$type]));

        if( empty($postIds) ) {
            return false;
        }

        // Delete posts
        foreach ($postIds as $postId) {
            if( $type === 'post' ) {
                wp_delete_post( $postId, true );
            } elseif( $type === 'attachment' ) {
                wp_delete_attachment( $postId, true );
            }
        }

        return $postIds;
    }

}
