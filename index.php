<?php

    require_once ('db_config.php');

    $result = $mysqli->query("SELECT * FROM item");

    while($arr = $result->fetch_array()){
        $arr_1[$arr['id']] = $arr['value'];
    }

    $result = $mysqli->query("SELECT * FROM item_sort WHERE `user`=1");

    $arr = $result->fetch_array();
    $arr_2 = $arr['value'];
    $arr_2 = json_decode($arr_2);

    function sortArrayByArray(array $array, array $orderArray) {
        $ordered = array();
        foreach($orderArray as $key) {
            if(array_key_exists($key,$array)) {
                $ordered[$key] = $array[$key];
                unset($array[$key]);
            }
        }
        return $ordered + $array;
    }

    $arr_3 = sortArrayByArray($arr_1, $arr_2);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Sortable</title>
        <link rel="stylesheet" href="includes/jquery-ui-1.11.4.custom/jquery-ui.css">
        <script src="includes/jquery/jquery.js"></script>
        <script src="includes/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
        <style>
            #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
            #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
            #sortable li span { position: absolute; margin-left: -1.3em; }
        </style>
        <script>
            $(function() {
                $( "#sortable" ).sortable();
                $( "#sortable" ).disableSelection();
            });
        </script>
    </head>

    <body>

        <ul id="sortable">
            <?php
                foreach ($arr_3 AS $key => $value){
            ?>
                <li class="ui-state-default item" data-id="<?=$key?>"><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Item <?=$value?></li>
            <?php } ?>
        </ul>
        <div id="json"></div>

    </body>
</html>
<script>
    var sort = [];

    $(function (){
        $('.item').mouseup(function(){
            setTimeout(sorted, 100);
        });
    });

    function sorted(){
        $('.item').each(function(i,elem) {
            sort[i] = $(this).data('id')
        });
        $.post( "ajax.php", {sort: JSON.stringify(sort), user: 1}, function( data ) {
            $( "#json" ).html( data);
        });
    }
</script>