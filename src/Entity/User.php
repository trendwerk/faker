<?php

namespace Trendwerk\Faker\Entity;

use WP_User_Query;

class User extends Entity
{
    public $user_pass; // The plain-text user password.
    public $user_login;  // The user's login username.
    public $user_nicename;  // The URL-friendly user name.
    public $user_url;  // The user URL.
    public $user_email;  // The user email address.
    public $display_name; // The user's display name. Default is the user's username.
    public $nickname; // The user's nickname. Default is the user's username.
    public $first_name; // The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
    public $last_name; // The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
    public $description; // The user's biographical description.
    public $rich_editing; // Whether to enable the rich-editor for the user. False if not empty.
    public $syntax_highlighting; // Whether to enable the rich code editor for the user. False if not empty.
    public $comment_shortcuts; // Whether to enable comment moderation keyboard shortcuts for the user. Default false.
    public $admin_color; // Admin color scheme for the user. Default 'fresh'.
    public $use_ssl; // Whether the user should always access the admin over https. Default false.
    public $user_registered; // Date the user registered. Format is 'Y-m-d H:i:s'.
    public $show_admin_bar_front; // Whether to display the Admin Bar for the user on the site's front end. Default true.
    public $role; // User's role.
    public $locale; // User's locale. Default empty.
    public $meta; // Users Meta Values

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
