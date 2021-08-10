<?php

namespace Application\Controllers;

use Application\Entities\User;
use Application\Services\Doctrine;
use Twig\Environment;

class AuthController{

    protected Environment $twig;
    protected Doctrine $doctrine;

    public function __construct(Environment $twig, Doctrine $doctrine)
    {
        $this->twig = $twig;
        $this->doctrine = $doctrine;    
    }

    public function register()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $email    = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL);
            $username = filter_input(INPUT_POST,'username');
            $password = filter_input(INPUT_POST,'password');

            if(empty($email) OR empty($username) OR empty($password)){
                echo $this->twig->render("register.twig",[
                    "result" => false,
                    "post"   => $_POST,
                ]);
            }else{
                $user = new User;
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPassword(password_hash($password,PASSWORD_DEFAULT));
                $this->doctrine->em->persist($user);
                $this->doctrine->em->flush();

                $_SESSION["user_id"]  = $user->getId();
                $_SESSION["username"] = $username;
                $_SESSION["email"]    = $email;

                redirect("");
            }
            exit;
        }
        echo $this->twig->render("register.twig");
    }

    public function login()
    {
        if( $_SERVER['REQUEST_METHOD'] == 'POST'){

            $username = filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_SPECIAL_CHARS);

            if(!empty($username) OR !empty($password)){
                $user = $this->doctrine->em->getRepository(User::class)->findOneBy([
                    "username" => $username,
                ]);
                if(!empty($user)){
                    echo 'El usuario coincide';
                    if(password_verify($password, $user->getPassword())){
                        $_SESSION["user_id"]  = $user->getId();
                        $_SESSION["username"] = $username;
                        $_SESSION["email"]    = $user->getEmail();
                        redirect('');
                        exit;
                    }
                }
                echo 'El usuario no coincide';
            }
            echo $this->twig->render("login.twig",[
                "result" => false,
            ]);
            exit;
        }
        echo $this->twig->render("login.twig");
    }
}