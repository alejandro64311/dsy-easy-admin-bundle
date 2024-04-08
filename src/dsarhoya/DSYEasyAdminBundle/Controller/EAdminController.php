<?php

namespace dsarhoya\DSYEasyAdminBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use dsarhoya\BaseBundle\Services\UserKeysService;
use dsarhoya\BaseBundle\Services\UserManagementService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Description of EAdminController.
 *
 * @author mati <matias.castro@dsarhoya.cl>
 */
class EAdminController extends EasyAdminController
{
    const FLASH_TYPE_INFO = 'info';
    const FLASH_TYPE_SUCCESS = 'success';
    const FLASH_TYPE_ERROR = 'error';
    const FLASH_TYPE_WARNING = 'warning';

    /**
     * @Route("/{id}/send-validation-email", name="dsy_easy_admin_send_validation_email")
     * @Method("GET")
     *
     * @param int $user
     */
    public function sendValidationEmailAction(Request $request, $id, UserKeysService $userKeysSrv, UserManagementService $userManagementSrv, TranslatorInterface $translator)
    {
        $classes = $this->getParameter('dsarhoya_base.classes');
        $repo = $this->getDoctrine()->getManager()->getRepository($classes['user']['class']);
        $user = $repo->find($id);

        if ($userKeysSrv->sendAccountValidationEmail($user)) {
            $this->addFlash(self::FLASH_TYPE_SUCCESS, $translator->trans('success.account_validation_email_sent'));
        } else {
            $this->addFlash(self::FLASH_TYPE_ERROR, $userManagementSrv->getErrorsAsString());
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Modify QueryBuilder function.
     *
     * @param QueryBuilder $queryBuilder
     */
    protected function modifyQueryBuilder(&$queryBuilder)
    {
        if ($this->request->query->has('parentEntityId') && $this->request->query->has('parentEntityName')) {
            $config = $this->getParameter('easyadmin.config');
            $entityConfig = $config['entities'][$this->request->query->get('parentEntityName')];
            if (isset($entityConfig['dsy']['children_dql_filter'])) {
                $queryBuilder->andWhere(str_replace('{parentId}', $this->request->query->get('parentEntityId'), $entityConfig['dsy']['children_dql_filter']));
            } else {
                $class = explode('\\', $entityConfig['class']);
                $class = array_pop($class);
                $queryBuilder->andWhere('entity.'.lcfirst($class).' = :parentEntity')->setParameter('parentEntity', $this->request->query->get('parentEntityId'));
            }
        }
    }

    protected function createListQueryBuilder($entityClass, $sortDirection, $sortField = null, $dqlFilter = null)
    {
        $queryBuilder = parent::createListQueryBuilder($entityClass, $sortDirection, $sortField, $dqlFilter);
        $this->modifyQueryBuilder($queryBuilder);

        return $queryBuilder;
    }

    protected function createSearchQueryBuilder($entityClass, $searchQuery, array $searchableFields, $sortField = null, $sortDirection = null, $dqlFilter = null)
    {
        $queryBuilder = parent::createSearchQueryBuilder($entityClass, $searchQuery, $searchableFields, $sortField, $sortDirection, $dqlFilter);
        $this->modifyQueryBuilder($queryBuilder);

        return $queryBuilder;
    }

    /**
     * get Parent Entity.
     *
     * @param string $parentEntityName
     * @param int    $parentEntityId
     *
     * @return mixed
     */
    protected function getParentEntity($parentEntityName, $parentEntityId)
    {
        return $this->em->getRepository("AppBundle\\Entity\\{$parentEntityName}")->find($parentEntityId);
    }
}
