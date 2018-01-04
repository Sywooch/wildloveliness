<?php

namespace app\modules\filemanager\controllers;

use Yii;
use ZipArchive;
use yii\base\ErrorException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\modules\filemanager\RoxyFile;
use app\modules\filemanager\RoxyImage;
use app\modules\filemanager\RoxyUtils;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => [
                            'logout', 'index', 'getjsonconfig', 'getjsonlang', 'getdirtree',
                            'getfileslist', 'createdir', 'movedir', 'deletedir', 'copydir',
                            'renamedir', 'upload', 'getthumb', 'downloadfiles', 'downloaddir',
                            'deletefile', 'movefile', 'copyfile', 'renamefile', 'cropimage'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'getjsonconfig' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetjsonconfig(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return \Yii::$app->controller->module->params;
    }

    public function actionGetjsonlang(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $langAbbr = \Yii::$app->controller->module->params['LANG'];
        return file_get_contents( __DIR__ . '/../lang/'.$langAbbr.'.json', true);
    }


    // ================================================================
    // DIRECTORIES
    // ================================================================
    public function getFilesNumber($path, $type){
        $files = 0;
        $dirs = 0;

        $tmp = RoxyUtils::listDirectory($path);

        foreach ($tmp as $ff){
            if($ff == '.' || $ff == '..')
                continue;
            elseif(is_file($path.'/'.$ff) && ($type == '' || ($type == 'image' && RoxyFile::IsImage($ff)) || ($type == 'flash' && RoxyFile::IsFlash($ff))))
                $files++;
            elseif(is_dir($path.'/'.$ff))
                $dirs++;
        }

        return array('files'=>$files, 'dirs'=>$dirs);
    }

    public function GetDirs($path, $type){
        $ret = $sort = array();
        $files = RoxyUtils::listDirectory(RoxyUtils::fixPath($path), 0);
        foreach ($files as $f){
            $fullPath = $path.'/'.$f;
            if(!is_dir(RoxyUtils::fixPath($fullPath)) || $f == '.' || $f == '..')
                continue;
            $tmp = $this->getFilesNumber(RoxyUtils::fixPath($fullPath), $type);
            $ret[$fullPath] = array('path'=>$fullPath,'files'=>$tmp['files'],'dirs'=>$tmp['dirs']);
            $sort[$fullPath] = $f;
        }
        natcasesort($sort);
        foreach ($sort as $k => $v) {
            $tmp = $ret[$k];
            echo ',{"p":"'.mb_ereg_replace('"', '\\"', $tmp['path']).'","f":"'.$tmp['files'].'","d":"'.$tmp['dirs'].'"}';
            $this->GetDirs($tmp['path'], $type);
        }
    }

    public function actionGetdirtree(){
        // получаем данные из массива $_POST
        $type = Yii::$app->request->get('d');
        $type = (empty($type) ? '' : strtolower($type));
        if ($type != 'image' && $type != 'flash')
            $type = '';
        echo "[\n";
        $tmp = $this->getFilesNumber(RoxyUtils::fixPath(RoxyUtils::getFilesPath()), $type);
        echo '{"p":"' . mb_ereg_replace('"', '\\"', RoxyUtils::getFilesPath()) . '","f":"' . $tmp['files'] . '","d":"' . $tmp['dirs'] . '"}';
        $this->GetDirs(RoxyUtils::getFilesPath(), $type);
        echo "\n]";
    }

    public function actionCreatedir(){
        // получаем данные из массива $_POST
        $d = Yii::$app->request->post('d');
        $n = Yii::$app->request->post('n');
        $path = trim(empty($d)?'':$d);
        $name = trim(empty($n)?'':$n);
        //RoxyUtils::verifyPath($path);

        $dirPermissions = \Yii::$app->controller->module->params['DIRPERMISSIONS'];

        if(is_dir(RoxyUtils::fixPath($path))){
            if(mkdir(RoxyUtils::fixPath($path).'/'.$name, octdec($dirPermissions)))
                echo RoxyUtils::getSuccessRes();
            else
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_CreateDirFailed').' '.basename($path));
        }
        else
            echo  RoxyUtils::getErrorRes(RoxyUtils::t('E_CreateDirInvalidPath'));
    }

    public function actionMovedir(){
        // получаем данные из массива $_POST
        $d = Yii::$app->request->post('d');
        $n = Yii::$app->request->post('n');
        $path = trim(empty($d)?'':$d);
        $newPath = trim(empty($n)?'':$n);

        if(is_dir(RoxyUtils::fixPath($path))){
            if(mb_strpos($newPath, $path) === 0)
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_CannotMoveDirToChild'));
            elseif(file_exists(RoxyUtils::fixPath($newPath).'/'.basename($path)))
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_DirAlreadyExists'));
            elseif(rename(RoxyUtils::fixPath($path), RoxyUtils::fixPath($newPath).'/'.basename($path)))
                echo RoxyUtils::getSuccessRes();
            else
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_MoveDir').' '.basename($path));
        }
        else
            echo RoxyUtils::getErrorRes(RoxyUtils::t('E_MoveDirInvalisPath'));
    }

    public function actionDeletedir(){
        // получаем данные из массива $_POST
        $d = Yii::$app->request->get('d');
        $path = trim(empty($d)?'':$d);

        if(is_dir(RoxyUtils::fixPath($path))){
            if(RoxyUtils::fixPath($path.'/') == RoxyUtils::fixPath(RoxyUtils::getFilesPath().'/'))
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_CannotDeleteRoot'));
            elseif(count(glob(RoxyUtils::fixPath($path)."/*")))
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_DeleteNonEmpty'));
            elseif(rmdir(RoxyUtils::fixPath($path)))
                echo RoxyUtils::getSuccessRes();
            else
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_CannotDeleteDir').' '.basename($path));
        }
        else
            echo RoxyUtils::getErrorRes(RoxyUtils::t('E_DeleteDirInvalidPath').' '.$path);
    }

    public function actionCopydir(){
        // получаем данные из массива $_POST
        $d = Yii::$app->request->post('d');
        $n = Yii::$app->request->post('n');
        $path = trim(empty($d)?'':$d);
        $newPath = trim(empty($n)?'':$n);

        function copyDir($path, $newPath){
            $dirPermissions = \Yii::$app->controller->module->params['DIRPERMISSIONS'];
            $items = RoxyUtils::listDirectory($path);
            if(!is_dir($newPath))
                mkdir ($newPath, octdec($dirPermissions));
            foreach ($items as $item){
                if($item == '.' || $item == '..')
                    continue;
                $oldPath = RoxyFile::FixPath($path.'/'.$item);
                $tmpNewPath = RoxyFile::FixPath($newPath.'/'.$item);
                if(is_file($oldPath))
                    copy($oldPath, $tmpNewPath);
                elseif(is_dir($oldPath)){
                    copyDir($oldPath, $tmpNewPath);
                }
            }
        }

        if(is_dir(RoxyUtils::fixPath($path))){
            copyDir(RoxyUtils::fixPath($path.'/'), RoxyUtils::fixPath($newPath.'/'.basename($path)));
            echo RoxyUtils::getSuccessRes();
        }
        else
            echo RoxyUtils::getErrorRes(RoxyUtils::t('E_CopyDirInvalidPath'));
    }

    public function actionRenamedir(){
        // получаем данные из массива $_POST
        $d = Yii::$app->request->post('d');
        $n = Yii::$app->request->post('n');
        $path = trim(empty($d)? '': $d);
        $name = trim(empty($n)? '': $n);

        if(is_dir(RoxyUtils::fixPath($path))){

            if(RoxyUtils::fixPath($path.'/') == RoxyUtils::fixPath(RoxyUtils::getFilesPath().'/')) {
                //DevHelper::preArray('1',1);
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_CannotRenameRoot'));
            }
            elseif(rename(RoxyUtils::fixPath($path), dirname(RoxyUtils::fixPath($path)).'/'.$name)) {
                echo RoxyUtils::getSuccessRes();
            }
            else {
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_RenameDir').' '.basename($path));
            }
        }
        else
            echo RoxyUtils::getErrorRes(RoxyUtils::t('E_RenameDirInvalidPath'));
    }

    public function actionDownloaddir(){
        @ini_set('memory_limit', -1);

        $path = trim(Yii::$app->request->get('d'));
        $path = RoxyUtils::fixPath($path);

        if(!class_exists('ZipArchive')){
            echo '<script>alert("Cannot create zip archive - ZipArchive class is missing. Check your PHP version and configuration");</script>';
        }
        else{
            try{
                $filename = basename($path);
                $zipFile = $filename.'.zip';
                $basePath = \Yii::$app->controller->module->params['BASE_PATH'];
                $zipDirName = \Yii::$app->controller->module->params['ZIP_DIR_NAME'];
                // создаем временную папку для архивов если ее нет
                // если папка существует, удаляем в ней все старые архивы
                $zipDir = RoxyUtils::fixPath($basePath.'/'.$zipDirName);
                if(!is_dir($zipDir)) {
                    mkdir($zipDir);
                } else {
                    array_map('unlink', glob($zipDir."/*.zip"));
                }
                $zipPath = $zipDir.'/'.$zipFile;
                RoxyFile::ZipDir($path, $zipPath);
                return \Yii::$app->response->sendFile($zipPath);
            }
            catch(ErrorException $ex){
                echo '<script>alert("'.  addslashes(RoxyUtils::t('E_CreateArchive')).'");</script>';
            }
        }
    }

    // ================================================================
    // FILES
    // ================================================================

    public function actionGetfileslist(){
        // получаем данные из массива $_POST
        $d = Yii::$app->request->post('d');
        $type = Yii::$app->request->post('type');

        $path = (empty($d)? RoxyUtils::getFilesPath(): $d);
        $type = (empty($type)?'':strtolower($type));
        if($type != 'image' && $type != 'flash')
            $type = '';
        //RoxyUtils::verifyPath($path);

        $files = RoxyUtils::listDirectory(RoxyUtils::fixPath($path), 0);
        natcasesort($files);
        $str = '';
        echo '[';
        foreach ($files as $f){
            $fullPath = $path.'/'.$f;
            if(!is_file(RoxyUtils::fixPath($fullPath)) || ($type == 'image' && !RoxyFile::IsImage($f)) || ($type == 'flash' && !RoxyFile::IsFlash($f)))
                continue;
            $size = filesize(RoxyUtils::fixPath($fullPath));
            $time = filemtime(RoxyUtils::fixPath($fullPath));
            $w = 0;
            $h = 0;
            if(RoxyFile::IsImage($f)){
                $tmp = @getimagesize(RoxyUtils::fixPath($fullPath));
                if($tmp){
                    $w = $tmp[0];
                    $h = $tmp[1];
                }
            }
            $str .= '{"p":"'.mb_ereg_replace('"', '\\"', $fullPath).'","s":"'.$size.'","t":"'.$time.'","w":"'.$w.'","h":"'.$h.'"},';
        }
        $str = mb_substr($str, 0, -1);
        echo $str;
        echo ']';
    }

    public function actionUpload(){
        $reqMethod = Yii::$app->request->post('method');
        $d = Yii::$app->request->post('d');

        $isAjax = (isset($reqMethod) && $reqMethod == 'ajax');
        $path = trim(empty($d)? RoxyUtils::getFilesPath():$d);

        $res = '';
        if(is_dir(RoxyUtils::fixPath($path))){
            if(!empty($_FILES['files']) && is_array($_FILES['files']['tmp_name'])){
                $errors = $errorsExt = array();

                foreach($_FILES['files']['tmp_name'] as $k=>$v){
                    $filename = $_FILES['files']['name'][$k];
                    $filename = RoxyFile::MakeUniqueFilename(RoxyUtils::fixPath($path), $filename);
                    $filePath = RoxyUtils::fixPath($path).'/'.$filename;
                    $isUploaded = true;
                    if(!RoxyFile::CanUploadFile($filename)){
                        $errorsExt[] = $filename;
                        $isUploaded = false;
                    }
                    elseif(!move_uploaded_file($v, $filePath)){
                        $errors[] = $filename;
                        $isUploaded = false;
                    }
                    if(is_file($filePath)){
                        @chmod ($filePath, octdec(\Yii::$app->controller->module->params['FILEPERMISSIONS']));
                    }
                    if($isUploaded && RoxyFile::IsImage($filename) && (intval(\Yii::$app->controller->module->params['MAX_IMAGE_WIDTH']) > 0 || intval(\Yii::$app->controller->module->params['MAX_IMAGE_HEIGHT']) > 0)){
                        RoxyImage::Resize($filePath, $filePath, intval(\Yii::$app->controller->module->params['MAX_IMAGE_WIDTH']), intval(\Yii::$app->controller->module->params['MAX_IMAGE_HEIGHT']));
                    }
                }
                if($errors && $errorsExt)
                    $res = RoxyUtils::getSuccessRes(RoxyUtils::t('E_UploadNotAll').' '.RoxyUtils::t('E_FileExtensionForbidden'));
                elseif($errorsExt)
                    $res = RoxyUtils::getSuccessRes(RoxyUtils::t('E_FileExtensionForbidden'));
                elseif($errors)
                    $res = RoxyUtils::getSuccessRes(RoxyUtils::t('E_UploadNotAll'));
                else
                    $res = RoxyUtils::getSuccessRes();
            }
            else
                $res = RoxyUtils::getErrorRes(RoxyUtils::t('E_UploadNoFiles'));
        }
        else
            $res = RoxyUtils::getErrorRes(RoxyUtils::t('E_UploadInvalidPath'));

        if($isAjax){
            if($errors || $errorsExt)
                $res = RoxyUtils::getErrorRes(RoxyUtils::t('E_UploadNotAll'));
            echo $res;
        }
        else{
            echo '
                <script>
                parent.fileUploaded('.$res.');
                </script>';
        }
    }

    public function actionGetthumb(){
        $headers = Yii::$app->response->headers;
        $headers->add('Pragma', 'cache');
        $headers->add('Cache-Control', 'max-age=3600');

        $dirPermissions = \Yii::$app->controller->module->params['DIRPERMISSIONS'];
        $filePermissions = \Yii::$app->controller->module->params['FILEPERMISSIONS'];

        $path = urldecode(empty($_GET['f'])?'':$_GET['f']);
        RoxyUtils::fixPath($path);

        @chmod(RoxyUtils::fixPath(dirname($path)), octdec($dirPermissions));
        @chmod(RoxyUtils::fixPath($path), octdec($filePermissions));

        $headers->add('Content-type', RoxyFile::GetMIMEType(basename($path)));

        $width = Yii::$app->request->get('width');
        $height = Yii::$app->request->get('height');
        $w = intval(empty($width)?'100':$width);
        $h = intval(empty($height)?'0':$height);

        if($w && $h)
            RoxyImage::CropCenter(RoxyUtils::fixPath($path), null, $w, $h);
        else
            RoxyImage::Resize(RoxyUtils::fixPath($path), null, $w, $h);
    }

    public function actionDownloadfiles(){
        $filesNum = Yii::$app->request->get('filesNum');
        if(!$filesNum){
            // download single file
            $path = Yii::$app->request->get('f');
            $path = RoxyUtils::fixPath(trim($path));
            if(is_file($path))
                return \Yii::$app->response->sendFile($path);
        } else {
            $zipDir = RoxyUtils::prepareZipDir();
            $zipFile = time().'.zip';
            $zipPath = $zipDir.'/'.$zipFile;
            // prepare files paths array
            $files = [];
            for($i=0; $i < $filesNum; $i++){
                $files[$i] = RoxyUtils::fixPath(trim(Yii::$app->request->get('f'.$i)));
            }

            try{
                RoxyFile::zipFiles($files, $zipPath);
                //RoxyFile::ZipDir($path, $zipPath);
                return \Yii::$app->response->sendFile($zipPath);
            }
            catch(ErrorException $ex){
                echo '<script>alert("'.  addslashes(RoxyUtils::t('E_CreateArchive')).'");</script>';
            }
        }
    }

    public function actionDeletefile(){
        $path = trim(Yii::$app->request->post('f'));

        if(is_file(RoxyUtils::fixPath($path))){
            if(unlink(RoxyUtils::fixPath($path)))
                echo RoxyUtils::getSuccessRes();
            else
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_DeletеFile').' '.basename($path));
        }
        else
            echo RoxyUtils::getErrorRes(RoxyUtils::t('E_DeleteFileInvalidPath'));
    }

    public function actionMovefile(){
        $f = Yii::$app->request->post('f');
        $n = Yii::$app->request->post('n');
        $path = trim(empty($f)?'':$f);
        $newPath = trim(empty($n)?'':$n);
        if(!$newPath)
            $newPath = RoxyUtils::getFilesPath();

        if(!RoxyFile::CanUploadFile(basename($newPath))) {
            echo RoxyUtils::getErrorRes(RoxyUtils::t('E_FileExtensionForbidden'));
        }
        elseif(is_file(RoxyUtils::fixPath($path))){
            if(file_exists(RoxyUtils::fixPath($newPath)))
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_MoveFileAlreadyExists').' '.basename($newPath));
            elseif(rename(RoxyUtils::fixPath($path), RoxyUtils::fixPath($newPath)))
                echo RoxyUtils::getSuccessRes();
            else
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_MoveFile').' '.basename($path));
        }
        else {
            echo RoxyUtils::getErrorRes(RoxyUtils::t('E_MoveFileInvalisPath'));
        }
    }

    public function actionCopyfile(){
        $f = Yii::$app->request->post('f');
        $n = Yii::$app->request->post('n');
        $path = trim(empty($f)?'':$f);
        $newPath = trim(empty($n)?'':$n);
        if(!$newPath)
            $newPath = RoxyUtils::getFilesPath();

        if(is_file(RoxyUtils::fixPath($path))){
            $newPath = $newPath.'/'.RoxyFile::MakeUniqueFilename(RoxyUtils::fixPath($newPath), basename($path));
            if(copy(RoxyUtils::fixPath($path), RoxyUtils::fixPath($newPath)))
                echo RoxyUtils::getSuccessRes();
            else
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_CopyFile'));
        }
        else
            echo RoxyUtils::getErrorRes(RoxyUtils::t('E_CopyFileInvalisPath'));
    }

    public function actionRenamefile(){
        $f = Yii::$app->request->post('f');
        $n = Yii::$app->request->post('n');
        $path = trim(empty($f)?'':$f);
        $name = trim(empty($n)?'':$n);

        if(is_file(RoxyUtils::fixPath($path))){
            if(!RoxyFile::CanUploadFile($name))
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_FileExtensionForbidden').' ".'.RoxyFile::GetExtension($name).'"');
            elseif(rename(RoxyUtils::fixPath($path), dirname(RoxyUtils::fixPath($path)).'/'.$name))
                echo RoxyUtils::getSuccessRes();
            else
                echo RoxyUtils::getErrorRes(RoxyUtils::t('E_RenameFile').' '.basename($path));
        }
        else
            echo RoxyUtils::getErrorRes(RoxyUtils::t('E_RenameFileInvalidPath'));
    }

    public function actionCropimage(){

        //var_dump(Yii::$app->request->post('resHeight'));

        $srcImgPath = Yii::$app->request->post('srcImgPath');
        $srcImgName = Yii::$app->request->post('srcImgName');
        $srcImgExt = Yii::$app->request->post('srcImgExt');
        $resImgWidth = Yii::$app->request->post('resWidth');
        $resImgHeight = Yii::$app->request->post('resHeight');
        $selWidth = Yii::$app->request->post('selWidth');
        $selHeight = Yii::$app->request->post('selHeight');
        $x1 = Yii::$app->request->post('x1');
        $y1 = Yii::$app->request->post('y1');

        if($resImgWidth !== $selWidth || $resImgHeight !== $selHeight){
            $resImgWidth = $selWidth; // ширина результрующего изображения
            $resImgHeight = $selHeight; // высота результрующего изображения
        }

        $srcImgFullPath = RoxyUtils::fixPath($srcImgPath . '/' . $srcImgName);
        $newImgFullpath = RoxyUtils::fixPath(RoxyImage::Makenewimgname($srcImgPath, $srcImgName, $srcImgExt, $selWidth, $selHeight));


        //$srcImgFullPath, $newImgFullpath, $x1, $y1, $selWidth, $selHeight, $resImgWidth, $resImgHeight
        var_dump($srcImgFullPath);
        var_dump($newImgFullpath);
        var_dump($x1);
        var_dump($y1);
        var_dump($selWidth);
        var_dump($selHeight);
        var_dump($resImgWidth);
        var_dump($resImgHeight);


        try{
            RoxyImage::Crop($srcImgFullPath, $newImgFullpath, $x1, $y1, $selWidth, $selHeight, $resImgWidth, $resImgHeight);
        }
        catch(ErrorException $ex){
            echo '<script>alert("'.  addslashes(RoxyUtils::t('E_CropImage')).'");</script>';
        }
    }
}
