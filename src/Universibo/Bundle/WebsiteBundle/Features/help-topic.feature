Feature: Help by topic
    In order to learn to use UniversiBO
    As a user
    I need to read the help grouped by topic

    Scenario: Simply visit the page
        When I visit "/"
        And I follow "Help"
        Then the response should contain "Come faccio ad iscrivermi ad UniversiBO?"
        And the response should contain "Navigazione nel sito: i primi passi."
        And the response should contain "Voglio mettere un file on line su UniversiBO: come posso fare?"
        And the response should contain "Come faccio a scaricare i files da UniversiBO?"
        And the response should contain "Come personalizzare My UniversiBO."
        And the response should contain "e come gestire il servizio di News di UniversiBO."
        And the response should contain "Cercare un utente e cambiare i diritti (solo Admin)"
        And the response should contain "Voglio inserire una notizia su UniversiBO: come posso fare?"
        And the response should contain "Modificare un insegnamento e cercare un codice docente (solo admin e collaboratori)"
