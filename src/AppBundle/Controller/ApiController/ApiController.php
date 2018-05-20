<?php


namespace AppBundle\Controller\ApiController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\Annotations\NamePrefix;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 * @Prefix("api-")
 * @NamePrefix("api-")
 */
class ApiController extends Controller 
{

    // /**
    //  * Liste des competences sous forme d'api
    //  * 
    //  * @Rest\View(serializerGroups={"competence"})
    //  * @Rest\Get("competences")
    //  */
    // public function getCompetencesAction(Request $request)
    // {
    //     // Récupération de l'entity manager
    //     $em = $this->getDoctrine()->getManager();
    //     // Récupération de toutes les entrées compétences
    //     $competences = $em->getRepository("AppBundle:Competence")->findAll();
    //     return $competences;
    // }

    // /**
    //  * Liste des diplomes sous forme d'api
    //  * @Rest\View(serializerGroups={"diplome"})
    //  * @Rest\Get("diplomes")
    //  */
    // public function getDiplomesAction()
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $diplomes = $em->getRepository("AppBundle:Diplome")->findAll();
    //     return $diplomes;
    // }

    // /**
    //  * Liste des Xp Pro sous forme d'api
    //  * 
    //  * @Rest\View(serializerGroups={"xpp"})
    //  * @Rest\Get("xpps")
    //  */
    // public function getXpProAction()
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $xpps = $em->getRepository("AppBundle:XpP")->findAll();
    //     return $xpps;
    // }

    // /**
    //  * Liste des loisirs sous forme d'api
    //  * @Rest\View(serializerGroups={"loisir"})
    //  * @Rest\Get("loisirs")
    //  */
    // public function getLoisirsAction()
    // {
    //     $em = $this->getDoctrine()->getManager();
    //     $loisirs = $em->getRepository("AppBundle:Loisir")->findAll();
    //     return $loisirs;
    // }

    /**
     * Liste des Categorie sous forme d'api
     * @Rest\View(serializerGroups={"categorie"})
     * @Rest\Get("categories")
     */
    public function getCategoriesAction(Request $request)
    {


        $categorie = ["categorie" => []];

        $data = $this->getDoctrine()->getRepository("AppBundle:Categorie")->findAll();

        foreach ($data as $key => $value) {

            $id = $value->getId();
            $title = $value->getTitle();

            $contenu = [];
            $host = $this->generateUrl('homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL) . "uploads/images/content/";

            foreach ($value->getContents() as $key => $tab) {

                $image = $tab->getBrochure();
                $lienComplet = $image ? $image = $host . $image : $image = "Aucune image n'a été ajouter";
                
                $contenues = [
                    "id" => $tab->getId(),
                    "title" => $tab->getTitle(),
                    "description" => $tab->getText(),
                    "note" => $tab->getNote(),
                    "dateStart" => $tab->getDateStart(),
                    "dateEnd" => $tab->getDateEnd(),
                    "categorie" => $tab->getCategorie()->getTitle(),
                    "createdAt" => $tab->getCreatedAt(),
                    "image" =>  $lienComplet

                ];
                array_push($contenu, $contenues);
            }

            $categories = [
                'id' => $id,
                'title' => $title,
                'contenu' => $contenu
            ];
            array_push($categorie['categorie'], $categories);

            
        }

        
        // $em = $this->getDoctrine()->getManager();
        // $categories = $em->getRepository("AppBundle:Categorie")->findAll();
        // Chemin absolu vers les asset 
        // $host = $this->generateUrl('homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL) . "uploads/images/content/";
        return $categorie;
    }
    
}