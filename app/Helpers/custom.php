<?php

function matchUrlToRoute($url = null)
{
    return app('router')->getRoutes()->match(app('request')->create($url ?? url()->previous()));
}


