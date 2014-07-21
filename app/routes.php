<?php


# Home page
Route::get('/', function() {
	return View::make('index');				
});




# List books/search results of books
Route::get('/list/{format?}', function($format = 'html') {


	$query = Input::get('query');


	# If there is a query, search the library with that query
	if($query) {


		# This is how we did it in class...
		//$books = Book::where('author', 'LIKE', "%$query%")->get();


		# Here's a better option because it searches across multiple fields
		$books = Book::where('author', 'LIKE', "%$query%")
			->orWhere('title', 'LIKE', "%$query%")
			->orWhere('published', 'LIKE', "%$query%")
			->get();


	}
	# Otherwise, just fetch all books
	else {
		$books = Book::all();	
	}


	# Decide on output method...
	# Default - HTML
	if($format == 'html') {
		return View::make('list')
			->with('books', $books)
			->with('query', $query);
	}
	# JSON
	elseif($format == 'json') {
		return Response::json($books);
	}
	# PDF (Coming soon)
	elseif($format == 'pdf') {
		return "This is the pdf (Coming soon).";
	}	
});








# Display edit form
Route::get('/edit/{title}', function() {


});


# Process edit form
Route::post('/edit/{title}', function() {


});








# Display add form
Route::get('/add/', function() {


	return View::make('add');


});


# Process add form
Route::post('/add/', function() {


	//echo Pre::render(Input::all());


	# Instantiate the book model
	$book = new Book();


	$book->title = Input::get('title');
	$book->author = Input::get('author');
	$book->published = Input::get('published');
	$book->cover = Input::get('cover');
	$book->purchase_link = Input::get('purchase_link');


	# Magic: Eloquent
	$book->save();


	return "Added a new row";


});












# Debug route: Read in the books.json file
Route::get('/data', function() {


	# Instantiating an object of the Library class
	$library = new Library(app_path().'/database/books.json'); 


	# Get the books
	$books = $library->get_books();


	# Debug
	return Pre::render($books, 'Books');


});








# Quickly seed books table for demonstration purposes
Route::get('/seed', function() {


	$query = "INSERT INTO `books` (`created_at`, `updated_at`, `title`, `author`, `published`, `cover`, `purchase_link`)
	VALUES
	('2014-07-17 09:15:14','2014-07-17 09:15:14','The Great Gatsby','F. Scott Fiztgerald',1925,'http://img2.imagesbn.com/p/9780743273565_p0_v4_s114x166.JPG','http://www.barnesandnoble.com/w/the-great-gatsby-francis-scott-fitzgerald/1116668135?ean=9780743273565'),
	('2014-07-17 09:15:47','2014-07-17 09:15:47','The Bell Jar','Sylvia Plath',1963,'http://img1.imagesbn.com/p/9780061148514_p0_v2_s114x166.JPG','http://www.barnesandnoble.com/w/bell-jar-sylvia-plath/1100550703?ean=9780061148514'),
	('2014-07-17 09:16:20','2014-07-17 09:16:20','I Know Why the Caged Bird Sings','Maya Angelou',1969,'http://img1.imagesbn.com/p/9780345514400_p0_v1_s114x166.JPG','http://www.barnesandnoble.com/w/i-know-why-the-caged-bird-sings-maya-angelou/1100392955?ean=9780345514400');
	";


	DB::statement($query);


	return $query;


});






Route::get('/mysql-connection-test', function() {


	$results = DB::select('SHOW DATABASES;');


	return Pre::render($results, 'Results');


});


Route::get('/practice-create', function() {


	# Instantiate the book model
	$book = new Book();


	$book->title = 'The Great Gatsby';
	$book->author = 'F. Scott Fiztgerald';
	$book->published = 1925;
	$book->cover = 'http://imagesbn.com....';
	$book->purchase_link = 'http://amazon...';


	# Magic: Eloquent
	$book->save();


	return "Added a new row";


});


Route::get('/practice-read', function() {


	//$book = new Book();


	# Magic: Eloquent
	$books = Book::all();


	# Debugging
	foreach($books as $book) {
		echo $book->title."<br>";
	}




});


Route::get('/practice-update', function() {


	//$book = Book::where('id', 'LIKE', '%Scott%')->first();
	//$book = Book::where('id', '=', 1);


	$book = Book::find(1);


	$book->title = 'The Great Gatsby...!';


	$book->save();


	echo "You updated the book.";


});


Route::get('/practice-delete', function() {


	$book = Book::find(2);


	$book->delete();


	echo "This book has been deleted";


});
