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
     * index
     *
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
     * get
     *
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
     * getbytags
     *
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
     * displayForm
     *
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
}
