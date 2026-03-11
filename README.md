# 📦 Warum Software neu schreiben meistens ein Fehler ist
## Refactoring Praxisberichte 

![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue.svg)
![Status](https://img.shields.io/badge/Status-Refactoring_in_Progress-orange.svg)
![Architecture](https://img.shields.io/badge/Architecture-Custom_MVC-green.svg)

Willkommen bei **PostBox**. In dieser Phase des Projekts haben wir die Architektur grundlegend entkoppelt. Dieses Repository dient als Basis für eine öffentliche Case Study zum Thema Software-Modernisierung.

## 🎯 Der Status Quo: Episode 2 abgeschlossen

Nachdem wir in Episode 1 die Infrastruktur (Composer/PSR-4) vorbereitet haben, lag der Fokus nun auf der **Auflösung globaler Zustände**. Wir haben das starre Singleton-Pattern entfernt und durch moderne Dependency Injection ersetzt.

### ✅ Erreichte Meilensteine (Branch: `episode-2`)

* **Tod dem Singleton:** Komplette Auflösung von `Database::getInstance()`.
* **Constructor Injection:** Models erhalten ihre Datenbankverbindung nun explizit über den Konstruktor.
* **Composition Root:** Zentrale Verwaltung der Abhängigkeiten im Front-Controller (Bootstrap-Phase).
* **Testbarkeit:** Durch die Entkopplung ist der Code nun bereit für Unit Testing und Mock-Objekte.

---

## 🗺️ Modernisierungs-Roadmap

* [x] **Episode 1:** Einführung von Composer & PSR-4 Autoloading.
* [x] **Episode 2:** Refactoring der Datenbank zu Dependency Injection.
* [ ] **Episode 3:** Modernes Routing mit PHP Attributes.
* [ ] **Episode 4:** Einführung von Typsicherheit und DTOs.
* [ ] **Episode 5:** Security-Updates (Modern Escaping & CSRF).
* [ ] **Episode 6:** Optimierung der Business-Logik mit modernen PHP-Features.

---

## 🚀 Installation (Stand Episode 2)

1. **Repository klonen & Branch wechseln:**
   ```bash
   git clone [https://github.com/buildystudio/postbox.git](https://github.com/buildystudio/postbox.git)
   git checkout episode-2



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
