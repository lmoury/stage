<?php

namespace App\Controller\Backend;

use App\Repository\UserRepository;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
class UserController extends AbstractController
{

    private $current_url = 'user';

    /**
     * @var UserRepository
     */
    private $repository;


    public function __construct(ObjectManager $em, UserRepository $repository)
    {
            $this->em = $em;
            $this->repository = $repository;
    }


    /**
     * @Route("/admin/utilisateur", name="admin.utilisateur.index")
     * @param UserRepository $repository
     */
    public function index()
    {
        $users = $this->repository->findAll();
        return $this->render('backend/utilisateur/index.html.twig', [
            'current_url' => $this->current_url,
            'users' => $users,
        ]);
    }


    /**
   * @Route("/admin/utilisateur/new", name="admin.utilisateur.new")
   * @param UserPasswordEncoderInterface $encoder
   * @param Request $request
   */
   public function new(UserPasswordEncoderInterface $encoder, Request $request)
   {

       $user = new User();
       $form = $this->createForm(UserType::class, $user);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
           $user->setPassword($encoder->encodePassword($user, $request->request->get('user')['password']));
           $this->em->persist($user);
           $this->em->flush();
           $this->addFlash('success', 'L\'utilisateur <strong>'.$user->getUsername().'</strong> à été ajouté');
           return $this->redirectToRoute('admin.utilisateur.index');
       }

       return $this->render('backend/utilisateur/new.html.twig', [
           'current_url' => $this->current_url,
           'form' => $form->createView()
       ]);
   }


   /**
    * @Route("/admin/utilisateur/editer.{id}", name="admin.utilisateur.editer", methods="GET|POST")
    * @param User $user
    * @param Request $request
    */
    public function editer(User $user, Request $request)
    {

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user->setDateEdition(new \DateTime());
            $this->em->flush();
            $this->addFlash('success', 'L\'utilisateur <strong>'.$user->getUsername().'</strong> à été modifié');
            return $this->redirectToRoute('admin.utilisateur.index');
        }

        return $this->render('backend/utilisateur/editer.html.twig', [
            'current_url' => $this->current_url,
            'form' => $form->createView(),
            'user' => $user
        ]);
    }


    /**
    * @Route("/admin/utilisateur/delete.{id}", name="admin.utilisateur.delete", methods="DELETE")
    * @param User $user
    * @param Request $request
    */
    public function delete(User $user, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))) {
            $this->em->remove($user);
            $this->em->flush();
            $this->addFlash('success', 'L\'utilisateur <strong>'.$user->getUsername().'</strong> à été supprimé');
        }
        return $this->redirectToRoute('admin.utilisateur.index');
    }

}
