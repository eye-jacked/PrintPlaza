<?php
header("Access-Control-Allow-Origin: *");
require 'source/bootstrap.php';

switch ($_SERVER['REQUEST_METHOD']) {

    case 'GET':
        $books = new Books();
        if (count($_GET) == 0) {
            // return all books for main screen
            echo json_encode($books->getAllBooks());
        }
        else {
            if (!empty($_GET['sort'])) {
                // return all books in id descending order
                echo json_encode($books->getAllBooks(1));
            }
            if (!empty($_GET['descr_id'])) {
                // return book description on More button click
                echo json_encode($books->getBookDescription($_GET['descr_id']));
            }
            if (!empty($_GET['new_id'])) {
                // return new book from db to append it to HTML
                echo json_encode($books->getBookMin($_GET['new_id']));
            }
            if (!empty($_GET['edit_id'])) {
                // return whole book for edit dialog
                echo json_encode($books->getBookAll($_GET['edit_id']));
            }
            if (count($_GET) == 2 && isset($_GET['o']) && isset($_GET['l'])) {
                $offset = $_GET['o'];
                $limit = $_GET['l'];
                echo json_encode($books->getBooksPerPageMin($offset, $limit));
            }
            if (!empty($_GET['before'])) {
                // return all boks before specified id
                $id = $_GET['before'];
                echo json_encode($books->getBooksBeforeId($id));
            }
            if (!empty($_GET['after'])) {
                // return all boks after specified id
                $id = $_GET['after'];
                echo json_encode($books->getBooksAfterId($id));
            }
        }
        break;

    case 'POST':
        $bookRepo = new bookRepo($configuration);
        if (count($_POST) == 0) {
            // no data, do nothing,
        }
        elseif (!empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['description'])) {
            // Post data loaded, load book
            $author = $_POST['author'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $newBook = new Book($author, $title, $description);
            echo json_encode($bookRepo->addBook($newBook));
        }
        break;

    case 'PUT':
        $books = new Books();
        parse_str(file_get_contents("php://input"), $put_vars);
        $id = $put_vars['uid'];
        $author = $put_vars['uauthor'];
        $title = $put_vars['utitle'];
        $descr = $put_vars['udescr'];
        echo json_encode($books->updateBook($id, $author, $title, $descr));
        break;

    case 'DELETE':
        $books = new Books();
        parse_str(file_get_contents("php://input"), $put_vars);
        $id = $put_vars['del_id'];
        $books->deleteBook($id);
        break;
}

