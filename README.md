# 📦 Warum Software neu schreiben meistens ein Fehler ist
## Refactoring Praxisberichte 

![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue.svg)
![Status](https://img.shields.io/badge/Status-Refactoring_in_Progress-orange.svg)
![Architecture](https://img.shields.io/badge/Architecture-Custom_MVC-green.svg)

Willkommen bei **PostBox**. In dieser Phase des Projekts haben wir die Infrastruktur modernisiert. Dieses Repository dient als Basis für eine öffentliche Case Study zum Thema Software-Modernisierung.

## 🎯 Der Status Quo: Episode 1 abgeschlossen

Wir haben die Codebase "atmungsfähig" gemacht, indem wir starre Abhängigkeiten gelöst und moderne Standards etabliert haben.

### ✅ Erreichte Meilensteine (Branch: `episode-1`)

* **Composer Integration:** Einführung der `composer.json` zur Verwaltung von Dependencies.
* **PSR-4 Autoloading:** Ablösung von `require_once` durch den Industriestandard.
* **Server-Unabhängigkeit:** Das Routing nutzt nun `REQUEST_URI` statt Apache-Tricks.
* **Facade-Hacks:** Nutzung von `class_alias` für Abwärtskompatibilität trotz Namespaces.
* **Modern Syntax:** Ersetzen veralteter Funktionen durch moderne PHP-Features.

---

## 🗺️ Modernisierungs-Roadmap

* [x] **Episode 1:** Einführung von Composer & PSR-4 Autoloading.
* [ ] **Episode 2:** Refactoring der Datenbank zu Dependency Injection.
* [ ] **Episode 3:** Modernes Routing mit PHP Attributes.
* [ ] **Episode 4:** Einführung von Typsicherheit und DTOs.
* [ ] **Episode 5:** Security-Updates (Modern Escaping & CSRF).
* [ ] **Episode 6:** Optimierung der Business-Logik mit modernen PHP-Features.

---

## 🚀 Installation (Stand Episode 1)

1. **Repository klonen & Branch wechseln:**
   ```bash
   git clone [https://github.com/buildystudio/postbox.git](https://github.com/buildystudio/postbox.git)
   git checkout episode-1

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
