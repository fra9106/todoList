<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * $manager construct
     *
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/users", name="user_list")
     */
    public function userList(UserRepository $UserRepository)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        return $this->render('user/list.html.twig', [
            'users' => $UserRepository->findAll()
        ]);
    }

    /**
     * @Route("/users/create", name="user_create")
     */
    public function userCreate(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        
            $this->addFlash('success', "L'utilisateur a bien été ajouté.");
            return $this->redirectToRoute('login');

            

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/users/{id}/edit", name="user_edit")
     */
    public function userEdit(User $user, Request $request, UserPasswordEncoderInterface $encoder)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        
            $this->addFlash('success', "L'utilisateur a bien été modifié");

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(), 
            'user' => $user
        ]);
    }

    /**
     * @Route("/users/{id}/delete", name="user_delete")
     */
    public function userDelete(User $user)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $this->getDoctrine()->getManager();
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a bien été supprimée.');

        return $this->redirectToRoute('user_list');
    }
}
