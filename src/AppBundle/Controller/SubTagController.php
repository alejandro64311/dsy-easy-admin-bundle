<?php

namespace AppBundle\Controller;

use dsarhoya\DSYEasyAdminBundle\Controller\EAdminController as EasyAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Tag;
use AppBundle\Entity\SubTag;

/**
 * Description of SubTagController
 *
 * @author mati
 */
class SubTagController extends EasyAdminController
{
    public function createNewEntity(){
        $tag = $this->getDoctrine()->getRepository(Tag::class)->find($this->request->query->get('parentEntityId'));
        $subTag = new SubTag();
        $subTag->setTag($tag);
        return $subTag;
    }    
}
