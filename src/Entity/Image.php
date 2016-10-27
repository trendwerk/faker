<?php
namespace Trendwerk\Faker\Entity;

class Image extends Attachment
{
    protected function create()
    {
        $fileName = basename($this->data);
        $upload = wp_upload_bits($fileName, null, file_get_contents($this->data));

        if ($upload['error']) {
            return;
        }

        $fileType = wp_check_filetype($fileName);
        $uploadDir = wp_upload_dir();

        $this->guid = $uploadDir['url'] . '/' . $fileName;
        $this->post_mime_type = $fileType['type'];
        $this->post_title = sanitize_file_name(pathinfo($fileName, PATHINFO_FILENAME));

        $attachmentId = wp_insert_attachment($this->getPostData(), $upload['file']);

        $metaData = wp_generate_attachment_metadata($attachmentId, $upload['file']);
        wp_update_attachment_metadata($attachmentId, $metaData);

        return $attachmentId;
    }
}
