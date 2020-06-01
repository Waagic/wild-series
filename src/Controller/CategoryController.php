<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 *Class CategoryController !
 * @package App\Controller
 * @Route("/wild/category", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     * @return Response A response instance
     */
    public function add(Request $request):Response
    {
        $categories=$this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $categoryManager = $this->getDoctrine()->getManager();
            $categoryManager->persist($category);
            $categoryManager->flush();

            return $this->redirectToRoute('category_add');
        }

        return $this->render('wild/addCategory.html.twig', [
            'categories' => $categories,
            'form' => $form->createView()
        ]);
    }
}