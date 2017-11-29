<?php
use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;
use app\modules\filemanager\assets\FilemanagerAsset;

$filemngrAsset = FilemanagerAsset::register($this);
?>


        <div  class="row">

            <!-- DIRECTORIES SECTION -->
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                <div class="panel panel-default dirsPanel">
                    <div class="panel-heading">
                        <!-- DIRECTORIES ACTION BUTTONS -->
                        <button type="button" id="btnAddDir" class="btn btn-default btn-sm" onclick="addDir()" data-toggle="modal" title="Create new directory" data-lang-v="CreateDir" data-lang-t="T_CreateDir">CreateDir</button>

                        <button type="button" id="btnRenameDir" class="btn btn-default btn-sm" onclick="renameDir()" data-toggle="modal" title="Rename directory" data-lang-v="RenameDir" data-lang-t="T_RenameDir" >Rename</button>

                        <button type="button" id="btnDeleteDir" class="btn btn-default btn-sm" title="Delete selected directory" onclick="deleteDir()" data-lang-v="DeleteDir" data-lang-t="T_DeleteDir">Delete</button>
                    </div>

                    <div class="panel-body">
                        <!-- DIRECTORIES TREE -->
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


            <!-- FILES SECTION -->
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">

                <div class="panel panel-default filesPanel">
                    <div class="panel-heading"><!-- FILES ACTION BUTTONS -->
                        <!-- ADD FILE BTN -->
                        <button type="button" id="btnAddFile" class="btn btn-default btn-sm" data-toggle="modal" data-target="#addFileModal" title="Upload files" data-lang-v="AddFile" data-lang-t="T_AddFile">Add file</button>
                        <button type="button" id="btnPreviewFile" class="btn btn-default btn-sm" title="Preview selected file" onclick="previewFile()" data-lang-v="Preview" data-lang-t="T_Preview">Preview</button>
                        <!-- RENAME FILE BTN -->
                        <button type="button" id="btnRenameFile" class="btn btn-default btn-sm" data-toggle="modal" data-target="#renameFileModal" title="Rename selected file" data-lang-v="RenameFile" data-lang-t="T_RenameFile">Rename</button>
                        <button type="button" id="btnDownloadFile" class="btn btn-default btn-sm" title="Download selected file" onclick="downloadFile()" data-lang-v="DownloadFile" data-lang-t="T_DownloadFile">Download</button>
                        <button type="button" id="btnDeleteFile" class="btn btn-default btn-sm" title="Delete selected file" onclick="deleteFile()" data-lang-v="DeleteFile" data-lang-t="T_DeleteFile">Delete</button>
                        <button type="button" id="btnSelectFile" class="btn btn-primary btn-sm" title="Select highlighted file" onclick="setFile()" data-lang-v="SelectFile" data-lang-t="T_SelectFile">Select</button>
                    </div><!-- /END FILES PANEL HEADING -->

                    <ul class="actions list-group">
                        <li class="list-group-item">

                            <form class="form-inline">

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

                            </form>

                        </li>
                    </ul>




                    <div class="panel-body">
                        <!-- FILES LIST -->
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

                    <div class="panel-footer">
                        <div id="pnlStatus">Статусная строка</div>
                    </div>

                </div><!-- /END FILES PANEL -->

            </div>
        </div>


<!-- Forms and other components -->
<iframe name="frmUploadFile" width="0" height="0" style="display:none;border:0;"></iframe>








<!-- КОНТЕКСТНЫЕ МЕНЮ (Right Click) -->
<ul id="menuDir"  class="dropdown-menu">
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




<ul id="menuFile"  class="dropdown-menu">
    <!-- <li><a href="#" onclick="setFile()" data-lang="SelectFile" id="mnuSelectFile">Select</a></li> -->
    <li><a href="#" onclick="previewFile()" data-lang="Preview" id="mnuPreview">Preview</a></li>
    <li><a href="#" onclick="downloadFile()" data-lang="DownloadFile" id="mnuDownload">Download</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#" onclick="copyFile()" data-lang="Copy" id="mnuFileCopy">Copy</a></li>
    <li><a href="#" onclick="cutFile()" data-lang="Cut" id="mnuFileCut">Cut</a></li>
    <li><a href="#" onclick="return pasteToFiles(event, this)" data-lang="Paste" class="paste pale" id="mnuFilePaste">Paste</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#" id="mnuRenameFile" data-toggle="modal" data-target="#renameFileModal" data-lang="RenameFile">Rename</a></li>
    <li><a href="#" onclick="deleteFile()" data-lang="DeleteFile" id="mnuDeleteFile">Delete</a></li>
    <!-- <li><a href="#" onclick="fileProperties()" id="mnuProp">Properties</a></li> -->
</ul>




<!-- ADD FILE MODAL -->
<div class="modal fade" id="addFileModal" tabindex="-1" role="dialog" aria-labelledby="addFileModalLabel">
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
<div class="modal fade" id="renameFileModal" tabindex="-1" role="dialog" aria-labelledby="renameFileModalLabel">
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
<div class="modal fade" id="renameDirModal" tabindex="-1" role="dialog" aria-labelledby="renameDirModalLabel">
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
<div class="modal fade" id="addDirModal" tabindex="-1" role="dialog" aria-labelledby="addDirModalLabel">
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








<!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
<!--<script type="text/javascript" src="js/jquery-dateFormat.min.js"></script>-->


<!-- Latest compiled and minified CSS -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->

<!-- Optional theme -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">-->

<!-- Latest compiled and minified JavaScript -->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->


<!--<link href="css/main.css" rel="stylesheet" type="text/css" />-->


<!--<script type="text/javascript" src="js/custom.js"></script>-->


<!-- KNOB PRELOADER -->
<!--<script type="text/javascript" src="js/jquery.knob.js"></script>-->






<!-- <script type="text/javascript" src="js/main.min.js"></script> -->
<!--<script type="text/javascript" src="js/mini-main.js"></script>-->


