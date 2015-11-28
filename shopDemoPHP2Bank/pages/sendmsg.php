<?php  
    $param = $_REQUEST['param'];
    $searchUrl = $param;  
    if(!empty($_POST['content']))  
    {  
        $searchUrl .= $_POST['content'];  
    }  
    echo file_get_contents($searchUrl); 
     
    
?>