<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\ProductType;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{
    /**
     *@Route("/search", name="product.search")
     */
    public function search(Request $request, ProductRepository $productRepository, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $search = new Search();

        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $productRepository->getSearchByKeywordsAndLocalisationAndCategory($search, $em);

            return $this->render("search/result.html.twig", ["products" => $products, "user" => $user]);
        }

        return $this->render("search/search.html.twig", ["form" => $form->createView()]);
    }

    /**
     *@Route("/result", name="product.result")
     */
    public function result() {

        return $this->render("search/result.html.twig", ["form" => $form->createView]);
    }
}


// Que fait chaque champ de recherche ?
// Où s'affichent les résultats ? => result.html.twig