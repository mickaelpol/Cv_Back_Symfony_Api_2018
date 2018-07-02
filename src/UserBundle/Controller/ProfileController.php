<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Entity\User;
use Symfony\Component\Filesystem\Filesystem;


class ProfileController extends BaseController
{

    public function __construct()
    {
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
     * @Route("/profile-user", name="fos_user_override")
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        $comp = $this->getDoctrine()->getRepository("AppBundle:Categorie")->findAll();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $image = $user->getPhoto();
        $test = $em->getUnitOfWork();
        $originalData = $test->getOriginalEntityData($user);
        $originalImage = $originalData["photo"];

        if ($form->isSubmitted() && $form->isValid()) {

            if ($user->getPhoto() != null) {
                if ($originalImage) {
                    $fs = new Filesystem();
                    $old_file = $this->get('kernel')->getRootDir() . '/../web/uploads/images/profile/'. $originalImage;
                    $fs->remove($old_file);

                    $fileName = $this->generateUniqueFileName() . '.' . $user->getPhoto()->guessExtension();
                    $image->move(
                        $this->getParameter('image_profile'),
                        $fileName
                    );
                    $user->setPhoto($fileName);

                    $em->persist($user);
                    $em->flush();

                } else {
                    // J'enregistre la photo avec son contenu
                    $fileName = $this->generateUniqueFileName() . '.' . $user->getPhoto()->guessExtension();
                    $user->getPhoto()->move(
                        $this->getParameter('image_profile'),
                        $fileName
                    );
                    $user->setPhoto($fileName);
                    $em->persist($user);
                    $em->flush();
                }
            } else {
                $user->setPhoto($originalImage);
                $em->persist($user);
                $em->flush();
            }
            
            $this->addFlash(
                'successing',
                'Le contenu à bien été modifié'
            );


            return $this->redirectToRoute('fos_user_override');
        }
        
        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'categories' => $comp
        ));
    }
}