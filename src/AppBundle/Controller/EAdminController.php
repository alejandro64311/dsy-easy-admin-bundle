<?php

namespace AppBundle\Controller;

use dsarhoya\DSYEasyAdminBundle\Controller\EAdminController as EasyAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Tag;

/**
 * Description of EAdminController
 *
 * @author mati
 */
class EAdminController extends EasyAdminController
{
    public function createNewEntity(){
        dump(1);die;
    }
}
