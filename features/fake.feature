Feature: Fake data

  Scenario: Generate posts
    Given a WP install
    And a post.yml file:
    """
    Trendwerk\Faker\Post:
      post{1..10}:
        post_content: <paragraphs(4, true)>
        post_title: '<sentence()>'
    """

    When I run `wp faker fake post.yml`
    Then STDOUT should contain:
      """
      Generated 10 new posts.
      """
