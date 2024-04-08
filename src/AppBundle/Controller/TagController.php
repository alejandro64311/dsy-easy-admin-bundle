<?php

namespace AppBundle\Controller;

use dsarhoya\DSYEasyAdminBundle\Controller\EAdminController as EasyAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Post;
use AppBundle\Entity\Tag;

/**
 * Description of TagController
 *
 * @author mati
 */
class TagController extends EasyAdminController
{
    public function createNewEntity(){
        $post = $this->getDoctrine()->getRepository(Post::class)->find($this->request->query->get('parentEntityId'));
        $tag = new Tag();
        $tag->setPost($post);
        return $tag;
    }    
}
