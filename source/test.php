<?php

require_once __DIR__.'/bootstrap.php';

echo "hello";

$repo = new BookRepo($configuration);

$book2 = $repo->loadById(5);
var_dump($book2);

$repo->updateInDb(5, 'A most terrible christmas','Dee Reynolds');

$book2 = $repo->loadById(5);
var_dump($book2);

$repo->deleteFromDb(5);$repo->deleteFromDb(6);$repo->deleteFromDb(7);

$book = new Book;

$book->setAuthor('Dennis Reynolds');
$book->setTitle('An very Philadelphia Christmas');
$book->setDescription('not very good, would not recommend');

$repo->createInDb($book);

$book3 = $repo->loadById(5);
var_dump($book3);


