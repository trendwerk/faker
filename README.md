# Faker
Fake post data with [wp-cli](https://github.com/wp-cli/wp-cli). Made for WordPress.

[![Build Status](https://travis-ci.org/trendwerk/faker.svg?branch=master)](https://travis-ci.org/trendwerk/faker)

Relies on [nelmio/alice](https://github.com/nelmio/alice) and [fzaninotto/Faker](https://github.com/fzaninotto/Faker).

## Install
```
wp package install trendwerk/faker
```

Requires [wp-cli](https://github.com/wp-cli/wp-cli) >= 0.23.

## Usage

### Generate fake data
```
wp faker fake <file>
```

#### Options
| Parameter | Default | Required | Description |
| :--- | :--- | :--- | :--- |
| `<file>` | `null` | Yes | Location to an [Alice](https://github.com/nelmio/alice) YAML file

### Delete fake data

```
wp faker delete
```

## Support
The YAML file supports:

| Fields | Description |
| :--- | :--- |
| `WP_Post` | All properties from [`wp_insert_post`](https://developer.wordpress.org/reference/functions/wp_insert_post/)
| `meta` | Post meta
| `terms` | Terms for taxonomies, see [Terms](https://github.com/trendwerk/faker#terms)
| `acf` | [Advanced Custom Fields](https://www.advancedcustomfields.com/) fields, see [ACF](https://github.com/trendwerk/faker#acf)

## YAML / Faker
Your YAML file(s) could look like any the examples below. 

For more understanding of the internals:
- The YAML file is interpreted by [nelmio/alice](https://github.com/nelmio/alice);
- Any of the functions from [fzaninotto/Faker](https://github.com/fzaninotto/Faker) are available;
- Additionaly, the [`<terms>`](https://github.com/trendwerk/faker#terms) function is provided by this library.

### Basic
```yaml
Trendwerk\Faker\Post:
  post{1..100}:
    post_content: <paragraphs(4, true)>
    post_title: '<sentence()>'
```

Generates 100 posts with a title and content.

### Post Type
```yaml
Trendwerk\Faker\Post:
  post{1..100}:
    post_title: '<sentence()>'
    post_type: 'testimonials'
```

Generates 100 posts from the post type `testimonials` with a title.

### Meta
```yaml
Trendwerk\Faker\Post:
  post{1..100}:
    post_title: '<sentence()>'
    post_type: 'testimonials'
    meta:
      name: '<name()>'
      address: '<address()>'
```

Generates 100 testimonials with a title and a custom field called `name` and one called `address`.

### Terms
```yaml
Trendwerk\Faker\Post:
  post{1..100}:
    post_content: <paragraphs(3, true)>
    post_title: '<sentence()>'
    terms:
      category: <terms('category', 1)>
      post_tag: <terms('post_tag', 7)>
```

Generates 100 posts with a title, content, 1 random category and 7 random tags.

_Using `<terms>` is not required. You could also provide an array of integers yourself or use [randomElements](https://github.com/fzaninotto/Faker#fakerproviderbase)._

#### Options

| Parameter | Default | Required
| :--- | :--- | :--- |
| `taxonomy` | `null` | Yes
| `amount` | `1` | No

### Thumbnails

```yaml
Trendwerk\Faker\Post:
  post{1..30}:
    post_content: <paragraphs(4, true)>
    post_title: '<sentence()>'
    post_thumbnail: <thumbnail(800, 800, 'nature')>
```

Generates 30 posts with a title, content and a post thumbnail sized at 800x800 pixels from the 'nature' category of [http://lorempixel.com/](http://lorempixel.com/). 

Available image categories can be found [here](https://github.com/fzaninotto/Faker/blob/master/src/Faker/Provider/Image.php#L10). The category parameter is optional. If not provided, images will be picked up randomly accross categories. 

_Images are downloaded and resized by WordPress. Depending of the amount of generated posts, the process may take a while._

#### Options

| Parameter | Default | Required
| :--- | :--- | :--- |
| `width` | `640` | No
| `height` | `480` | No
| `category` | `null` | No

### ACF
```yaml
Trendwerk\Faker\Post:
  post{1..100}:
    post_content: <paragraphs(3, true)>
    post_title: '<sentence()>'
    acf:
      name: '<name()>'
      address: '<address()>'
```

Generates 100 posts with a title, content, and two filled ACF fields: `name` and `address`.

#### Duplicate field names
In ACF, it is possible to have multiple fields with the same name. This could cause formatting conflicts when faking data with this library. If you have two fields with the same name, **using the unique field key is recommended**:

```yaml
Trendwerk\Faker\Post:
  post{1..100}:
    post_content: <paragraphs(3, true)>
    post_title: '<sentence()>'
    acf:
      field_56cf2f782e9b1: '<name()>' # Name
      address: '<address()>'
```
