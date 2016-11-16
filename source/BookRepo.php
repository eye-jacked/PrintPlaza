<?php


class BookRepo
{
    private $configuration;

    private $pdo;


    /**
     * BookRepo constructor.
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        $this->configuration = $configuration;

        $this->pdo = new PDO(
            $this->configuration['db_dsn'],
            $this->configuration['db_user'],
            $this->configuration['db_pass']
        );
    }

    public function getAllBooks()
    {
        $stmt = $this->pdo->prepare('SELECT *
                                     FROM books;');
        $stmt->execute();
        $bookData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $bookData;
    }

    /**
     * @param $id
     * @return array
     */
    public function loadById($id)
    {
        $stmt = $this->pdo->prepare('SELECT title, author, description
                                     FROM books
                                     WHERE id = :id;');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $bookData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $bookData;
    }

    /**
     * @param Book $book
     */
    public function createInDb(Book $book)
    {
        $stmt = $this->pdo->prepare('INSERT INTO books (title, author, description)
                                     VALUES (:title,:author,:description)');

        $title = $book->getTitle();
        $author = $book->getAuthor();
        $description= $book->getDescription();

        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * @param $id
     * @param $title
     * @param $author
     */
    public function updateInDb($id, $title, $author)
    {
        $stmt = $this->pdo->prepare('UPDATE books SET title = :title, author = :author, description = :description
                                     WHERE id = :id');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':author', $author, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * @param $id
     */
    public function deleteFromDb($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM books 
                                     WHERE id = :id');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }


}
