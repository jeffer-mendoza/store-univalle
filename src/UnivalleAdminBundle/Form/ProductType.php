<?php
/**
 * Created by PhpStorm.
 * User: jeffer
 * Date: 11/03/16
 * Time: 05:01 PM
 */

namespace UnivalleAdminBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Clase usada para generar los formularios de las entidades para crear o editar un registro
 *
 * Class ProductType
 * @package UnivalleAdminBundle
 */
class ProductType extends AbstractType
{
    /**
     * Metodo principal para crear el tipo de formulario
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //se deben agregar cada uno de los campos de la entidad categoría
        $builder->add('name')//campo nombre
        ->add('price')//campo nombre
        ->add('description')//campo nombre
        ->add('save', SubmitType::class);//todos los fomularios deben tener el boton de enviar
    }

    /**
     * Todos los formtype necesitan una configuración interna,
     * por defecto solo debe ir la clase a la cual pertenece el
     * formulario, sin embargo existen muchas más opciones que pueden ser
     * configuradas
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UnivalleAdminBundle\Entity\Product',
        ));
    }

}