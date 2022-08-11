<?php

echo "1 primeira questão \n";
echo var_dump(0 == 'all');

echo "\n\n2 primeira questão \n";
echo var_dump(min(-100, -10, null, 10, 100));

echo "\n\n3 tesceira questão\n";

$array = [[1, 2], [3, 4]];

foreach ($array as [$a, $b, $c]) {
    echo "A $a; B:$b C:$c";
    break;
}

echo "\n\nquarta questão\n";
echo 2 ^ '3';

echo "\n\nquinta questão\n";
$foo = 'bob';
$bar = &$foo;
$bar = 'My name is $bar';
echo $bar;

echo "\n\nsexta questão\n";
$foo = null;
$bar = null;
$baz = 1;
$qux = 2;

echo $foo ?? $bar ?? $baz ?? $qux;

echo "\n\nsetima questão\n";

$foo = true ? 0 : true ? 1 : 2;
echo $foo;
