<?php

class Posts extends Controller
{

	private $post;

	// wird als erstes ausgeführt, wenn Posts instanziiert wird
	public function __construct()
	{
		// wenn Nutzer nicht angemeldet ist, wird er aufs Login weitergeleitet
		if(!Session::has('user')) Redirect::to('/users/login');

		$this->post = $this->model('Post');
	}

	// Startseite mit allen Posts
	public function index()
	{
		// Instanz des Post Models, die alle Posts abruft
		$posts = $this->post->getPosts();
		$this->view('posts/index', $posts);
	}

	// Posts hinzufügen
	public function add()
	{
		if($this->checkInputAndCsrf()) {
			foreach($this->post->postFields as $key => $value) {
					$this->post->postFields[$key] = Input::get($key);
				}

				// Validierung
				$validation = new Validator;
				$validation->check($this->post->postFields, [
					'title' => [
						'name' => 'Title',
						'required' => true,
						'min' => 3,
					],
					'body' => [
						'name' => 'Content',
						'required' => true,
					],
				]);

				if($validation->passed) {
					try {
						$this->post->create(array_merge(['user_id' => Session::get('user')], $this->post->postFields));
						Session::flash('success', 'Posted successfully.');
						Redirect::to('/posts');
					}
					catch(Exception $e) {
						die($e->getMessage());
					}
				}
				else $this->view('posts/add', $validation->errors);
		}
		else $this->view('posts/add');
	}

	// einzelnen Post anzeigen
	public function show($id)
	{
		if($post = $this->post->getSinglePostBy($id)) {
			$this->view('posts/show', [
				'post' => $post,
				'user' => $this->model('User', $post->user_id)->userData,
			]);
		}
		else {
			Session::flash('error', 'Post not found.');
			Redirect::to('posts');
		}
	}

	// einen Post editieren
	public function edit($id)
	{
		// wenn die Person, die auf Editieren klickt, der Autor ist
		if($this->post->belongsToUser($id)) {
			if($this->checkInputAndCsrf()) {
				foreach($this->post->postFields as $key => $value) {
					$this->post->postFields[$key] = Input::get($key);
				}

				// Validierung
				$validation = new Validator;
				$validation->check($this->post->postFields, [
					'title' => [
						'name' => 'Title',
						'required' => true,
						'min' => 3,
					],
					'body' => [
						'name' => 'Content',
						'required' => true,
					],
				]);

				// Validierung wird bestanden
				if($validation->passed) {
					try {
						$this->post->update($id, $this->post->postFields);
						Session::flash('success', 'Post updated successfully.');
						Redirect::to('/posts/show/' . $id);
					}

					catch(Exception $e) {
						die($e->getMessage());
					}
				}
				// Validierung wird nicht bestanden
				else $this->view('posts/edit', array_merge($validation->errors, [
					'post' => $this->post->getSinglePostBy($id),
				]));
			}
			else $this->view('posts/edit', ['post' => $this->post->getSinglePostBy($id)]);
		}
		else  {
			// Fehlermeldung, wenn Nutzer nicht der Autor des Posts ist
			Session::flash('error', 'You may only edit your own posts.');
			Redirect::to('/posts/show/' . $id);
		}
	}

	public function delete($id)
	{
		if($this->post->belongsToUser($id)) {
			if($this->checkInputAndCsrf()) {
				if($this->post->delete($id)) {
					Session::flash('success', 'Post deleted successfully.');
					Redirect::to('/posts');
				}
				else die('Something went wrong.');
			}
			else Redirect::to('/posts'); 
		}
		else {
			Session::flash('error', 'You may only delete your own posts.');
			Redirect::to('/posts/show/' . $id);
		}
	}
}