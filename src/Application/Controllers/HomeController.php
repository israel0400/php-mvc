<?php

namespace Application\Controllers;

use Application\Entities\Post;
use Application\Entities\User;
use Application\Services\Doctrine;
use Exception;
use Twig\Environment;

class HomeController{

    protected Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        if(empty($_SESSION)){
            redirect('login');
            exit; 
        }
    }

    public function index()
    {
        echo $this->twig->render("index.twig");
    }

    public function insert(Doctrine $doctrine)
    {
        try{

            $user = new User;
            $user->setEmail("acb@voztele.com.mx");
            $user->setPassword(password_hash("s0p0rt3", PASSWORD_DEFAULT));
            $user->setUsername("albertocasaos");
            // echo "<pre>";
            // var_dump($user);

            $doctrine->em->persist($user);
            $doctrine->em->flush();
            
            echo $this->twig->render("create.twig",[
                "username" => $user->getUsername(),
                "userid"   => $user->getId(),
            ]);
            // echo "El usuario {$user->getUsername()} con id {$user->getId()} se creo con exito";

        }catch(Exception $exception){
            echo $exception;
        }
    }

    public function users(Doctrine $doctrine)
    {
        $users = $doctrine->em->getRepository('Application\Entities\User')->findAll();
        echo $this->twig->render("users.twig",[
            "users" => $users
        ]); 
    }

    public function user(Doctrine $doctrine, $id)
    {
        $user = $doctrine->em->getRepository('Application\Entities\User')->find($id);
        if(!empty($user))
        {
            echo $this->twig->render("user.twig",[
                "user" => $user
            ]);
        }else{
            echo "El usuario con id $id no existe";
        }
        
    }

    public function update(Doctrine $doctrine, $id)
    {

        $user = $doctrine->em->find(User::class,$id);
        if(!empty($user)){
            $user->setEmail("update@voztele.com.mx");
            $doctrine->em->persist($user);
            $doctrine->em->flush();

            echo $this->twig->render("update.twig",[
                "username" => $user->getUsername(),
                "email"    => $user->getEmail(),
                "id"       => $user->getId()
            ]);
        }else{
            echo $this->twig->render("update.twig",[
                "message" => "Error",
                "id"      => $id
            ]);
        }
    }

    public function delete(Doctrine $doctrine, $id)
    {
        $user = $doctrine->em->find(User::class,$id);
        if(!empty($user)){
            $doctrine->em->remove($user);
            $doctrine->em->flush();
            echo $this->twig->render("delete.twig",[
                "result" => true
            ]);
            exit;
        }
        echo $this->twig->render("delete.twig",[
            "result" => false
        ]);
    }

    public function username(Doctrine $doctrine, $username)
    {
        $user = $doctrine->em->getRepository(User::class)
                ->getUserbyUsername($username);
        if(!empty($user)){
            echo $this->twig->render("username.twig",[
                "user" => $user,
            ]);
            exit;
        }
        echo "The user with username $username not exists";
    }

    public function newpost(Doctrine $doctrine, $id)
    {
        $user = $doctrine->em->find(User::class,$id);
        if(!empty($user)){
            try{
                $post = new Post;
                $post->setUser($user);
                $post->setTitle("Mi primer Post");
                $post->setBody("Este es el contenido de mi primer post con php moderno");
                $doctrine->em->persist($post);
                $doctrine->em->flush();
                echo $this->twig->render("newpost.twig",[
                    "post" => $post,
                    "user_id" => $id,
                ]);
            }catch(Exception $exception){
                echo $exception->getMessage();
            }
           
        }else{
            echo "The user with id $id not exists";
        }

    }

    public function postsbyuser(Doctrine $doctrine, $id)
    {
        $user = $doctrine->em->find(User::class,$id);
        if(!empty($user)){
            echo $this->twig->render("postsbyuser.twig",[
                "posts" => $user->getPosts(),
            ]);
        }
    }
}