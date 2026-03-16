# 📦 Warum Software neu schreiben meistens ein Fehler ist
## Refactoring Praxisberichte 

![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue.svg)
![Status](https://img.shields.io/badge/Status-Refactoring_in_Progress-orange.svg)
![Architecture](https://img.shields.io/badge/Architecture-Custom_MVC-green.svg)

Willkommen bei **PostBox**. In dieser Phase haben wir das veraltete URL-Parsing durch ein modernes, attribut-basiertes Routing ersetzt. Dieses Repository dient als Basis für eine öffentliche Case Study zum Thema Software-Modernisierung.

## 🎯 Der Status Quo: Episode 3 abgeschlossen

Nach der Entkopplung der Datenbank in Episode 2 haben wir nun die **Routing-Logik** revolutioniert. Wir haben uns von unübersichtlichen `if/else`-Blöcken und manuellen `explode('/')`-Operationen verabschiedet.

### ✅ Erreichte Meilensteine (Branch: `episode-3`)

* **Attribute Routing:** Controller-Methoden werden nun über moderne PHP Attributes (z. B. `#[Route('/blog')]`) gesteuert.
* **Wegfall der Apache-Abhängigkeit:** Das System ist nun vollständig serverunabhängig und benötigt keine komplexen `.htaccess`-Hacks mehr.
* **Zentraler Router:** Einführung einer robusten Routing-Engine, die HTTP-Verben (GET, POST) und Parameter automatisch verarbeitet.
* **Code-Sauberkeit:** Die Core-Klasse ist massiv geschrumpft, da die Logik nun deklarativ direkt an den Controller-Methoden liegt.

---

## 🗺️ Modernisierungs-Roadmap

* [x] **Episode 1:** Einführung von Composer & PSR-4 Autoloading.
* [x] **Episode 2:** Refactoring der Datenbank zu Dependency Injection.
* [x] **Episode 3:** Modernes Routing mit PHP Attributes.
* [ ] **Episode 4:** Einführung von Typsicherheit und DTOs.
* [ ] **Episode 5:** Security-Updates (Modern Escaping & CSRF).
* [ ] **Episode 6:** Optimierung der Business-Logik mit modernen PHP-Features.

---

## 🚀 Installation (Stand Episode 3)

1. **Repository klonen & Branch wechseln:**
   ```bash
   git clone [https://github.com/buildystudio/postbox.git](https://github.com/buildystudio/postbox.git)
   git checkout episode-3



2. **Abhängigkeiten installieren:**
   ```bash
   composer install




3. **Umgebung starten:**
* **Mit Docker:** `docker-compose up -d`
* **Manuell:** `php -S localhost:8000 -t public`



---

## 📬 Begleite das Refactoring

Ich teile die detaillierten Architektur-Entscheidungen und den "Vorher-Nachher"-Vergleich auf LinkedIn und Medium:

* 💼 **LinkedIn:** [Dinko Djurkovic](https://www.google.com/search?q=https://www.linkedin.com/in/dinko-d-7155673b1)
* ✍️ **Case Study:** [Ausführliche Berichte auf Medium](https://medium.com/@buildy.studio)
