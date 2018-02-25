<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\filemanager\assets\FilemanagerAsset;
use app\assets\ToggleiosAsset;

$filemngrAsset = FilemanagerAsset::register($this);
ToggleiosAsset::register($this);
?>

<!-- ROXY MODALS -->
<div class="modal fade" id="roxyMainModal" tabindex="-1" role="dialog" aria-labelledby="roxyModalLabel">
    <div class="modal-dialog" style="width:97%;"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="roxyModalLabel">Файловый менеджер</h4>
            </div>
            <div class="modal-body">
                <div  class="row">

                    <!-- START DIRECTORIES PANEL -->
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="panel panel-default dirsPanel">
                            <!-- DIRECTORIES ACTION BUTTONS -->
                            <div class="panel-heading">
                                <button type="button" id="btnAddDir" class="btn btn-default btn-sm" onclick="addDir()" data-toggle="modal" title="Create new directory" data-lang-v="CreateDir" data-lang-t="T_CreateDir">CreateDir</button>
                                <button type="button" id="btnRenameDir" class="btn btn-default btn-sm" onclick="renameDir()" data-toggle="modal" title="Rename directory" data-lang-v="RenameDir" data-lang-t="T_RenameDir" >Rename</button>
                                <button type="button" id="btnDeleteDir" class="btn btn-default btn-sm" title="Delete selected directory" onclick="deleteDir()" data-lang-v="DeleteDir" data-lang-t="T_DeleteDir">Delete</button>
                            </div>
                            <!-- DIRECTORIES TREE -->
                            <div class="panel-body">
                                <div class="pnlDirs" id="dirActions">
                                    <div class="actions"></div>
                                    <div id="pnlLoadingDirs">
                                        <span>Загрузка папок...</span><br>
                                        <?=Html::img($filemngrAsset->baseUrl.'/imgs/loading.gif', ['title'=>'Загрузка дерева каталогов, пожалуйста подождите...']);?>
                                    </div>
                                    <div class="scrollPane">
                                        <ul id="pnlDirList"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END DIRECTORIES PANEL -->


                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <!-- START FILES PANEL -->
                        <div class="panel panel-default filesPanel">
                            <!-- FILES ACTION BUTTONS -->
                            <div class="panel-heading">
                                <button type="button" id="btnAddFile" class="btn btn-default btn-sm" data-toggle="modal" data-target="#addFileModal" title="Upload files" data-lang-v="AddFile" data-lang-t="T_AddFile">Add file</button>
                                <button type="button" id="btnPreviewFile" class="fileActionBtn singleFileActionBtn btn btn-default btn-sm" title="Preview selected file" onclick="previewFile()" data-lang-v="Preview" data-lang-t="T_Preview">Preview</button>
                                <button type="button" id="btnCropImage" class="cropBtn btn btn-default btn-sm" title="Обрезать изображение" onclick="cropImage()" data-lang-v="Crop" data-lang-t="Crop">Crop</button>
                                <button type="button" id="btnRenameFile" class="fileActionBtn singleFileActionBtn btn btn-default btn-sm" data-toggle="modal" data-target="#renameFileModal" title="Rename selected file" data-lang-v="RenameFile" data-lang-t="T_RenameFile">Rename</button>
                                <button type="button" id="btnDownloadFile" class="fileActionBtn btn btn-default btn-sm" title="Download selected file" onclick="downloadFiles()" data-lang-v="DownloadFile" data-lang-t="T_DownloadFile">Download</button>
                                <button type="button" id="btnDeleteFile" class="fileActionBtn btn btn-default btn-sm" title="Delete selected file(s)" onclick="deleteFile()" data-lang-v="DeleteFile" data-lang-t="T_DeleteFile">Delete</button>
                                <button type="button" id="btnSelectFile" class="fileActionBtn btn btn-primary btn-sm" title="Select highlighted file" onclick="setFile()" data-lang-v="SelectFile" data-lang-t="T_SelectFile">Select</button>
                            </div>
                            <!-- FILES FILTER BUTTONS -->
                            <ul class="actions list-group">
                                <li class="list-group-item">
                                    <form class="form-inline" id="viewPanel">
                                        <!-- SORT BUTTONS -->
                                        <div class="form-group">
                                            <span data-lang="OrderBy">Order by</span>:
                                            <select class="form-control input-sm" id="ddlOrder" onchange="sortFiles()">
                                                <option value="name" data-lang="Name_asc">&uarr;&nbsp;&nbsp;Name</option>
                                                <option value="size" data-lang="Size_asc">&uarr;&nbsp;&nbsp;Size</option>
                                                <option value="time" data-lang="Date_asc">&uarr;&nbsp;&nbsp;Date</option>
                                                <option value="name_desc" data-lang="Name_desc">&darr;&nbsp;&nbsp;Name</option>
                                                <option value="size_desc" data-lang="Size_desc">&darr;&nbsp;&nbsp;Size</option>
                                                <option value="time_desc" data-lang="Date_desc">&darr;&nbsp;&nbsp;Date</option>
                                            </select>
                                        </div>
                                        <!-- GRID | LIST VIEW BUTTONS -->
                                        <div class="btn-group" data-toggle="buttons">
                                            <label class="btnView btn btn-default btn-sm" id="btnListView" title="List view" onclick="switchView('list')" data-lang-t="T_ListView">
                                                <input type="radio" name="options" id="option1" autocomplete="off">&nbsp;
                                            </label>
                                            <label class="btnView btn btn-default btn-sm" id="btnThumbView" title="Thumbnails view" onclick="switchView('thumb')" data-lang-t="T_ThumbsView">
                                                <input type="radio" name="options" id="option2" autocomplete="off">&nbsp;
                                            </label>
                                        </div>
                                        <!-- SEARCH TEXT FILTER -->
                                        <input type="text" class="form-control input-sm" id="txtSearch" onkeyup="filterFiles()" onchange="filterFiles()">
                                        <input type="hidden" id="filemanagerAssetBaseUrl" value="<?=$filemngrAsset->baseUrl?>">
                                    </form>
                                </li>
                            </ul>
                            <!-- FILES LIST -->
                            <div class="panel-body">
                                <div id="fileActions">
                                    <input type="hidden" id="hdViewType" value="list">
                                    <input type="hidden" id="hdOrder" value="asc">
                                    <div class="pnlFiles">
                                        <div class="scrollPane">
                                            <div id="pnlLoading">
                                                <span>Загрузка файлов</span><br>
                                                <?=Html::img($filemngrAsset->baseUrl.'/imgs/loading.gif', ['title'=>'Загрузка файлов, пожалуйста подождите...']);?>
                                            </div>
                                            <div id="pnlEmptyDir" data-lang="DirIsEmpty">
                                                Папка пуста
                                            </div>
                                            <div id="pnlSearchNoFiles" data-lang="NoFilesFound">
                                                Файлы не найдены
                                            </div>
                                            <ul id="pnlFileList"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- FILES STATUS BAR -->
                            <div class="panel-footer">
                                <div id="pnlStatus">Статусная строка</div>
                            </div>
                        </div>
                        <!-- /END FILES PANEL -->
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" onclick="setFile()">Выбрать</button>
            </div>
        </div>
    </div>
