Feature: Accessibility
    In order to know anything about accessibility
    As an accessibility-concerned user
    I need to see the accessibility page

    Scenario: Simply visit the page
        When I visit "/"
        And I follow "Accessibilità"
        Then the response should contain "Dichiarazione di accessibilit"
        And the response should contain "vai all'homepage"
        And the response should contain "vai al forum"
        And the response should contain "vai al contenuto principale della pagina"
        And the response should contain "vai al myuniversibo"
