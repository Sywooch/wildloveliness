<?php
return [
    'params' => [
        "FILES_ROOT" => "", // если не указано, создастя папка 'uploads'
        "BASE_PATH" => "web",
        "ZIP_DIR_NAME" => "zipdir",
        "RETURN_URL_PREFIX" => "",
        "SESSION_PATH_KEY" => "",
        "THUMBS_VIEW_WIDTH" => "140",
        "THUMBS_VIEW_HEIGHT" => "120",
        "PREVIEW_THUMB_WIDTH" => "100",
        "PREVIEW_THUMB_HEIGHT" => "100",
        "MAX_IMAGE_WIDTH" => "1000",
        "MAX_IMAGE_HEIGHT" => "1000",
        "INTEGRATION" => "custom",
        "DIRLIST" => "/admin/filemanager/default/getdirtree",
        "CREATEDIR" => "/admin/filemanager/default/createdir",
        "DELETEDIR" => "/admin/filemanager/default/deletedir",
        "MOVEDIR" => "/admin/filemanager/default/movedir",
        "COPYDIR" => "/admin/filemanager/default/copydir",
        "RENAMEDIR" => "/admin/filemanager/default/renamedir",
        "FILESLIST" => "/admin/filemanager/default/getfileslist",
        "UPLOAD" => "/admin/filemanager/default/upload",
        "DOWNLOAD" => "/admin/filemanager/default/downloadfiles",


        "DOWNLOADDIR" => "/admin/filemanager/default/downloaddir",
        "DELETEFILE" => "/admin/filemanager/default/deletefile",
        "MOVEFILE" => "/admin/filemanager/default/movefile",
        "COPYFILE" => "/admin/filemanager/default/copyfile",
        "RENAMEFILE" => "/admin/filemanager/default/renamefile",
        "GENERATETHUMB" => "/admin/filemanager/default/getthumb",
        "DEFAULTVIEW" => "list",
        "FORBIDDEN_UPLOADS" => "zip js jsp jsb mhtml mht xhtml xht php phtml php3 php4 php5 phps shtml jhtml pl sh py cgi exe application gadget hta cpl msc jar vb jse ws wsf wsc wsh ps1 ps2 psc1 psc2 msh msh1 msh2 inf reg scf msp scr dll msi vbs bat com pif cmd vxd cpl htpasswd htaccess",
        "ALLOWED_UPLOADS" => "",
        "FILEPERMISSIONS" => "0644",
        "DIRPERMISSIONS" => "0755",
        "LANG" => "ru",
        "DATEFORMAT" => "dd.MM.yyyy HH:mm",
        "OPEN_LAST_DIR" => "yes"
    ],
];