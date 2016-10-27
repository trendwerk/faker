Feature: Fake attachments

  Scenario: Generate images
    Given a WP install
    And a image.yml file:
    """
    Trendwerk\Faker\Entity\Image:
      image{1..3}:
        type: 'image'
        settings:
          data: '<image()>'
    """

    When I run `wp faker fake image.yml`
    Then STDOUT should contain:
      """
      Generated 3 new posts.
      """

    When I run `wp post list --post_type=attachment --post_mime_type=image/jpeg --meta_key=_fake --format=count`
    Then STDOUT should be:
      """
      3
      """
