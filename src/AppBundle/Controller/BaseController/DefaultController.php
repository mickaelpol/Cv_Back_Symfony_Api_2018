<?php

namespace AppBundle\Controller\BaseController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Proxies\__CG__\AppBundle\Entity\Categorie;


/**
 * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository("AppBundle:Categorie")->findAll();

        return $this->render('default/index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * @Route("/new", name="categorie_create")
     * @Method({"POST"})
     */
    public function categorieAction(Request $request)
    {

        $categorie = $request->get('newCategorie');
        $object = new Categorie();
        $object->setTitle($categorie);

        if ($categorie) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($object);
            $em->flush();
            $this->addFlash(
                'successing',
                'La catégorie à bien été ajouter'
            );
        } else {
            $this->addFlash(
                'dangering',
                'Impossible d\'ajouter la catégorie'
            );
        }
        return $this->redirectToRoute('homepage');

    }
}
