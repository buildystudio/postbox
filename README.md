
# 📦 Warum Software neu schreiben meistens ein Fehler ist

## (Refactoring Praxisberichte) 


Willkommen bei **PostBox** – einem Full-OOP PHP Content Management System. Dieses Repository zeigt den ursprünglichen Stand eines studentischen Projekts aus dem Jahr 2019. Heute dient es als Basis für eine öffentliche Case Study zum Thema Software-Modernisierung und Refactoring.

## 🎯 Der Status Quo: PHP im Jahr 2019

Dieses Projekt ist eine Zeitkapsel. Es zeigt eine Architektur, die ohne moderne Paketverwaltung oder standardisiertes Autoloading auskommt.

### 🔴 Der Legacy-Zustand (Branch: `main`)


**Kein Composer:** Alle Abhängigkeiten sind fest im Projekt verbaut.

**require_once-Hölle:** Klassen werden manuell über einen gigantischen Include-Block geladen.

**Singleton-Pattern:** Die Datenbankverbindung wird über globale Zustände verwaltet.

**Server-Abhängigkeit:** Das Routing verlässt sich auf spezifische Apache `.htaccess`-Konfigurationen.

**Verschachtelte Logik:** Hohe Komplexität in Validierungsklassen durch klassische `switch`/`if`-Strukturen.

---

## 🗺️ Modernisierungs-Roadmap

Ich führe diese Codebase Schritt für Schritt ins Jahr 2026. Jede Phase wird als eigene Episode dokumentiert:


**Episode 1:** Einführung von Composer & PSR-4 Autoloading.

**Episode 2:** Refactoring der Datenbank zu Dependency Injection.

**Episode 3:** Modernes Routing mit PHP Attributes.

**Episode 4:** Einführung von Typsicherheit und DTOs.

**Episode 5:** Security-Updates (Modern Escaping & CSRF).

**Episode 6:** Optimierung der Business-Logik mit modernen PHP-Features.

---

## 🚀 Installation (Legacy Version)

1. **Repository klonen:**
```bash
git clone https://github.com/buildystudio/postbox.git

```


2. **Datenbank:** Erstelle eine lokale MySQL-Datenbank namens `postbox`.
3. **Konfiguration:** Passe die Zugangsdaten in `app/config/config.php` an dein lokales Setup an.

---

## 📬 Begleite das Refactoring

Ich teile die detaillierten Architektur-Entscheidungen und den "Vorher-Nachher"-Vergleich auf LinkedIn und Medium:

* 💼 **LinkedIn:** [Dinko Djurkovic](https://www.google.com/search?q=https://www.linkedin.com/in/dinko-d-7155673b1) 


* ✍️ **Case Study:** [Ausführliche Berichte auf Medium](https://www.google.com/search?q=https://medium.com/%40buildy.studio/warum-software-neu-schreiben-meistens-ein-fehler-ist-5ba4704f8d67) 



---

**Soll ich dir jetzt dabei helfen, einen SQL-Export (Dump) deiner aktuellen Tabellenstruktur zu erstellen, damit andere das Projekt direkt lokal testen können?**