</div>

<!-- Forms and other components -->
<iframe name="frmUploadFile" width="0" height="0" style="display:none;border:0;"></iframe>

<!-- КОНТЕКСТНЫЕ МЕНЮ (Right Click) -->
<ul id="menuDir"  class="context-menu dropdown-menu">
    <li><a href="#" onclick="addDir()" id="mnuCreateDir" data-lang="T_CreateDir">Create new</a></li>
    <li><a href="#" onclick="downloadDir()" id="mnuDownloadDir" data-lang="DownloadFile">Download</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#" onclick="copyDir()" id="mnuDirCopy" data-lang="Copy" >Copy</a></li>
    <li><a href="#" onclick="cutDir()" id="mnuDirCut" data-lang="Cut" >Cut</a></li>
    <li><a href="#" onclick="return pasteToDirs(event, this)" id="mnuDirPaste" data-lang="Paste" class="paste pale" >Paste</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#" onclick="renameDir()" id="mnuRenameDir" data-lang="RenameDir">Rename</a></li>
    <li><a href="#" onclick="deleteDir()" id="mnuDeleteDir" data-lang="DeleteDir">Delete</a></li>
</ul>

<ul id="menuFile"  class="context-menu dropdown-menu">
    <!-- <li><a href="#" onclick="setFile()" data-lang="SelectFile" id="mnuSelectFile">Select</a></li> -->
    <li class="singleFileActionBtn fileActionBtn"><a href="#" onclick="previewFile()" data-lang="Preview" id="mnuPreview">Preview</a></li>
    <li class="fileActionBtn"><a href="#" onclick="downloadFiles()" data-lang="DownloadFile" id="mnuDownload">Download</a></li>
    <li role="separator" class="divider"></li>
    <li class="cropBtn"><a href="#" onclick="cropImage()" data-lang="Crop" id="mnuCropImage">Crop</a></li>
    <li class="fileActionBtn"><a href="#" onclick="copyFile()" data-lang="Copy" id="mnuFileCopy">Copy</a></li>
    <li class="fileActionBtn"><a href="#" onclick="cutFile()" data-lang="Cut" id="mnuFileCut">Cut</a></li>
    <li class="fileActionBtn"><a href="#" onclick="return pasteToFiles(event, this)" data-lang="Paste" class="paste pale" id="mnuFilePaste">Paste</a></li>
    <li role="separator" class="divider"></li>
    <li class="singleFileActionBtn fileActionBtn"><a href="#" id="mnuRenameFile" data-toggle="modal" data-target="#renameFileModal" data-lang="RenameFile">Rename</a></li>
    <li class="fileActionBtn"><a href="#" onclick="deleteFile()" data-lang="DeleteFile" id="mnuDeleteFile">Delete</a></li>
    <!-- <li><a href="#" onclick="fileProperties()" id="mnuProp">Properties</a></li> -->
