<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\ProductRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="app_home")
     */
    public function showMine()
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $myProducts = $user->getProducts();

        return $this->render("main/home.html.twig", ["myProducts" => $myProducts]);
    }

}