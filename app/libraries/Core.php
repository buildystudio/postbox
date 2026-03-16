<?php
declare(strict_types=1);
namespace App\Libraries;

use ReflectionClass;
use App\Attributes\Route;

class Core
{
    public function __construct() 
    {
        // 1. URL und HTTP-Methode auslesen
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Falls das Projekt in einem Unterordner liegt (z.B. localhost:8888),
        // stellen wir sicher, dass wir einen sauberen Pfad haben:
        $requestUri = rtrim($requestUri, '/') ?: '/';
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        // 2. Alle Controller registrieren, die wir scannen wollen
        $controllers = [
            \App\Controllers\Home::class,
            \App\Controllers\Posts::class,
            \App\Controllers\Users::class
        ];

        // 3. Controller mit Reflection scannen
        foreach ($controllers as $controllerClass) {
            $reflection = new ReflectionClass($controllerClass);

            foreach ($reflection->getMethods() as $method) {
                $attributes = $method->getAttributes(Route::class);

                foreach ($attributes as $attribute) {
                    $route = $attribute->newInstance();

                    // Passt die HTTP-Methode? (GET/POST)
                    if (!in_array($requestMethod, $route->methods)) {
                        continue;
                    }

                    // Regex bauen: Ersetzt {id} durch einen Regex-Platzhalter für Parameter
                    $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_]+)', $route->path);
                    $pattern = "@^" . $pattern . "$@D";

                    // Passt die aufgerufene URL auf unsere Route?
                    if (preg_match($pattern, $requestUri, $matches)) {
                        array_shift($matches); // Den vollen Regex-Match entfernen, nur Parameter behalten
                        
                     // 2026 Enterprise Autowiring: Der Container baut den Controller inkl. aller Abhängigkeiten!
                        $controllerInstance = $this->buildInstance($controllerClass);
                        
                        // Controller-Methode mit Parametern aufrufen
                        $controllerInstance->{$method->getName()}(...$matches);
                        return; // Request erfolgreich beendet!
                    }
                }
            }
        }

        // Wenn keine Route gefunden wurde:
        http_response_code(404);
        die("404 - Route not found");
    }
    /**
     * Ein rekursiver Dependency Injection Container.
     * Erstellt Instanzen und löst deren Abhängigkeiten automatisch auf.
     */
    private function buildInstance(string $className)
    {
        $reflection = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();

        // Wenn die Klasse keinen Konstruktor hat, einfach instanziieren
        if (!$constructor) {
            return new $className();
        }

        $dependencies = [];
        // Alle Parameter des Konstruktors analysieren
        foreach ($constructor->getParameters() as $parameter) {
            $dependencyType = $parameter->getType()->getName();
            // REKURSION: Falls die Abhängigkeit selbst Abhängigkeiten hat
            // (z.B. Validator braucht Database), wird dies hier automatisch gelöst!
            $dependencies[] = $this->buildInstance($dependencyType);
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}