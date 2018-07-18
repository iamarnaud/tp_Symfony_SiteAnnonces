<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="app_home")
     * @Template("main/home.html.twig")
     */

    public function homeAction()
    {
//        return new Response(
//            "<!doctype html><html><body><h1> Welcome to my website</h1></body></html>"
//        );

//        return $this->render("main/home.html.twig", ["project_name" => "yourProject"]);

        return ["project_name" => "yourProject"];
    }
}