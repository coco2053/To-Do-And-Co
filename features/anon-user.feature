Feature:
  In order to navigate on the application
  As a anonymous user
  I want to access to different pages

  @login_page
  Scenario: A anonymous user can access to login page
    Given I'm on "/login" page
    Then the page should contain "Nom d'utilisateur"

  @register
  Scenario: A anonymous user register to the website
    Given I'm on "/users/create" page
    Then the page should contain "Créer un utilisateur"
    Then I enter "Marco" in the "Nom d'utilisateur" field
    Then I enter "Mysecretecode" in the "Mot de passe" field
    Then I enter "Mysecretecode" in the "Tapez le mot de passe à nouveau" field
    Then I enter "marco@mysite.com" in the "Adresse email" field
    When I click on button "Ajouter"
    Then the page should contain "Superbe ! L'utilisateur a bien été ajouté."

  @register_fail
  Scenario: A anonymous user tries to register to the website and miss confirmation password
    Given I'm on "/users/create" page
    Then the page should contain "Créer un utilisateur"
    Then I enter "Marco" in the "Nom d'utilisateur" field
    Then I enter "Mysecretecode" in the "Mot de passe" field
    Then I enter "MysecretecodeJJJ" in the "Tapez le mot de passe à nouveau" field
    Then I enter "marco@mysite.com" in the "Adresse email" field
    When I click on button "Ajouter"
    Then the page should contain "Les deux mots de passe doivent correspondre."

  @login
  Scenario: A anonymous user login to the website
    Given I'm on "/login" page
    Then I enter "Marco" in the "Nom d'utilisateur :" field
    Then I enter "Mysecretecode" in the "Mot de passe :" field
    When I click on button "Se connecter"
    Then the page should contain "Bienvenue sur Todo List"

  @login_fail
  Scenario: A anonymous user tries to login to the website and enter a wrong password
    Given I'm on "/login" page
    Then I enter "Marco" in the "Nom d'utilisateur :" field
    Then I enter "MyWrongPassword" in the "Mot de passe :" field
    When I click on button "Se connecter"
    Then the page should contain "Mot de passe incorrect !"
