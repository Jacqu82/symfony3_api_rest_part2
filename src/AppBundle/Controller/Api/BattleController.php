<?php

namespace AppBundle\Controller\Api;

use AppBundle\Controller\BaseController;
use AppBundle\Form\BattleType;
use AppBundle\Form\Model\BattleModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BattleController extends BaseController
{
    /**
     * @Route("/api/battles")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $battleModel = new BattleModel();
        $form = $this->createForm(BattleType::class, $battleModel);
        $this->processForm($request, $form);

        if (!$form->isValid()) {
            $this->throwApiProblemValidationException($form);
        }

        $battle = $this->getBattleManager()->battle(
            $battleModel->getProgrammer(),
            $battleModel->getProject()
        );

        //todo set Location Header
        return $this->createApiResponse($battle, 201);
    }
}
