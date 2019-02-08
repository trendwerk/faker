Feature: Fake users

  Scenario: Generate user
    Given a WP install
    And a user.yml file:
        """
        Trendwerk\Faker\Entity\User:
            user{1..10}:
                user_login: '<username()>'
                user_pass: '<username()>'
                first_name: '<firstName()>'
                last_name: '<lastName()>'
                display_name: '<firstName()> <lastName()>'
                user_email: '<email()>'
                role: 'editor'
        """

    When I run `wp faker fake user.yml`
    Then STDOUT should contain:
        """
        Generated 10 new objects.
        """

    When I run `wp user list --role=editor --meta_key=_fake --format=count`
    Then STDOUT should be:
        """
        10
        """
