<?php

$base = include __DIR__.DIRECTORY_SEPARATOR.'en-base.php';
$us = include __DIR__.DIRECTORY_SEPARATOR.'en-us.php';
$uk = include __DIR__.DIRECTORY_SEPARATOR.'en-uk.php';

return array_merge($base, $us, $uk);
