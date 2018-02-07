<?php
namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        try {
            $auth->removeAll();

            //create roles
            $user = $auth->createRole('user');
            $user->description = 'Пользователь';
            $manager = $auth->createRole('manager');
            $manager->description = 'Менеджер';
            $admin = $auth->createRole('admin');
            $admin->description = 'Администратор';

            //add roles in Yii::$app->authManager
            $auth->add($user);
            $auth->add($manager);
            $auth->add($admin);

            //create permissions
            $viewPet = $auth->createPermission('viewPet');
            $viewPet->description = 'Просматривать питомцев';

            $createPet = $auth->createPermission('createPet');
            $createPet->description = 'Создавать питомцев';

            $updatePet = $auth->createPermission('updatePet');
            $updatePet->description = 'Редактировать питомцев';

            $deletePet = $auth->createPermission('deletePet');
            $deletePet->description = 'Удалять питомцев';

            $viewUser = $auth->createPermission('viewUser');
            $viewUser->description = 'Просматривать пользователей';

            $createUser = $auth->createPermission('createUser');
            $createUser->description = 'Создавать пользователей';

            $updateUser = $auth->createPermission('updateUser');
            $updateUser->description = 'Редактировать пользователей';

            $deleteUser = $auth->createPermission('deleteUser');
            $deleteUser->description = 'Удалять пользователей';

            // add permissions in Yii::$app->authManager
            $auth->add($viewPet);
            $auth->add($createPet);
            $auth->add($updatePet);
            $auth->add($deletePet);
            $auth->add($viewUser);
            $auth->add($createUser);
            $auth->add($updateUser);
            $auth->add($deleteUser);


            //add permissions-per-role in Yii::$app->authManager
            // GUEST
            $auth->addChild($user, $viewPet);
            // MANAGER
            $auth->addChild($manager, $user);
            $auth->addChild($manager, $createPet);
            $auth->addChild($manager, $updatePet);
            $auth->addChild($manager, $deletePet);
            $auth->addChild($manager, $viewUser);
            // ADMIN
            $auth->addChild($admin, $manager);
            $auth->addChild($admin, $createUser);
            $auth->addChild($admin, $updateUser);
            $auth->addChild($admin, $deleteUser);

        } catch (Yii\console\Exception $e) {
            throw new $e;
        }
    }

    public function actionAssign(){
        $auth = Yii::$app->authManager;

        try {
            $admin = $auth->getRole('admin');
            $userAdmin = User::findByUsername('delirium');
            $auth->assign($admin, $userAdmin->id); // user with ID = 1 gets 'admin' role

            $manager = $auth->getRole('manager');
            $userManager = User::findByUsername('manager');
            $auth->assign($manager, $userManager->id);

            $user = $auth->getRole('user');
            $userUser = User::findByUsername('delirium1');
            $auth->assign($user, $userUser->id);

        } catch (Yii\console\Exception $e) {
            throw new $e;
        }
    }
}