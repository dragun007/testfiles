<?php
namespace console\controllers;

use common\models\File;
use frontend\rbac\AuthorRule;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public $id;

    public function options($actionID)
    {
        return ['id'];
    }

    public function optionAliases()
    {
        return ['id' => 'id'];
    }

    /**
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();

        $viewHalfPublicDocs = $auth->createPermission(FILE::VIEW_HALF_PUBLIC);
        $viewHalfPublicDocs->description = 'View half Public Docs';
        $auth->add($viewHalfPublicDocs);
        $viewPrivateDoc = $auth->createPermission(FILE::VIEW_PRIVATE_DOC);
        $viewPrivateDoc->description = 'View Private Doc';
        $auth->add($viewPrivateDoc);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $viewHalfPublicDocs);
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $viewPrivateDoc);
        $auth->addChild($admin, $user);
        $rule = new AuthorRule;
        $auth->add($rule);

        $viewOwnPrivateDoc = $auth->createPermission(FILE::VIEW_OWN_PRIVATE_DOC);
        $viewOwnPrivateDoc->ruleName = $rule->name;
        $auth->add($viewOwnPrivateDoc);

        $auth->addChild($viewOwnPrivateDoc, $viewPrivateDoc);
        $auth->addChild($user, $viewOwnPrivateDoc);
        $auth->assign($admin, $this->id);
    }
}