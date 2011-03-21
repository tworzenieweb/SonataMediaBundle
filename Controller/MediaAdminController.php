<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\MediaBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\RedirectResponse;

class MediaAdminController extends Controller
{

    public function viewAction($id)
    {
        $media = $this->get('sonata.media.entity_manager')->find('Application\Sonata\MediaBundle\Entity\Media', $id);

        if (!$media) {
            throw new NotFoundHttpException('unable to find the media with the id');
        }

        return $this->render('SonataMediaBundle:MediaAdmin:view.html.twig', array(
            'media'     => $media,
            'formats'   => $this->get('sonata.media.pool')->getProvider($media->getProviderName())->getFormats(),
            'format'    => 'reference',
            'base_template' => $this->getBaseTemplate(),
            'admin'     => $this->admin
        ));
    }
  
    public function createAction($form = null)
    {

        $parameters = $this->admin->getPersistentParameters();
        
        if (!$parameters['provider']) {
            return $this->render('SonataMediaBundle:MediaAdmin:select_provider.html.twig', array(
                'providers'     => $this->get('sonata.media.pool')->getProviders(),
                'configuration' => $this->admin,
                'base_template' => $this->getBaseTemplate()
            ));
        }

        return parent::createAction($form);
    }
}