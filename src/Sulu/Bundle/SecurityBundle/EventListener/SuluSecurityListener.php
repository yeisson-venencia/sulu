<?php
/*
 * This file is part of the Sulu CMF.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SecurityBundle\EventListener;

use Sulu\Component\Security\Authorization\AccessControl\SecuredObjectControllerInterface;
use Sulu\Component\Security\Authorization\SecurityCheckerInterface;
use Sulu\Component\Security\Authorization\SecurityCondition;
use Sulu\Component\Security\SecuredControllerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Listens on the kernel.controller event and checks if Sulu allows this action
 * @package Sulu\Bundle\SecurityBundle\EventListener
 */
class SuluSecurityListener
{
    /**
     * @var SecurityCheckerInterface
     */
    private $securityChecker;

    public function __construct(SecurityCheckerInterface $securityChecker)
    {
        $this->securityChecker = $securityChecker;
    }

    /**
     * Checks if the action is allowed for the current user, and throws an Exception otherwise
     * @param FilterControllerEvent $event
     * @throws AccessDeniedException
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (
            !$controller[0] instanceof SecuredControllerInterface &&
            !$controller[0] instanceof SecuredObjectControllerInterface
        ) {
            return;
        }

        $request = $event->getRequest();

        // find appropriate permission type for request
        $permission = '';

        switch ($event->getRequest()->getMethod()) {
            case 'GET':
                $permission = 'view';
                break;
            case 'POST':
                if ($controller[1] == 'postAction') { // means that the ClassResourceInterface has to be used
                    $permission = 'add';
                } else {
                    $permission = 'edit';
                }
                break;
            case 'PUT':
            case 'PATCH':
                $permission = 'edit';
                break;
            case 'DELETE':
                $permission = 'delete';
                break;
        }

        $securityContext = null;
        $locale = $controller[0]->getLocale($event->getRequest());
        $objectType = null;
        $objectId = $request->get('id') ?: $request->get('uuid');

        if ($controller[0] instanceof SecuredObjectControllerInterface && $objectId) {
            $objectType = $controller[0]->getSecuredClass();
        }

        // check permission
        if ($controller[0] instanceof SecuredControllerInterface) {
            $securityContext = $controller[0]->getSecurityContext();
        }

        $this->securityChecker->checkPermission(
            new SecurityCondition($securityContext, $locale, $objectType, $objectId),
            $permission
        );
    }
} 
