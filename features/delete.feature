Feature: Delete fake data

  Scenario: Generate and delete posts
    Given a WP install

    And a image.yml file:
      """
      Trendwerk\Faker\Entity\Image:
        image{1..1}:
          data: '<image()>'
      """

    And a post.yml file:
    """
    Trendwerk\Faker\Entity\Post:
      post{1..10}:
        post_content: <paragraphs(4, true)>
        post_title: '<sentence()>'
    """

    When I run `wp faker fake image.yml post.yml`
    When I run `wp faker delete --yes`
    Then STDOUT should contain:
      """
      Removed 1 attachment.
      Removed 10 posts.
      """

    When I run `wp post list --meta_key=_fake --format=count`
    Then STDOUT should be:
      """
      0
      """
