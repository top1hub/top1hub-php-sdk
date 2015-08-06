#源速SDK  PHP版Demo
```php
<?php
include 'top1hub/ResourceManager.php';
use top1hub\ResourceManager;

$file_name = $_FILES ['myfile'] ['name'];
$tmp_name = $_FILES ['myfile'] ['tmp_name'];
$type = $_FILES ['myfile'] ['type'];

move_uploaded_file ( $tmp_name, "upload/" . $file_name );

//上传文件
$mgr = ResourceManager::create ()
    			->safeCode("输入安全码")
				->container ( '容器名称' )
				->build();
$result = $mgr->upload($file_name,"文件URL" . $file_name,false,$type);
var_dump($result->getSueccess());

//删除文件
$result = $mgr->delete("文件URL");
var_dump($result->getSueccess());
```