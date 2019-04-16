# Guide de l'authentification

L'utilisateur est représenté par la classe AppBundle\Entity\User.
Une contrainte d'unicité est appliquée à l'attribut email afin de ne pas avoir de doublon.

```php
# src/AppBundle/Entity/User.php
/**
 * Class User
 *
 * @ORM\Table("user")
 * @ORM\Entity
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
```

La sécurité de l'application est configurée dans le fichier app/config/security.yml.
Les utilisateurs sont enregistrés en BDD par doctrine.
L'utilisateur est authentifié par l’attribut username :

```yaml
# app/config/security.yml
    providers:
        doctrine:
            entity:
                class: AppBundle:User
                property: username
```

Un pare-feu est désigné afin d'empêcher un utilisateur non authentifié d’accéder à certaines parties du site. Pour s'authentifier, on utilise un formulaire accessible à la route login :

```yaml
# app/config/security.yml
    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false

        main:
            logout_on_user_change: true
            anonymous: true
            provider: doctrine
            form_login:
                login_path: login
                check_path: login
                default_target_path:  /
                username_parameter: username
                password_parameter: password
```
On permet à l'utilisateur anonyme d’accéder à cette route grâce au paramètre access_control :

```yaml
# app/config/security.yml
    access_control:
        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/users/create, roles: IS_AUTHENTICATED_ANONYMOUSLY }
        - { path: ^/users, roles: ROLE_ADMIN }
        - { path: ^/, roles: [ROLE_ADMIN, ROLE_USER]}
```

L’accès au formulaire de création d'un utilisateur est également laissé libre.
Par contre, l’accès à la gestion des utilisateurs est réservée aux membres possédant le rôle : ROLE_ADMIN.
A noter que ce système d’autorisation est affiné grâce à l'utilisation des voters dans les contrôleurs :

```php
// src/AppBundle/Controller/TaskController.php
    public function editAction(Task $task, Request $request, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('EDIT', $task);
```
Dans ce cas, une tâche ne peut être modifiée que par son auteur :

```php
// src/AppBundle/Security/TaskVoter.php

        switch ($attribute) {
            case 'EDIT':
                $role = $user->getRoles();
                if ($user == $task->getUser()) {
                    return true;
                }
```
On utilise un authenticator personnalisé pour le login :

```yaml
# app/config/security.yml
            guard:
                authenticators:
                    - AppBundle\Security\LoginFormAuthenticator
```
Cela permet d'avoir des messages d'erreur précis en cas de problème de login :

```php
// src/AppBundle/Security/LoginFormAuthenticator.php

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $credentials[
            'username']]);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Cet utilisateur n\'est pas enregistré.');
        }
```

On permet l'affichage des ces erreurs dans la méthode de login dans le SecurityController :

```php
// src/AppBundle/Controller/SecurityController.php
    public function loginAction(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
```
