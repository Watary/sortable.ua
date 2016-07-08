<?php

    require_once ('db_config.php');

    $result = $mysqli->query("SELECT * FROM item");

    while($arr = $result->fetch_array()){
        $arr_1[$arr['id']] = $arr['value'];
    }

    $user = 3;

    $result = $mysqli->query("SELECT * FROM item_sort WHERE `user`=$user");

    if($result->num_rows){
        $arr = $result->fetch_array();
        $arr_2 = $arr['value'];
        $arr_2 = json_decode($arr_2, true);

        function sortArrayByArray(array $array, array $orderArray) {
            foreach ($orderArray AS $ident => $list){
                foreach ($list AS $value){
                    foreach ($array AS $akey => $avalue) {
                        if ($value == $akey) {
                            $ary[$ident][$value] = $avalue;
                            unset($array[$akey]);
                            break;
                        }
                    }
                }
            }
            foreach ($array AS $avalue) {
                $ary[1][] = $avalue;
            }
            return $ary;
        }

        $arr_3 = sortArrayByArray($arr_1, $arr_2);
    }else{
        foreach ($arr_1 AS $avalue) {
            $arr_3[1][] = $avalue;
        }
    }
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
            .connectedSortable, .connectedSortable {
                border: 1px solid #eee;
                min-height: 20px;
                list-style-type: none;
                margin: 0;
                padding: 5px 0 0 0;
                float: left;
                margin-right: 10px;
                min-width: 172px;
            }
            .connectedSortable li, .connectedSortable li {
                margin: 0 5px 5px 5px;
                padding: 5px;
                font-size: 1.2em;
                min-width: 150px;
            }
        </style>
        <script>
            $(function() {
                $( "#sortable_1, #sortable_2" ).sortable({
                    cancel: ".ui-state-disabled"
                });
                $( "#sortable_1, #sortable_2" ).sortable({
                    connectWith: ".connectedSortable"
                }).disableSelection();
            });
        </script>
    </head>

    <body>

        <div class="wrap">
            <ul id="sortable_1" class="connectedSortable" data-ident="1" >
                <?php
                if(empty($arr_3[1])){?>
                    <li class="ui-state-default ui-state-disabled disabled-hidden">List empty</li>
                <?php }else{?>
                    <li class="ui-state-default ui-state-disabled disabled-hidden" style="display: none">List empty</li>
                    <?php foreach ($arr_3[1] AS $key => $value){
                        ?>
                        <li class="ui-state-default item" data-group="1" data-id="<?=$key?>"><?=$value?></li>
                    <?php }} ?>
            </ul>

            <ul id="sortable_2" class="connectedSortable" data-ident="2">
                <?php
                if(empty($arr_3[2])){?>
                    <li class="ui-state-default ui-state-disabled disabled-hidden">List empty</li>
                <?php }else{?>
                    <li class="ui-state-default ui-state-disabled disabled-hidden" style="display: none">List empty</li>
                    <?php foreach ($arr_3[2] AS $key => $value){
                        ?>
                        <li class="ui-state-default item" data-group="1" data-id="<?=$key?>"><?=$value?></li>
                <?php }} ?>
            </ul>

            <div id="json"></div>
        </div>

    </body>
</html>
<script>
    var sort = {};
    var group;

    $(function (){
        $('.item').mouseup(function(){
            group = $(this).data('group');
            setTimeout(sorted, 100);
        });
    });

    function sorted(){
        $(".connectedSortable").each(function(i,elem) {
            if($(this).children().length == 1){
                $(this).find(".disabled-hidden").css( "display", "block");
            }else{
                $(this).find(".disabled-hidden").css( "display", "none");
            }
        });
        sort[1] = [];
        sort[2] = [];
        $(".item").each(function(i,elem) {
            if($(this).data('group') == group){
                sort[$(this).parent().data('ident')].push($(this).data('id'));
            }
        });
        $.post( "ajax.php", {sort: JSON.stringify(sort), user: <?=$user?>}, function( data ) {
            //$( "#json" ).html( data);
        });
        sort = {};
    }
</script>