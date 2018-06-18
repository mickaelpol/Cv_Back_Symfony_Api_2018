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

        /**
         * Si la requête est une requête Ajax
         */
        if($request->isXmlHttpRequest()){
            /**
             * Si la valeur dans l'input est vide j'encode un message d'erreur en json
             * je renvoi un header de type Json
             * et un code d'erreur 400
             */
            if (empty($request->get('newCategorie'))) {
                echo json_encode(['error' => " <span class='fa fa-warning'></span> Vous n'avez pas saisie de texte"]);
                header('Content-Type: application/json');
                http_response_code(400);
                die();
            /**
             * Sinon si la valeur dans l'input est renseigné 
             * J'encode la valeur du champ en Json
             * Je renvoi un header de type json aussi et un code de type 200 pour dire que tout c'est bien passé 
             */
            } else {
                $categorie = $request->get('newCategorie');
                $validation = $this->addFlash(
                    'successing',
                    'La catégorie à bien été ajouter'
                );
                echo json_encode([$validation, "valid" => "<span class='fa fa-check'></span> Enregistrement redirection en cours"]);
                header('Content-Type: application/json');
                http_response_code(200);
                $categorie = $request->get('newCategorie');
                $object = new Categorie();
                $object->setTitle($categorie);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($object);
                $em->flush();
                die();
            }
        }
            

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
