<?php

//header('Content-Type: application/json');

$post_pageNo = $_POST["pageNo"];
$browser = $_POST["browser"];
$version = $_POST["version"];
$itemCount = 59990;

if($browser == "ie"){
    $itemCount = 5000;
    if($version < 9){
        $itemCount = 1000;
    }
}

echo('{result:"ok",list:[');
for ($i = 0;$i<$itemCount; $i++){
    if($i > 0){
        echo ",";
    }
    echo('{no:'.($post_pageNo * $i + 1).',title:"AXGrid data line '.$post_pageNo."/".$i.'",writer:"Thomas",regDate:"2013-01-18",desc:"myGrid.setList",price:123000,amount:10}');
}
echo('],');
echo('page:{pageNo:'.$post_pageNo.',pageCount:200,listCount:'.$itemCount.'},msg:""');
echo('}');

?>


