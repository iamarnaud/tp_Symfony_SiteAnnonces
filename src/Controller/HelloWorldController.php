<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends Controller
{
    /**
     * @Route("/page", name="app_hello") //add this comment to annotations
     * @Template("main/page.html.twig")
     */

    public function helloAction(){
        return ["hello_name" => "une autre page" ];
    }
}
