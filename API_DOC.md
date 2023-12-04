<h2 align="center">Library Application <br /> API Docs</h2>


#### Get Books

Get list of all books with their author and publishers

```
GET /books
````

#### Create Book

Create a new book with author and publisher

```
POST /books
````
###

| Name     | Type       | Description                           |
|----------|------------|---------------------------------------|
| title |  string | <p>Title of the book (Required)</p> |
| description | text | <p>Description of the book (Not Required)</p> |
| author_id | integer | <p>Author id which will be attached to this book</p> |
| publisher_id | integer | <p>Publishing house id which is publishing this book.</p> |

##
#### Get Book

Get book details with author and publisher

```
GET /books/{book_id}
````

##
#### Update Book

Update book details with author and publisher. **Author and publisher ids will be changed only when passed in the request.**

```
PUT/PATCH /books/{book_id}
````
#### 
| Name     | Type       | Description                           |
|----------|------------|---------------------------------------|
| title |  string | <p>Title of the book</p> |
| description | text | <p>Description of the book</p> |
| author_id | integer | <p>Author id which will be attached to this book</p> |
| publisher_id | integer | <p>Publishing house id which is publishing this book.</p> |

#### Delete Book

Delete book

```
DELETE /books/{book_id}
````