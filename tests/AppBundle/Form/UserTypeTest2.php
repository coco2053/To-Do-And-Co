<?php

namespace AppBundle\Tests\Form;

use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;

class UserTypeTest extends TypeTestCase
{
    protected function getExtensions()
    {
        $validator = Validation::createValidator();

        // or if you also need to read constraints from annotations
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        return [
            new ValidatorExtension($validator),
        ];
    }

    public function testSubmitValidDataUser()
    {
        $formData = array(
            'roles' => ['ROLE_ADMIN'],
            'username' => 'testUser',
            'password' => array('first' => 'test', 'second' => 'test'),
            'email' => 'test@gmail.com'
        );
        $form = $this->factory->create(UserType::class);
        $user = new User();
        $user->setRoles($formData['roles']);
        $user->setUsername($formData['username']);
        $user->setPassword($formData['password']);
        $user->setEmail($formData['email']);

        // submit the data to the form directly
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($user->getRoles(), $form->get('roles')->getData());
        $this->assertEquals($user->getUsername(), $form->get('username')->getData());
        $this->assertEquals($user->getPassword(), $form->get('password')->getData());
        $this->assertEquals($user->getEmail(), $form->get('email')->getData());
        $view = $form->createView();
        $children = $view->children;
        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
