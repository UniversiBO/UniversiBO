<?php

function apc_fetch(string $key, &$success = null)
{
    return apcu_fetch($key, $success);
}

function apc_store(string $key, $var = NULL, $ttl = 0)
{
    apcu_store($key, $var, $ttl);
}
