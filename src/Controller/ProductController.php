<?php

namespace App\Controller;

use App\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package App\Controller
 * @Route("/product")
 */

class ProductController extends Controller
{
    /**
     * @Route("/add", name="product.add")
     */
    public function add(Request $request)
    {
        $product = new Product();
        $form = $this->createFormBuilder($product)
            ->add("name", TextType::class)
            ->add("releaseOn", DateType::class, [
                "widget" => "single_text"
            ])
            ->add("save", SubmitType::class, ["label" => "create Product"])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() &&  $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute("product.all");
        }

        return $this->render("product/add.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/all", name="product.all")
     */
    public function all() {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findAll();
        return $this->render("product/all.html.twig",["products" => $products]);
    }

    /**
     * @Route("/product/show/{product}", name="product.show")
     */
    public function show(Product $product) {

    }

    /**
     * @Route("/product/update/{product}", name="product.update")
     */
    public function update(Product $product) {

    }

    /**
     * @Route("/product/delete/{product}", name="product.delete")
     */
    public function delete(Product $product) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute("product.all");
    }
}