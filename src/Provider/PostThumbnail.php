<?php
namespace Trendwerk\Faker\Provider;

use Faker\Provider\Image;

final class PostThumbnail
{
    public function thumbnail($width = 640, $height = 480, $category = null)
    {

		$uploadDir       = wp_upload_dir();
		$filePath        = Image::image($uploadDir['path'], $width, $height, $category);
		$fileName        = basename( $filePath );
		$fileType        = wp_check_filetype( $fileName, null );
		$attachmentTitle = sanitize_file_name( pathinfo( $fileName, PATHINFO_FILENAME ) );

		$attachment = [
			'guid'           => $uploadDir['url'] . '/' . $fileName,
			'post_mime_type' => $fileType['type'],
			'post_title'     => $attachmentTitle,
			'post_content'   => '',
			'post_status'    => 'inherit',
		];

		// Create the attachment
		$attachmentId = wp_insert_attachment( $attachment, $filePath );

		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		// Generate attachment metadata
		$attachmentData = wp_generate_attachment_metadata( $attachmentId, $filePath );

		// Assign metadata to attachment
		wp_update_attachment_metadata( $attachmentId,  $attachmentData );

		update_post_meta($attachmentId, '_fake_attachment', true);

		return $attachmentId;
    }

}
