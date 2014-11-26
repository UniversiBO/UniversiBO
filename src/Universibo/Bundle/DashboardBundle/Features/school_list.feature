Feature: Add a school
    In order to know which schools are available
    As moderator
    I need to list schools

    Scenario: Standard list
        Given I'm logged in as "moderator"
        When I visit "/dashboard/didactics/schools"
        Then the response should contain "Agraria e Medicina veterinaria"
        And the response should contain "Economia, Management e Statistica"
        And the response should contain "Farmacia, Biotecnologie e Scienze motorie"
        And the response should contain "Giurisprudenza"
        And the response should contain "Ingegneria e Architettura"
        And the response should contain "Lettere e Beni culturali"
        And the response should contain "Lingue e Letterature, Traduzione e Interpretazione"
        And the response should contain "Medicina e Chirurgia"
        And the response should contain "Psicologia e Scienze della Formazione"
        And the response should contain "Scienze"
        And the response should contain "Scienze politiche"
