<?php


function dd($var)
{
    yii\helpers\VarDumper::dump($var, 10, true);
    die();
}