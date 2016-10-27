Feature: Fake attachments

  Scenario: Generate images
    Given a WP install
    And a image.yml file:
    """
    Trendwerk\Faker\Entity\Image:
      image{1..3}:
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

    Scenario: Generate posts, images and association
      Given a WP install
      And a post-image.yml file:
      """
      Trendwerk\Faker\Entity\Image:
        image{1..1}:
          data: '<image()>'

      Trendwerk\Faker\Post:
        post{1..1}:
          post_content: <paragraphs(3, true)>
          post_title: '<sentence()>'
          meta:
            _thumbnail_id: '@image*->id'
      """

      When I run `wp faker fake post-image.yml`
      Then STDOUT should contain:
        """
        Generated 2 new posts.
        """

      When I run `wp post list --post_type=attachment --post_mime_type=image/jpeg --meta_key=_fake --format=ids`
      Then STDOUT should be a number
      And save STDOUT as {ATTACHMENT_ID}

      When I run `wp post list --post_type=post --meta_key=_fake --format=ids`
      Then STDOUT should be a number
      And save STDOUT as {POST_ID}

      When I run `wp post meta get {POST_ID} _thumbnail_id`
      Then STDOUT should be:
        """
        {ATTACHMENT_ID}
        """