</ul>

<!-- ADD FILE MODAL -->
<div class="modal fade second-level-modal" id="addFileModal" tabindex="-1" role="dialog" aria-labelledby="addFileModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addFileModalLabel" data-lang-v="T_AddFile" data-lang-t="T_AddFile">Загрузить файлы</h4>
            </div>
            <div class="modal-body" id="dlgAddFile">
                <form name="addfile" id="frmUpload" method="post" target="frmUploadFile" enctype="multipart/form-data">
                    <input type="hidden" name="d" id="hdDir" />
                    <div class="form">
                        <div id="drop">
                            Перетащите сюда<br/>файлы для загрузки<br/><br/>
                            <button type="button" id="browse-files" class="btn btn-default" autocomplete="off">ВЫБРАТЬ</button>
                            <input type="file" name="files[]" id="fileUploads" onchange="listUploadFiles(this.files)" multiple="multiple" />
                        </div>
                        <div id="uploadResult"></div>
                        <div class="uploadFilesList">
                            <div id="uploadFilesList"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" title="Cancel" data-lang-v="Cancel" data-lang-t="Cancel">Close</button>
                <button type="button" id="btnUpload" disabled="disabled" class="btn btn-primary btn-sm" title="Rename selected file" data-lang-v="Upload" data-lang-t="Upload">Upload</button>
            </div>
        </div>
    </div>
</div>

<!-- RENAME FILE MODAL -->
<div class="modal fade second-level-modal" id="renameFileModal" tabindex="-1" role="dialog" aria-labelledby="renameFileModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="renameFileModalLabel" data-lang-v="T_RenameFile" data-lang-t="T_RenameFile">Rename file</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Имя файла:</label>
                        <input id="txtFileName" class="form-control" type="text" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel" data-lang-v="Cancel" data-lang-t="Cancel">Close</button>
                <button type="button" id="renameFileBtn" class="btn btn-primary" title="Rename selected file" data-lang-v="RenameFile" data-lang-t="T_RenameFile">Rename</button>
            </div>
        </div>
    </div>
</div>


<!-- RENAME DIR MODAL -->
<div class="modal fade second-level-modal" id="renameDirModal" tabindex="-1" role="dialog" aria-labelledby="renameDirModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="renameDirModalLabel" data-lang-v="T_RenameDir" data-lang-t="T_RenameDir">Rename dir</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Имя директории:</label>
                        <input id="txtDirName" class="form-control" type="text" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel" data-lang-v="Cancel" data-lang-t="Cancel">Close</button>
                <button type="button" id="renameDirBtn" class="btn btn-primary" title="Rename selected dir" data-lang-v="RenameDir" data-lang-t="T_RenameDir">Rename</button>
            </div>
        </div>
    </div>
</div>

<!-- ADD DIR MODAL -->
<div class="modal fade second-level-modal" id="addDirModal" tabindex="-1" role="dialog" aria-labelledby="addDirModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addDirModalLabel" data-lang-v="T_CreateDir" data-lang-t="T_CreateDir">Create dir</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Имя директории:</label>
                        <input id="newDirName" class="form-control" type="text" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" title="Cancel" data-lang-v="Cancel" data-lang-t="Cancel">Close</button>
                <button type="button" id="addDirBtn" class="btn btn-primary" title="Создать новую директорию" data-lang-v="T_CreateDir" data-lang-t="T_CreateDir">Создать</button>
            </div>
        </div>
    </div>
</div>


<!--CROP IMAGE MODAL-->
<div class="modal fade second-level-modal" id="cropImageModal" tabindex="-1" role="dialog" aria-labelledby="cropImageModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="addDirModalLabel" data-lang-v="Crop" data-lang-t="Crop">Crop image</h4>
            </div>
            <div class="modal-body">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default cancelSelectionBtn" data-dismiss="modal" title="Cancel" data-lang-v="Cancel" data-lang-t="Cancel">Close</button>
                <button type="button" id="cropImgBtn" class="btn btn-primary" title="Обрезать изображение" data-lang-v="Crop" data-lang-t="Crop">Обрезать</button>
            </div>
        </div>
    </div>
</div>