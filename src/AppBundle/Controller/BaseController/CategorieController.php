<?php

namespace AppBundle\Controller\BaseController;

use AppBundle\Entity\Categorie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
/**
 * Categorie controller.
 *
 * @Route("categorie")
 * @Security("has_role('ROLE_USER') or has_role('ROLE_ADMIN')")
 */
class CategorieController extends Controller
{
    /**
     * Lists all categorie entities.
     *
     * @Route("/", name="categorie_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Categorie')->findAll();

        return $this->render('categorie/index.html.twig', array(
            'categories' => $categories,
        ));
    }


    /**
     * Displays a form to edit an existing categorie entity.
     *
     * @Route("/{id}/edit", name="categorie_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Categorie $categorie)
    {
        $editForm = $this->createForm('AppBundle\Form\CategorieType', $categorie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'successing',
                'La catégorie à bien été modifié'
            );

            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('categorie/edit.html.twig', array(
            'categorie' => $categorie,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Method for delete one of Categorie
     * @Route("/{id}/remove", name="categorie_remove")
     */
    public function removeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository("AppBundle:Categorie")->find($id);

        if ($categorie) {
            $em->remove($categorie);
            $em->flush();
            $this->addFlash(
                'successing',
                'La catégorie à bien été supprimer'
            );

        } else {
            $this->addFlash(
                'dangering',
                "La catégorie n'existe pas"
            );
        }
        return $this->redirectToRoute('homepage');
    }

}
