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

To associate a media with an object, simply implements `MediaAssociableInterface`

    <?php
    ...
    use IDCI\Bundle\SimpleMediaBundle\Entity\MediaAssociableInterface;

    /**
     * Object
     */
    class MyObject implements MediaAssociableInterface
    {
        ...

Then when you wish to upload and associate a media, simply call the `idci_simplemedia.manager`
service to create a form and process it as explain below:

    // This classic form creation
    // $form = $this->createForm(new MyObjectType(), $myObject);

    // Now work lik this:
    $form = $this->get('idci_simplemedia.manager')->createForm(
        new MyObjectType(),
        $myObject,
        array('provider' => 'file')
    );

As you can see, the third parameter allow you to choose a provider. For the moment
only the file provider is ready to use.

To save and associate a media with your object, call the `processForm` function like this:

    if ($this->getRequest()->isMethod('POST')) {
        $form->bind($this->getRequest());
        if ($form->isValid()) {
            $myObject = $this->get('idci_simplemedia.manager')->processForm($form);
            return $this->redirect($this->generateUrl(...));
        }
    }

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

To remove a media in association with your object `$obj`, use the `removeAssociatedMedias`
function available throw the service like this:

    $this->get('idci_simplemedia.manager')->removeAssociatedMedias($obj);

VIEW
----

To display media in a twig template

    <!-- Related to an object -->
    <ul>
      {% for media in medias(object) %}
      <li><img src="{{ asset(media.url) }}" /></li>
      {% endfor %}
    </ul>

    <!-- Related to an object filter on tags -->
    <ul>
      {% for media in medias(object, ['tag']) %}
      <li><img src="{{ asset(media.url) }}" /></li>
      {% endfor %}
    </ul>

    <!-- Related to tags -->
    <ul>
      {% for media in medias_tag(['tag1', 'tag2']) %}
      <li><img src="{{ asset(media.url) }}" /></li>
      {% endfor %}
    </ul>

