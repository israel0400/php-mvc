<?php

namespace Application\Controllers;

use Twig\Environment;

class DashboardController{

    protected Environment $twig;


    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        if(!empty($_SESSION)){
            echo $this->twig->render("dashboard.twig",[
                "session" => $_SESSION,
            ]);
            exit;
        }
        
        redirect("login");
    }

    public function logout()
    {
        session_destroy();
        redirect("login");
    }
}