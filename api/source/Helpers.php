<?php

function site(string $param = null): string
    {
        if($param && !empty(SITE[$param])){
            return SITE[$param];
        }

        return SITE["root"];
    }