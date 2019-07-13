<?php
namespace frontend\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

// add the rule
        $rule = new \frontend\rbac\AuthorRule;
        $auth->add($rule);

// add the "updateOwnPost" permission and associate the rule with it.
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = 'Update own post';
        $updateOwnPost->ruleName = $rule->name;
        $auth->add($updateOwnPost);

// "updateOwnPost" will be used from "updatePost"
        $auth->addChild($updateOwnPost, $updatePost);

// allow "author" to update their own posts
        $auth->addChild($author, $updateOwnPost);
    }
}
