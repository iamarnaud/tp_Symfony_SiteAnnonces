<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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
    public function add(Request $request, FileUploader $fileUploader)
    {

        $user = $this->getUser();
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product)
            ->add("save", SubmitType::class, ["label" => "create Product"]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // on lie le produit à son user
            $product->setUser($user);
            // récupération de l'image
            $file = $form->get("photo")->getData();
            $fileName = $fileUploader->upload($file);
            $product->setPhoto($fileName);
            // traitement
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
    public function all()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository(Product::class)->findAll();
        dump($products);
        return $this->render("product/all.html.twig", ["products" => $products, "user" => $user]);
    }

    /**
     * @Route("/show/{product}", name="product.show")
     *
     */
    public function show(Product $product)
    {
        $user = $this->getUser();
        return $this->render("product/show.html.twig", ["product" => $product, "user" => $user]);
    }

    /**
     * @Route("/update/{product}", name="product.update")
     */
    public function update(Request $request, Product $product, FileUploader $fileUploader)
    {
        $form = $this->createForm(ProductType::class, $product)
            ->add("update", SubmitType::class, ["label" => "update Product"]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(
                'Alert',
                'Votre produit est mis à jour'
            );

            $file = $form->get("photo")->getData();
            $fileName = $fileUploader->upload($file);
            $product->setPhoto($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("product.all");
        }

        return $this->render("product/update.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/delete/{product}", name="product.delete")
     */
    public function delete(Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return $this->redirectToRoute("product.all");
    }

    /**
     * @param AuthorizationCheckerInterface $authChecker
     * @param Product $product
     * @Route("/moderate/{product}", name="product.moderate")
     */
    public function moderator(AuthorizationCheckerInterface $authChecker, Product $product)
    {
        // sur le site : show > dans url moderate à la place de show
        if ($authChecker->isGranted('ROLE_ADMIN')) {
            $this->addFlash(
                'Alert',
                'Vous êtes le moderateur'
            );
            // On passe le produit en "pas autorisé"
            $product->setAuthorized(false);
            // On change son status dans la base de données
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute("product.all");
        }
        // le produit n'est plus sur le site. Pour le faire revenir cocher dans base de données

        return $this->redirectToRoute("product.all");
    }
}