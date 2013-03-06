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

Include a resource in your `config.yml`

    imports:
        ....
        - { resource: @IDCISimpleMediaBundle/Resources/config/config.yml }

Now the Bundle is installed.

Configure your database parameters in the `app/config/parameters.yml` then run

    php app/console doctrine:schema:update --force


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

    // Now work like this:
    $form = $this->get('idci_simplemedia.manager')->createForm(
        new MyObjectType(),
        $myObject,
        array('provider' => 'file')
    );

As you can see, the third parameter allow you to choose a provider.
*For the moment only the file provider is ready to use.*

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

To remove all medias in association with your object `$obj`, use the `removeAssociatedMedias`
function available throw the service like this:

    $this->get('idci_simplemedia.manager')->removeAssociatedMedias($obj);
    $this->getDoctrine()->getManager()->flush();

To remove just one media:

    $this->get('idci_simplemedia.manager')->removeMedia($media);
    $em->flush();

VIEW
----

To display media in a twig template

    <!-- Related to an object -->
    <ul>
      {% for media in medias(object) %}
      <li><img src="{{ media.url }}" /></li>
      {% endfor %}
    </ul>

    <!-- Related to an object filter on tags -->
    <ul>
      {% for media in medias(object, ['tag']) %}
      <li><img src="{{ media.url }}" /></li>
      {% endfor %}
    </ul>

    <!-- Related to tags -->
    <ul>
      {% for media in medias(null, ['tag1', 'tag2']) %}
      <li><img src="{{ media.url }}" /></li>
      {% endfor %}
    </ul>


How to retrive and display medias tags
======================================

Controller
----------

In the following exemples, `$obj` has to be an instance of a class which implement
the `MediaAssociableInterface`. So to retrieve a set of media:

    // All tags
    $tags = $this->get('idci_simplemedia.manager')->getTags();

    // Related to an object
    $tags = $this->get('idci_simplemedia.manager')->getTags($obj);

VIEW
----

To retrieve tags in a twig template

    <!-- All -->
    <ul>
      {% for tag in medias_tags %}
      <li>{{ tag }}</li>
      {% endfor %}
    </ul>

    <!-- Related to a media -->
    <ul>
      {% for tag in medias_tags(object) %}
      <li>{{ tag }}</li>
      {% endfor %}
    </ul>