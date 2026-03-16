# 📦 Warum Software neu schreiben meistens ein Fehler ist
## Refactoring Praxisberichte 

![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue.svg)
![Status](https://img.shields.io/badge/Status-Refactoring_Completed-brightgreen.svg)
![Architecture](https://img.shields.io/badge/Architecture-Custom_MVC-green.svg)

Willkommen bei **PostBox**. Dieses Repository zeigt das Endergebnis einer umfassenden Case Study zur Software-Modernisierung. Aus einem studentischen Legacy-Projekt (Stand 2019) wurde eine moderne, objektorientierte Architektur nach Enterprise-Standards (Stand 2026) entwickelt.

> 💡 **Hinweis:** Dieser `main`-Branch enthält den **vollständig modernisierten Code**. Die ursprüngliche Legacy-Version aus 2019 findest du im Branch [`prolog`](https://github.com/buildystudio/postbox/tree/prolog).

## 🎯 Der Status Quo: Enterprise PHP (2026)

Die Architektur wurde von Grund auf refaktorisiert, ohne das Rad neu zu erfinden. Wir haben uns von unübersichtlichen `if/else`-Blöcken, globalen Zuständen und unsicheren Datenstrukturen verabschiedet.

### ✅ Erreichte Meilensteine

* **Inversion of Control:** Ein rekursiver Dependency Injection Container löst Klassenabhängigkeiten automatisch auf.
* **Attribute Routing:** Controller-Methoden werden deklarativ über PHP 8 Attributes (z. B. `#[Route('/blog')]`) gesteuert.
* **Typsicherheit:** Der Datenfluss zwischen Layern wird streng über Data Transfer Objects (DTOs) kontrolliert.
* **Modernes PHP:** Nutzung von PSR-4 Autoloading via Composer, Match-Expressions und strikten Typisierungen.
* **Wegfall der Apache-Abhängigkeit:** Das System ist vollständig serverunabhängig und benötigt keine `.htaccess`-Hacks mehr.

---

## 🗺️ Modernisierungs-Roadmap

Alle Phasen des Refactorings sind abgeschlossen. Um die einzelnen Schritte nachzuvollziehen, existiert für jede Lektion ein eigener Branch:

* [x] **Episode 1:** Einführung von Composer & PSR-4 Autoloading.
* [x] **Episode 2:** Refactoring der Datenbank zu Dependency Injection.
* [x] **Episode 3:** Modernes Routing mit PHP Attributes & Autowiring-Container.
* [x] **Episode 4:** Einführung von Typsicherheit und DTOs.
* [x] **Episode 5:** Security-Updates (Modern Output-Escaping).
* [x] **Episode 6:** Optimierung der Business-Logik mit modernen PHP-Features.

---

## 🚀 Installation (Modern 2026 Version)

1. **Repository klonen:**
   ```bash
   git clone [https://github.com/buildystudio/postbox.git](https://github.com/buildystudio/postbox.git)
   cd postbox
Abhängigkeiten installieren:

Bash
composer install
Umgebung starten:

Mit Docker (Empfohlen): Starte die Container mit docker-compose up -d. Die Datenbank initialisiert sich selbst.

Manuell ohne Docker: php -S localhost:8000 -t public (Konfiguriere vorher deine Zugangsdaten in app/config/config.php).

📬 Begleite das Refactoring
Ich teile die detaillierten Architektur-Entscheidungen und den "Vorher-Nachher"-Vergleich auf LinkedIn und Medium:

💼 LinkedIn: Dinko Djurkovic

✍️ Case Study: Ausführliche Berichte auf Medium