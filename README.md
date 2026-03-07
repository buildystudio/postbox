

# 📦 PostBox: Legacy-to-Modern PHP Case Study

![PHP Version](https://img.shields.io/badge/PHP-8.4%2B-blue.svg)
![Status](https://img.shields.io/badge/Status-Refactoring_in_Progress-orange.svg)
![Architecture](https://img.shields.io/badge/Architecture-Custom_MVC-green.svg)

Willkommen bei **PostBox** – einem Full-OOP PHP Content Management System. Ursprünglich entwickelt 2019 als studentisches Semesterabschlussprojekt, dient dieses Repository heute als öffentliche Case Study für massives Code-Refactoring.

## 🎯 Das Projekt-Ziel: Von 2019 zu 2026

Dieses Projekt ist eine Zeitkapsel. Es zeigt exakt, wie man MVC-Frameworks "from scratch" gebaut hat, bevor sich moderne Standards flächendeckend durchgesetzt haben. Keine Packages, kein Composer, alles handgeschrieben.

Das Ziel dieser öffentlichen Case Study ist es, diese Legacy-Codebase Schritt für Schritt auf das Niveau moderner Enterprise-Architekturen zu heben. Wir implementieren Standards, wie man sie heute von führenden Open-Source-Maintainern und modernen Frameworks kennt.

### 🔴 Der Legacy-Zustand (Branch: `main` / `legacy`)
- Manuelles Autoloading via `require_once` und `spl_autoload_register` (Kein Composer).
- Globale Zustände durch das Singleton-Pattern in der Datenbank-Verbindung.
- Implizites URL-Parsing via `explode('/')` in der Core-Klasse.
- Untypisierte Arrays für den Datentransfer zwischen Controllern und Models.
- Hohe zyklomatische Komplexität in Validierungsklassen (verschachtelte `foreach`/`switch`-Blöcke).

### 🟢 Das Ziel-Setup (Refactoring-Branches)
- **Infrastruktur:** Vollständiges PSR-4 Autoloading via Composer.
- **Architektur:** Dependency Injection (DI) Container statt Singletons.
- **Routing:** Deklaratives Routing über moderne PHP Attributes.
- **Domain Logic:** Typsicherheit durch `declare(strict_types=1)`, Readonly Classes, DTOs (Data Transfer Objects) und Constructor Property Promotion.
- **Clean Code:** Einsatz von Enums und Match-Expressions für elegante Business-Logik.

---

## 🗺️ Refactoring Roadmap (Episodenguide)

Der Umbau wird dokumentiert und auf [Medium/Hashnode] sowie LinkedIn begleitet. Für jede Episode wird es einen eigenen Pull Request geben, um den "Vorher-Nachher"-Vergleich im Code transparent nachvollziehen zu können.

- [ ] **Episode 1:** Der Befreiungsschlag – Composer, PSR-4 & das Ende von `require_once`
- [ ] **Episode 2:** Tod dem Singleton – Dependency Injection für die Datenbank
- [ ] **Episode 3:** Bye Bye `explode('/')` – Modernes Routing mit PHP Attributes
- [ ] **Episode 4:** Typsicherheit pur – DTOs, Strict Types & Property Promotion
- [ ] **Episode 5:** Security Shift – Escaping on Output, not Input
- [ ] **Episode 6:** Match Expressions statt `switch`-Monster – Der neue Validator

---

## 🚀 Installation & Lokales Setup (Legacy Version)

Wer sich den ursprünglichen Code ansehen oder lokal ausführen möchte:

1. Repository klonen:
   ```bash
   git clone [https://github.com/DEIN_USERNAME/postbox.git](https://github.com/DEIN_USERNAME/postbox.git)

```

2. Datenbank einrichten:
* Erstelle eine lokale MySQL-Datenbank namens `FIT4U` (oder passe den Namen an).
* *Hinweis: Ein SQL-Dump für die Tabellenstruktur (`users`, `posts`) folgt.*


3. Konfiguration anpassen:
* Öffne `app/config/config.php` und passe `DB_HOST`, `DB_USER` und `DB_PW` an deine lokale Umgebung (z.B. MAMP/XAMPP/Docker) an.
* Passe den `URLROOT` an deinen lokalen Serverpfad an.



---

## 📬 Folge der Reise

Lass gerne einen ⭐ da, wenn du das Refactoring verfolgen willst.
Die ausführlichen Architektur-Artikel zu den einzelnen Pull Requests veröffentliche ich hier:

* 📝 **Artikel-Serie:** [Link zu deinem Medium/Hashnode Profil - Platzhalter]
* 💼 **Updates & Diskussionen:** [Link zu deinem LinkedIn Profil - Platzhalter]
* 🎥 **Video-Tutorials:** [Link zu deinem YouTube Kanal - Platzhalter]

```

