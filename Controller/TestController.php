<?php

namespace IDCI\Bundle\SimpleMediaBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use IDCI\Bundle\SimpleMediaBundle\Entity\Media;
use IDCI\Bundle\SimpleMediaBundle\Entity\Test;


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
        $obj = new Test();

        $media = new Media();
        $media->setName('test');
        $media->setDescription('desc test');
        $media->setWidth(800);
        $media->setHeight(600);
        $media->setLength(1024);
        $media->setSize(1024);
        $media->setContentType('TEST');
        $this->get('idci_simplemedia.manager')->addMedia($obj, $media, array('tag1', 'tag2'));
        die('Good or not ?');
    }
}
