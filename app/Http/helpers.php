<?php

function grade($m)
{
    if ($m >= 80) {
        return 'A+';
    }elseif ($m >= 75 && $m < 80) {
        return 'A';
    }elseif ($m >= 70 && $m < 75) {
        return 'A-';
    }elseif ($m >= 65 && $m < 70) {
        return 'B+';
    }elseif ($m >= 60 && $m < 65) {
        return 'B';
    }elseif ($m >= 55 && $m < 60) {
        return 'B-';
    }elseif ($m >= 50 && $m < 55) {
        return 'C+';
    }elseif ($m >= 45 && $m < 50) {
        return 'C';
    }elseif ($m >= 40 && $m < 45) {
        return 'D';
    }else{
        return 'F';
    }
}


function creditGrade($m,$credit)
{
    $mark = 0;
    if ($credit == 3) {
        $mark = $m;
    }elseif ($credit == 2) {
        $mark = $m*2;
    }elseif ($credit == 1) {
        $mark = $m*4;
    }else{
        $mark = $m;
    }

    if ($mark >= 80) {
        return 'A+';
    }elseif ($mark >= 75 && $m < 80) {
        return 'A';
    }elseif ($mark >= 70 && $m < 75) {
        return 'A-';
    }elseif ($mark >= 65 && $m < 70) {
        return 'B+';
    }elseif ($mark >= 60 && $m < 65) {
        return 'B';
    }elseif ($mark >= 55 && $m < 60) {
        return 'B-';
    }elseif ($mark >= 50 && $m < 55) {
        return 'C+';
    }elseif ($mark >= 45 && $m < 50) {
        return 'C';
    }elseif ($mark >= 40 && $m < 45) {
        return 'D';
    }else{
        return 'F';
    }


    function total($s=0,$t=0)
    {
        return $s+$t;
    }
}

?>
