<?php

namespace UnivalleAdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UnivalleAdminBundle\Entity\Category;
use UnivalleAdminBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * Lists all Category entities.
     *
     * @Route("/", name="category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('UnivalleAdminBundle:Category')->findAll();

        return $this->render('UnivalleAdminBundle:Category:index.html.twig', array(
            'categories' => $categories,
        ));
    }

    /**
     * Finds and displays a Category entity.
     *
     * @Route("/{id}/show", name="category_show")
     * @Method("GET")
     */
    public function showAction(Category $category)
    {

        return $this->render('UnivalleAdminBundle:Category:show.html.twig', array(
            'category' => $category,
        ));
    }

    /**
     * Este método controla la creación de una nueva categoria
     *
     * Algoritmo:
     *
     *  Metodo GET (mostrar el formulario en la vista)
     *  1. crear objeto categoria
     *  2. crear formularia
     *  2. enviar formulario a la vista
     *
     * @Route("/new", name="category_new")
     * @Method("GET")
     */
    public function newAction()
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, array(
            'action' => $this->generateUrl('category_create'),
            'method' => 'POST'
        ));

        return $this->render('UnivalleAdminBundle:Category:new.html.twig', array(
            'form' => $form->createview(),
        ));
    }

    /**
     * Este método controla la persistencia de una nueva categoría
     *
     * Algoritmo:
     *
     *  Metodo POST (mostrar el formulario en la vista)
     *  1. Obtiene los datos que provienen de la petición
     *  2. crea el manager
     *  2. invoca el metodo del manager para guardar en la bd
     *
     * @Route("/create", name="category_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        /**
         * se debe crear nuevamente el formulario para poder acceder a los datos que vienen
         * en la petición 'post'
         */
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, array(
            'action' => $this->generateUrl('category_create'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);//aqui se esta capturando los datos que se ingresaron en la vista
        if ($form->isSubmitted() && $form->isValid()) {//aqui se verifica que form sea válido(PREGUNTAR SOBRE ESTO EN CLASE)
            $em = $this->getDoctrine()->getManager();
            /**
             * internamente el objeto category, se le seteo los campos que fueron digitados en la vista
             * por lo tanto se le dice al doctrine que guarde en la base de datos.
             */
            $em->persist($category);//guardar en base de datos
            $em->flush();//realizar el commit en la base de datos
            return $this->redirect($this->generateUrl('category_index'));//redirigirme al metodo de mostrar todas las categorías
        }


        return $this->render('UnivalleAdminBundle:Category:new.html.twig', array(
            'form' => $form->createview(),
        ));
    }


}
