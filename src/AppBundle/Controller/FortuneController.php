<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FortuneController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     * @return Response
     */
    public function homepageAction(Request $request)
    {

        $categoryRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category');

        $search = $request->query->get('q');
        if($search){
            $categories = $categoryRepository->search($search);
        } else {
            $categories = $categoryRepository->findAllOrdered();
        }

        return $this->render('fortune/homepage.html.twig',[
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function showCategoryAction($id)
    {
        $categoryRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('AppBundle:Category');

        $category = $categoryRepository->findWithFortunesJoin($id);

        if (!$category) {
            throw $this->createNotFoundException();
        }

        $fortunesData = $this->getDoctrine()
            ->getRepository('AppBundle:FortuneCookie')
            ->countNumberPrintedForCategory($category);

        return $this->render('fortune/showCategory.html.twig',[
            'category' => $category,
            'fortunesPrinted' => $fortunesData['fortunesPrinted'],
            'averagePrinted' => $fortunesData['fortunesAverage'],
            'categoryName' => $fortunesData['name']
        ]);
    }
}
