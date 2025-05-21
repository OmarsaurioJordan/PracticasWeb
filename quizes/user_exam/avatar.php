<?php

$avatar = [
    '😆','😊','🙃','😉','😍','😘','😋','🤪',
    '😖','🙁','😏','🥺','😭','😡','😳','🥵',
    '😶','😬','🙄','😴','😮','🥴','😈','👽','💀','🤡'
];

$generos = [
    "...", "Mujer", "Hombre", "Otro"
];
$subgeneros = [
    "🍃", "💃", "🕺🏻", "🦄"
];

function getAvatar($ind) {
    global $avatar;
    if ($ind >= 0 && $ind < count($avatar)) {
        return $avatar[$ind];
    }
    return '👤';
}

function getGenero($ind, $isSub=false) {
    global $generos, $subgeneros;
    if ($isSub) {
        if ($ind >= 0 && $ind < count($subgeneros)) {
            return $subgeneros[$ind];
        }
        return $subgeneros[0];
    }
    else {
        if ($ind >= 0 && $ind < count($generos)) {
            return $generos[$ind];
        }
        return $generos[0];
    }
}
?>
