Feature: Show file information
    In order to decide to whether download a file or not
    As a user
    I need to see file information

    Scenario: Show file
        When I visit "/file/1/"
        Then the response should contain "Inserito da:"
        And the response should contain "admin"
        And the response should contain "Inserito il:"
        And the response should contain "5/03/2013"
        And the response should contain "Titolo"
        And the response should contain "Test file"
        And the response should contain "Descrizione/abstract:"
        And the response should contain "robots SEO"
