<?php

function validPage($page, $numberOfPages)
{
    if ($page >= 1 && $page <= $numberOfPages) {
        return true;
    } else {
        return false;
    }
}