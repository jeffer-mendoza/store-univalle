<?php
/**
 * Created by PhpStorm.
 * User: jeffer
 * Date: 11/03/16
 * Time: 09:18 PM
 */

namespace UnivalleAdminBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use UnivalleAdminBundle\Entity\Product;
use UnivalleAdminBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductController
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * @Method("GET")
     * @Route("/",name="product_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("UnivalleAdminBundle:Product")->findAll();

        return array(
            'products' => $products
        );
    }

    /**
     * @Method("GET")
     * @Route("/{id}/show",name="product_show")
     * @Template()
     */
    public function showAction(Product $product)
    {

        return array(
            'product' => $product
        );
    }

    /**
     * @Method("GET")
     * @Route("/new",name="product_new")
     * @Template()
     */
    public function newAction()
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product, array(
            'action' => $this->generateUrl('product_create'),
            'method' => 'POST'
        ));

        return array(
            'form' => $form->createview(),
        );
    }

    /**
     * @Method("GET")
     * @Route("/{id}/edit",name="product_edit")
     * @Template()
     */
    public function editAction(Product $product)
    {
        $form = $this->createForm(ProductType::class, $product, array(
            'action' => $this->generateUrl('product_update', array('id' => $product->getId())),
            'method' => 'PUT'
        ));

        return array(
            'form' => $form->createview(),
        );
    }

    /**
     * @Route("/{id}/edit",name="product_update" )
     * @Method("PUT")
     * @Template()
     */
    public function updateAction(Request $request, Product $product)
    {
        $form = $this->createForm(ProductType::class, $product, array(
            'action' => $this->generateUrl('product_update', array('id' => $product->getId())),
            'method' => 'PUT'
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirect($this->generateUrl('product_show', array('id' => $product->getId())));
        }

        return array(
            'form' => $form->createView()
        );

    }

    /**
     * @Route("/create",name="product_create" )
     * @Method("POST")
     * @Template()
     */
    public function createAction(Request $request)
    {
        /**
         * se debe crear nuevamente el formulario para poder acceder a los datos que vienen
         * en la petición 'post'
         */
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product, array(
            'action' => $this->generateUrl('product_create'),
            'method' => 'POST'
        ));
        $form->handleRequest($request);//aqui se esta capturando los datos que se ingresaron en la vista
        if ($form->isSubmitted() && $form->isValid()) {//aqui se verifica que form sea válido(PREGUNTAR SOBRE ESTO EN CLASE)
            $em = $this->getDoctrine()->getManager();
            /**
             * internamente el objeto product, se le seteo los campos que fueron digitados en la vista
             * por lo tanto se le dice al doctrine que guarde en la base de datos.
             */
            $em->persist($product);//guardar en base de datos
            $em->flush();//realizar el commit en la base de datos
            return $this->redirect($this->generateUrl('product_index'));//redirigirme al metodo de mostrar todas las categorías
        }


        return array(
            'form' => $form->createview(),
        );
    }

}