Feature: Home page
    In order to have a starting point
    As a user
    I need to see the home page

    Scenario: Simply visit home page
        When I visit "/"
        Then the response should contain "Benvenuto in UniversiBO!"
        And the response should contain "la nuova versione della community e degli strumenti per la didattica ideato dagli studenti"
