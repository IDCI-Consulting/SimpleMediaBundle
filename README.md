SimpleMediaBundle
=================

Symfony2 simple media bundle


Instalation
===========

To install this bundle please follow the next steps:

First add the dependencies to your `composer.json` file:

    "require": {
        ...
        "idci/simple-media-bundle":     "dev-master"
    },

Then install the bundle with the command:

    php composer update

Enable the bundle in your application kernel:

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new IDCI\Bundle\SimpleMediaBundle\IDCISimpleMediaBundle()
        );
    }

Now the Bundle is installed.


How to create a Media
=====================




How to retrive and display medias
=================================

Controller
----------

In the following exemples, `$obj` has to be an instance of a class which implement
the `MediaAssociableInterface`. So to retrieve a set of media:

    // Related to an object
    $medias = $this->get('idci_simplemedia.manager')->getMedias($obj);
    
    // Related to an object filter on tags
    $medias = $this->get('idci_simplemedia.manager')->getMedias($obj, array('tag1', 'tag2'));
    
    // Related to tags
    $medias = $this->get('idci_simplemedia.manager')->getMedias(null array('tag1', 'tag2'));

VIEW
----

To display media in a twig template

