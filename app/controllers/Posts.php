<?php
declare(strict_types=1);
namespace App\Controllers;
use App\DTOs\PostCreateDTO;
use App\DTOs\PostUpdateDTO;
use App\Attributes\Route;
use App\Libraries\Controller;
use App\Libraries\Database; // WICHTIG: Die neue Abhängigkeit importieren!
use App\Libraries\Session;
use App\Libraries\Redirect;
use App\Libraries\Input;
use App\Libraries\Validator;
use App\Libraries\CSRF;
use Exception;

class Posts extends Controller
{
    private $post;

    /**
     * NACHHER: Child-Controller reicht Abhängigkeit weiter
     */
    public function __construct(Database $db)
    {
        // 1. CONSTRUCTOR INJECTION: Wir fangen die DB auf und geben sie 
        // sofort an den Base-Controller (die Elternklasse) weiter!
        parent::__construct($db);

        // 2. Deine bestehende Logik bleibt völlig unberührt
        if(!Session::has('user')) Redirect::to('/users/login');

        $this->post = $this->model('Post');
    }
	
	#[Route('/posts', methods: ['GET'])]
	public function index()
	{
// Instanz des Post Models, die alle Posts abruft
         $posts = $this->post->getPosts();
		$this->view('posts/index', $posts);
	}

	// Posts hinzufügen
	#[Route('/posts/add', methods: ['GET', 'POST'])]
    public function add()
    {
        if($this->checkInputAndCsrf()) {
            $rawData = [
                'title' => Input::get('title'),
                'body'  => Input::get('body')
            ];

            $validation = new Validator($this->db);
            $validation->check($rawData, [
                'title' => ['name' => 'Title', 'required' => true, 'min' => 3],
                'body'  => ['name' => 'Content', 'required' => true],
            ]);

            if($validation->passed) {
                try {
                    $dto = new PostCreateDTO($rawData['title'], $rawData['body'], Session::get('user'));
                    $this->post->create($dto);
                    
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
	#[Route('/posts/show/{id}', methods: ['GET'])]
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
	#[Route('/posts/edit/{id}', methods: ['GET', 'POST'])]
    public function edit($id)
    {
        if($this->post->belongsToUser($id)) {
            if($this->checkInputAndCsrf()) {
                $rawData = [
                    'title' => Input::get('title'),
                    'body'  => Input::get('body')
                ];

                $validation = new Validator($this->db);
                $validation->check($rawData, [
                    'title' => ['name' => 'Title', 'required' => true, 'min' => 3],
                    'body'  => ['name' => 'Content', 'required' => true],
                ]);

                if($validation->passed) {
                    try {
                        $dto = new PostUpdateDTO($rawData['title'], $rawData['body']);
                        $this->post->update((int)$id, $dto);
                        
                        Session::flash('success', 'Post updated successfully.');
                        Redirect::to('/posts/show/' . $id);
                    }
                    catch(Exception $e) {
                        die($e->getMessage());
                    }
                }
                else $this->view('posts/edit', array_merge($validation->errors, [
                    'post' => $this->post->getSinglePostBy($id),
                ]));
            }
            else $this->view('posts/edit', ['post' => $this->post->getSinglePostBy($id)]);
        }
        else  {
            Session::flash('error', 'You may only edit your own posts.');
            Redirect::to('/posts/show/' . $id);
        }
    }
	
	#[Route('/posts/delete/{id}', methods: ['POST'])]
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