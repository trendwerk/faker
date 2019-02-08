<?php

namespace Trendwerk\Faker\Entity;

use WP_User_Query;

class User extends Entity
{
    public $user_pass;
    public $user_login; 
    public $user_nicename; 
    public $user_url; 
    public $user_email; 
    public $display_name;
    public $nickname;
    public $first_name;
    public $last_name;
    public $description;
    public $rich_editing;
    public $syntax_highlighting;
    public $comment_shortcuts;
    public $admin_color;
    public $use_ssl;
    public $user_registered;
    public $show_admin_bar_front;
    public $role;
    public $locale;
    public $meta;

    public function persist()
    {
        $this->id = $this->create();

        update_user_meta($this->id, '_fake', true);

        if ($this->meta) {
            foreach ($this->meta as $key => $value) {
                update_user_meta($this->id, $key, $value);
            }
        }
    }

    public static function delete()
    {
        $query = new WP_User_Query([
            'fields' => 'ids',
            'meta_query' => [
                [
                    'key' => '_fake',
                    'value' => true,
                ],
            ],
        ]);

        foreach ($query->results as $id) {
            wp_delete_user($id);
        }

        return count($query->results);
    }

    protected function create()
    {
        return wp_insert_user($this->getUserData());
    }

    protected function getUserData()
    {
        $data = get_object_vars($this);

        return array_filter($data);
    }
}
