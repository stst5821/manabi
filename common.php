<?php

// sanitize関数 formに入力されたスクリプトを文字に変換する。

function sanitize($before) {
    foreach($before as $key=>$value)
    {
        $after[$key] = htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }
    return $after;
 }