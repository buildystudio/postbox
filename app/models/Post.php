<?php
declare(strict_types=1);
namespace App\Models;
use App\DTOs\PostCreateDTO;
use App\DTOs\PostUpdateDTO;
use App\Libraries\Model;
use App\Libraries\Session;
use App\Libraries\Database;
use Exception; // Wichtig für die try-catch Blöcke!
class Post extends Model
{
	// Methode zum Anzeigen der Posts
	public function getPosts()
	{
		// wählt alle Posts eines Nutzers mit Vor- und Nachnamen aus. Verbindet dazu die Tabellen posts und users an der Stelle user_id in posts und id in users
		return $this->db->query("
			SELECT posts.*, users.first_name, users.last_name 
			FROM posts
			JOIN users ON posts.user_id = users.id
			ORDER BY posts.created_at DESC
		")->results();
	}

	// einen einzelnen Post anzeigen
	public function getSinglePostBy($id)
	{
		return $this->db->get('posts', ['id', '=', $id])->first();
	}

	// Abfrage, welchem User der Post gehört
	public function belongsToUser($id) 
	{
		return Session::get('user') === $this->getSinglePostBy($id)->user_id;
	}

	// neuen Post einfügen
	public function create(PostCreateDTO $dto): void 
    {
        $fields = [
            'title' => $dto->title,
            'body' => $dto->body,
            'user_id' => $dto->userId
        ];

        if(!$this->db->insert('posts', $fields)) {
            throw new Exception('Post was not stored in Database.');
        }
    }

	// Post updaten
	public function update(int $id, PostUpdateDTO $dto): void
    {
        $fields = [
            'title' => $dto->title,
            'body' => $dto->body
        ];

        if(!$this->db->update('posts', $id, $fields)) {
            throw new Exception('Update did not work.');
        }
    }

	public function delete(int $id)
	{
		if(!$this->db->delete('posts', ['id', '=', $id])->count) {
			throw new Exception('Deletion did not work.');
		}
		return true;
	}
}