<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/formulario")
 */
class FormularioController extends Controller
{
    /**
     * @Route("/simpleform")
     * @Template()
     */
    public function simpleformAction(Request $request)
    {
    	$form = $this->createFormBuilder()
    				->add('nombre','text')
    				->add('telefono', 'text', array(
    							'label'=>'Teléfono',
    							'required'=>false,
    							))
    				->add('fechanac', 'birthday', array('label'=>'Fecha de nacimiento'))
    				->add('sexo', 'choice', array(
    					'choices'=>array(
    						'masculino'=>'Masculino',
    						'femenino'=>'Femenino',
    						),
    					'expanded'=>true,
    					'multiple'=>true,
    					))
    				->add('observaciones','textarea')
    				->add('enviar', 'submit', array('label'=>'Guardar registro'))
    				->getForm();

    	$form->handleRequest($request);

    	$nombre = null;
    	if ($form->isValid())
    	{
    		$nombre = $form['nombre']->getData();
    	}

        return array(
        	'form' => $form->createView(),
        	'nombre'=>$nombre,
            );    
    }

}
