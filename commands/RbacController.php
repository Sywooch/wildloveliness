<?php
namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = Yii::$app->authManager;

        try {
            $authManager->removeAll();

            //create roles
            $guest = $authManager->createRole('guest');
            $manager = $authManager->createRole('manager');
            $admin = $authManager->createRole('admin');

            //create permissions
            $catIndex = $authManager->createPermission('cat index');
            $catCreate = $authManager->createPermission('cat create');
            $catView = $authManager->createPermission('cat view');
            $catUpdate = $authManager->createPermission('cat update');
            $catDelete = $authManager->createPermission('cat delete');

            $kittenIndex = $authManager->createPermission('kitten index');
            $kittenCreate = $authManager->createPermission('kitten create');
            $kittenView = $authManager->createPermission('kitten view');
            $kittenUpdate = $authManager->createPermission('kitten update');
            $kittenDelete = $authManager->createPermission('kitten delete');

            // add permissions in Yii::$app->authManager
            $authManager->add($catIndex);
            $authManager->add($catCreate);
            $authManager->add($catView);
            $authManager->add($catUpdate);
            $authManager->add($catDelete);
            $authManager->add($kittenIndex);
            $authManager->add($kittenCreate);
            $authManager->add($kittenView);
            $authManager->add($kittenUpdate);
            $authManager->add($kittenDelete);

            //add roles in Yii::$app->authManager
            $authManager->add($guest);
            $authManager->add($manager);
            $authManager->add($admin);

            //add permissions-per-role in Yii::$app->authManager
            // GUEST
            $authManager->addChild($guest, $catIndex);
            $authManager->addChild($guest, $catView);
            $authManager->addChild($guest, $kittenIndex);
            $authManager->addChild($guest, $kittenView);

            // MANAGER
            $authManager->addChild($manager, $catCreate);
            $authManager->addChild($manager, $catUpdate);
            $authManager->addChild($manager, $kittenCreate);
            $authManager->addChild($manager, $kittenUpdate);
            $authManager->addChild($manager, $guest);

            // ADMIN
            $authManager->addChild($admin, $catDelete);
            $authManager->addChild($admin, $kittenDelete);
            $authManager->addChild($admin, $manager);
        } catch (Yii\console\Exception $e) {
            throw new $e;
        }
    }

    public function actionAssign(){
        $authManager = Yii::$app->authManager;

        try {
            $manager = $authManager->getRole('manager');
            $admin = $authManager->getRole('admin');

            $userAdmin = User::findByUsername('admin');
            $userManager = User::findByUsername('manager');



            $authManager->assign($admin, $userAdmin->id); // user with ID = 1 gets 'admin' role
            $authManager->assign($manager, $userManager->id);
        } catch (Yii\console\Exception $e) {
            throw new $e;
        }
    }
}