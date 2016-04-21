<?php
echo 'Password Incorrect!' . '<br><br>';

echo '$emp_id (SQL): ';
var_dump($col1);
echo '<br>';

echo '$pwd (SQL): ';
var_dump($col2);
echo '<br>';

echo 'SHA512 (PHP): ';
$dump = hash('sha512', $col2);
var_dump($dump);
echo '<br>';

echo '$hash : ';
var_dump($hash);
echo '<br>';