# 📦 PostBox: Legacy-to-Modern PHP (Case Study)

![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue.svg)
![Status](https://img.shields.io/badge/Status-Refactoring_in_Progress-orange.svg)
![Architecture](https://img.shields.io/badge/Architecture-Custom_MVC-green.svg)

Willkommen bei **PostBox** – einem klassischen, handgeschriebenen Model-View-Controller (MVC) Projekt aus dem Jahr 2019. Ursprünglich entwickelt als studentisches Projekt, dient dieses Repository heute als öffentlicher, interaktiver Lernpfad für massives Code-Refactoring.

## 🎯 Das Projekt-Ziel: Von 2019 zu 2026

Dieses Projekt ist eine Zeitkapsel. Es zeigt exakt, wie Custom-Frameworks in der PHP 7.x-Ära "from scratch" gebaut wurden, bevor sich moderne Standards flächendeckend durchgesetzt haben. Keine Packages, kein Composer, alles handgeschrieben.

Das Ziel dieser öffentlichen Case Study ist es, diese Legacy-Codebase Schritt für Schritt auf das Niveau moderner Enterprise-Architekturen (PHP 8.4+) zu heben. Es ist der perfekte Guide für Entwickler, die nach einer längeren PHP-Pause ihr Architektur-Wissen auffrischen wollen.

### ❌ Der Legacy-Zustand (Branch: `prolog`)
- Manuelles Autoloading via fehleranfälligen `require_once`-Ketten.
- Versteckte Abhängigkeiten durch globale Singletons (Datenbank-Verbindung).
- Implizites, unsicheres URL-Parsing via `explode('/')` in der Core-Klasse.
- Untypisierte assoziative Arrays (`$_POST`) als Datentransportmittel.
- Fatales Input-Escaping direkt in die Datenbank.
- Hohe zyklomatische Komplexität durch riesige `switch`-Monster im Validator.

### ✅ Das Ziel-Setup (Refactoring-Branches)
- **Infrastruktur:** Vollständiges PSR-4 Autoloading via Composer.
- **Architektur:** Inversion of Control (IoC) Container & saubere Dependency Injection.
- **Routing:** Deklaratives, typsicheres Routing über moderne PHP 8 Attributes.
- **Datenfluss:** Typsicherheit durch `readonly` Data Transfer Objects (DTOs) und Union Types.
- **Security:** Saubere Rohdaten in der DB und konsequentes Output-Escaping (FIEO / OWASP).
- **Logik:** Entflochtene Logik durch kompakte PHP 8 `match`-Expressions.

---

## 🗺️ Die Refactoring-Serie (Artikel & Branches)

Der komplette Umbau wird in einer 6-teiligen Artikelserie auf Medium im Detail erklärt. 

**So nutzt du dieses Repository:** Für jede Lektion existiert ein eigener Git-Branch. Wechsle einfach in den entsprechenden Branch, um dir den exakten Architektur-Stand nach dem jeweiligen Umbau-Schritt über die Diffs (Vorher/Nachher) anzusehen.

* 📖 **Branch `prolog`:** [Zurück zu PHP? Die Anatomie einer 2019er Legacy-App](https://medium.com/@buildy.studio/zurück-zu-php-a2329356cbb1)
* 🌿 **Branch `ep1-autoloading`:** [Zurück zu PHP? Vom require_once zum PSR-4 Autoloader (Lektion 1/6)](https://medium.com/@buildy.studio/warum-software-neu-schreiben-meistens-ein-fehler-ist-5ba4704f8d67)
* 🌿 **Branch `ep2-dependency-injection`:** [Zurück zu PHP? Vom Singleton zur Dependency Injection (Lektion 2/6)](https://medium.com/@buildy.studio/warum-software-neu-schreiben-meistens-ein-fehler-ist-91699d0a2130)
* 🌿 **Branch `ep3-attributes-routing`:** [Zurück zu PHP? Vom impliziten Routing zu PHP 8 Attributes (Lektion 3/6)](https://medium.com/@buildy.studio/warum-software-neu-schreiben-meistens-ein-fehler-ist-a8876d71c17a)
* 🌿 **Branch `ep4-strict-types-dtos`:** [Zurück zu PHP? Von assoziativen Arrays zu strikten DTOs (Lektion 4/6)](https://medium.com/@buildy.studio/warum-software-neu-schreiben-meistens-ein-fehler-ist-c7111a89d80d)
* 🌿 **Branch `ep5-output-escaping`:** [Zurück zu PHP? Von Input-Escaping zu Output-Escaping (Lektion 5/6)](https://medium.com/@buildy.studio/warum-software-neu-schreiben-meistens-ein-fehler-ist-d68285a6ab2e)
* 🌿 **Branch `ep6-match-expressions`:** [Zurück zu PHP? Von Switch-Statements zu Match-Expressions (Lektion 6/6)](https://medium.com/@buildy.studio/warum-software-neu-schreiben-meistens-ein-fehler-ist-6f75b2da3acf)

---

## 🚀 Installation & Lokales Setup

Wer sich den ursprünglichen Code ansehen oder die Applikation lokal ausführen möchte:

1. **Repository klonen:**
   ```bash
   git clone [https://github.com/buildystudio/postbox.git](https://github.com/buildystudio/postbox.git)
Datenbank einrichten:

Erstelle eine lokale MySQL-Datenbank namens postbox.

Hinweis: Ein SQL-Dump für die Tabellenstruktur (users, posts) liegt im Root-Verzeichnis bei.

Konfiguration anpassen:

Öffne app/config/config.php und passe DB_HOST, DB_USER und DB_PW an deine lokale Umgebung (z.B. Laravel Herd, MAMP, Docker) an.

Passe DB_NAME auf postbox an.

Passe die Konstante URLROOT an deinen lokalen Serverpfad an.

📬 Folge der Reise
Lass gerne einen ⭐ da, wenn dir dieses Refactoring-Tutorial geholfen hat!

Wenn du architektonische Tipps, alternative Lösungsansätze oder Korrekturen zum Code hast – ich bin immer offen für konstruktives Feedback. Erstelle gerne einen Pull Request oder diskutiere mit mir auf LinkedIn:

💼 Updates & Diskussionen: Folge mir auf LinkedIn
