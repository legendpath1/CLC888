<?php  
    $param = $_REQUEST['param'];
    $searchUrl = $param;  
    if(!empty($_GET['content']))  
    {  
        $searchUrl .= $_GET['content'];  
    }  
    echo file_get_contents($searchUrl);  
?>