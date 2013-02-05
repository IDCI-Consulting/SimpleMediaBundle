<?php

namespace IDCI\Bundle\SimpleMediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use IDCI\Bundle\SimpleMediaBundle\Entity\Media;
use IDCI\Bundle\SimpleMediaBundle\Entity\Test;
use IDCI\Bundle\SimpleMediaBundle\Form\TestType;

/**
 * Test controller.
 *
 * @Route("/test-media")
 */
class TestController extends Controller
{
    /**
     * @Route("/", name="test")
     * @Template()
     */
    public function indexAction()
    {
        $tests = $this->getDoctrine()
            ->getRepository('IDCISimpleMediaBundle:Test')
            ->findAll()
        ;

        return array('tests' => $tests);
    }

    /**
     * @Route("/get", name="test_get")
     * @Template()
     */
    public function getAction()
    {
        $obj = new Test();

        $medias = $this->get('idci_simplemedia.manager')->getMedias($obj, array('tag2'));

        foreach($medias as $media) {
            var_dump($media->getName());
        }

        die('Good or not ?');
    }

    /**
     * @Route("/getbytags", name="test_getbytags")
     * @Template()
     */
    public function getByTagsAction()
    {
        $medias = $this->get('idci_simplemedia.manager')->getMedias(null, array('tag4'));

        foreach($medias as $media) {
            var_dump($media->getName());
        }

        die('Good or not ?');
    }

    /**
     * @Route("/create", name="createform")
     * @Template()
     */
    public function createAction()
    {
        $test = new Test();
        //$form = $this->createForm(new TestType(), $test);

        $form = $this->get('idci_simplemedia.manager')->createForm(
            new TestType(),
            $test,
            array('provider' => 'file')
        );

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $test = $this->get('idci_simplemedia.manager')->processForm($form);
                return $this->redirect($this->generateUrl('test'));
            }
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/edit/{id}", name="editform")
     * @Template()
     */
    public function editAction($id)
    {
        $test = $this->getDoctrine()
            ->getRepository('IDCISimpleMediaBundle:Test')
            ->findOneBy(array('id' => $id))
        ;

        if (!$test) {
            throw $this->createNotFoundException('Unable to find test entity.');
        }

        //$form = $this->createForm(new TestType(), $test);
        $form = $this->get('idci_simplemedia.manager')->createForm(
            new TestType(),
            $test,
            array('provider' => 'file')
        );

        if ($this->getRequest()->isMethod('POST')) {
            $form->bind($this->getRequest());
            if ($form->isValid()) {
                $test = $this->get('idci_simplemedia.manager')->processForm($form);
                return $this->redirect($this->generateUrl('test'));
            }
        }

        return array(
            'test' => $test,
            'form' => $form->createView(),
        );
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $test = $this->getDoctrine()
            ->getRepository('IDCISimpleMediaBundle:Test')
            ->findOneBy(array('id' => $id))
        ;

        if (!$test) {
            throw $this->createNotFoundException('Unable to find test entity.');
        }

        $em = $this->getDoctrine()->getManager();

        $this->get('idci_simplemedia.manager')->removeAssociatedMedias($test);
        $em->remove($test);
        $em->flush();

        return $this->redirect($this->generateUrl('test'));
    }

    /**
     * @Route("/deletemedia/{id}", name="deletemedia")
     * @Template()
     */
    public function deleteMediaAction($id)
    {
        $media = $this->getDoctrine()
            ->getRepository('IDCISimpleMediaBundle:Media')
            ->findOneBy(array('id' => $id))
        ;

        if (!$media) {
            throw $this->createNotFoundException('Unable to find media entity.');
        }

        $em = $this->getDoctrine()->getManager();

        $this->get('idci_simplemedia.manager')->removeMedia($media);

        return $this->redirect($this->generateUrl('test'));
    }
}
