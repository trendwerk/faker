<?php
namespace Trendwerk\Faker;

use Nelmio\Alice\PersisterInterface;

final class Persister implements PersisterInterface
{
    public function persist(array $objects)
    {
        foreach ($objects as $object) {
            $objectId = wp_insert_post($object->getPostData());

            update_post_meta($objectId, '_fake', true);

            if ($object->getMeta()) {
                foreach ($object->getMeta() as $key => $value) {
                    update_post_meta($objectId, $key, $value);
                }
            }

            if (class_exists('acf') && $object->getAcf()) {
                foreach ($object->getAcf() as $name => $value) {
                    $field = acf_get_field($name);
                    update_field($field['key'], $value, $objectId);
                }
            }

            if ($object->getTerms()) {
                foreach ($object->getTerms() as $taxonomy => $termIds) {
                    wp_set_object_terms($objectId, $termIds, $taxonomy);
                }
            }
        }
    }

    public function find($class, $id)
    {
    }
}
