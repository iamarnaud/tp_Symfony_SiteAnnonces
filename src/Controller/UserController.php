<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\Mailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends Controller
{
    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/signin", name="user.register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, Mailer $mailer)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user)->add("save", SubmitType::class, ["label" => "Register"]);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the user!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            //5) send a confirmation email
            $mailer->sendEmail($user); // sendEmail defini dans src/Service/Mailer.php

            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user.profil');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/profil", name="user.profil")
     */
    public function profil()
    {
        //on souhaite afficher le profil de l'utilisateur connecté
        $user = $this->getUser();

        return $this->render("user/profil.html.twig", ["user" => $user]);
    }

    /**
     * @Route("/user/update", name="user.update")
     */
    public function update(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        //on ne souhaite pas afficher le profil de tous les utilisateurs mais seulement du connecté
        $user = $this->getUser();
        $form = $this->createFormBuilder($user)
            ->add("username", TextType::class)
            ->add("email", EmailType::class)
            ->add("plainPassword", TextType::class)
            ->add("update", SubmitType::class, ["label" => "update Profil"])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new password
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            // Update the profile
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute("user.profil");
        }

        return $this->render("user/update.html.twig", ["form" => $form->createView()]);
    }
}