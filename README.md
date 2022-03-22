# SPEED_UP für REDAXO 5

Ein REDAXO-Addon, das durch prefetching und preloading von Artikeln und Kategorien die wahrgenommene Ladezeit ausgewählter Seiten für Website-Besuchende auf wenige Millisekunden reduziert.

> **Hinweis:** Ja, Millisekunden.

> **Use Case:** Dein Kunde hat von seinem selbst ernannten SEO-Experten gehört, wie toll WordPress ist. Bring den SEO-Experten mit der Instllation dieses Addons und der anschließenden Demonstration der Ladezeit ins Schwitzen. Zwinker. Rechne das ganze teuer als Ladezeit-Optimierung ab und [spende dem Addon-Entickler](https://github.com/sponsors/alexplusde) einen Teil vom Kuchen. Zwinker-Zwinker.
 
> **Wichtig:** Dieses Addon hat Auswirkungen darauf, wie Browser nicht nur die aktuelle Seite, sondern auch andere Seiten vorladen und zwischenspeichern. Bitte lies dir aufmerksam durch, welche manuellen Schritte ggf. durch den REDAXO-Entwickler oder Redakteur zu ergreifen sind.

> **Wichtig** Verwende dieses Addon **nicht**, wenn du **serverseitiges Tracking** verwendest, bspw. zur Besuchszahlenmessung. Jedes per Preload/Prefetch geladene Dokument führt dazu, das Tracking zu verfälschen, weil der Server annimmt, die Seite wäre tatsächlich aufgerufen worden. Verwende stattdessen clientseitiges Tracking oder eine Technik, die außerhalb des REDAXO-Artikels bzw. REDAXO-Templates funktioniert, z.B. über die REX_API.

## Features

* **Einfach:** In unter 5 Minuten installiert und eingerichtet
* **Flexibel:** 4 verschiedene Konfigurationsprofile passend zu deinem REDAXO-Projekt, Extension Point zur händischen Optimierung.
* **Sinnvoll:** Entferne einzelne Artikel aus dem automatischen Prefetching, wenn diese dynamische Inhalte darstellen.
* **Kompatibel** Automatische Konfiguration für Instllationen, die das Addon YCom verwenden (beta)
* **Kompatibel** Automatische Konfiguration für Instllationen, die das Addon URL verwenden (geplant)

> **Steuere eigene Verbesserungen** dem [GitHub-Repository von events](https://github.com/alexplusde/speed_up) bei. Oder **unterstütze dieses Addon:** Mit einer [Spende oder Beauftragung unterstützt du die Weiterentwicklung dieses AddOns](https://github.com/sponsors/alexplusde). Es gibt noch weitere Ideen, deine Website zu beschleunigen.

## Installation

Voraussetzung: YRewrite muss installiert und aktiviert sein.

1. Im REDAXO-Installer das Addon `speed_up` herunterladen und installieren. Anschließend erscheint unter `System` ein neuer Menüpunkt `Speed Up`.

2. Wähle bei Bedarf das gewünschte Konfigurationsprofil.

3. Bei der Installation wurde ein Artikel-Metainfo-Feld `speed_up` angelegt. Deaktiviere die Einstellung fürs Prefetching an jedem Artikel, in dem dynamische Inhalte dargestellt werden (z.B. Aufruf mit Get-Parameter, Formulare und deren Zielseiten). Diese willst du schließlich nicht prefetchen. Nein, willst du wirklich nicht.

4. Füge im `<head>`-Bereich deiner Templates möglichst weit oben `$speed_up = new speed_up(); $speed_up->show();` ein, um eine Liste von `<link>`-Attributen auszugeben.

Das war's erstmal.

Ob alles funktioniert, erkennst du mit einem Blick in den Netzwerk-Reiter deiner Browser-Entwicklertools und dem Gefühl, du würdest die angeklickte Seite gerade mit Glasfaser ansurfen und nicht mit deiner DSL 6.000-Leitung, die dir dein Provider maximal zur Verfügung stellen konnte. ;)

## Einstellungen

### Profil

Es gibt mehrere Profile zur Auswahl. Standardmäßig wird das Profil `auto` verwendet. In jedem Fall wird anhand des aktuell aufgerufenen REDAXO-Artikels ermittelt, welche Seiten als nächstes aufgerufen werden könnten.

* `disabled`: Das Addon erzeugt keine Ausgabe
* `custom` (für Experten): Nur die in den Einstellungen hinzufgefügten Codes sowie über den EP veränderten URLs werden berücksichtigt.
* `auto` (empfohlen): Die Startseite, sowie sofern vorhanden:
  * Die beiden Nachbar-Kategorien der aktuellen Kategorie.
  * Die beiden Nachbar-Artikel des aktuellen Artikels.
  * Die erste Kind-Kategorie der aktuellen Kategorie.
* `agressive` (Empfohlen nur zu Demonstrations- und Testzwecken): Die Startseite, sowie sofern vorhanden:
  * Alle Nachbar-Kategorien der aktuellen Kategorie.
  * Alle Nachbar-Artikel des aktuellen Artikels (bei Kategorien: Alle Artikel in der Kategorie).
  * Alle Kind-Kategorien der aktuellen Kategorie.

> **Tipp:** Verwende den Extension Point `PREFETCH_URLS`, um ein Array mit den URLs zu erhalten, die das Addon auf dieser Seite ausgeben wird. Ergänze oder ersetze dieses Array, wenn du mit ziemlicher Sicherheit weißt, welche Seiten als nächstes aufgerufen werden könnten - z.B. bei einer Call-To-Action, eigenen URL-Profilen oder den ersten Elementen einer Liste.

### Zusätzliches Preloading

Zusätzliche hartkodierte Links zu Dateien, die auf jeder Seite sofort geladen werden sollen, z.B. CSS, JS, Webfonts.

### Zusätzliches Prefetching

Zusätzliche hartkodierte Links zu Dateien, die auf jeder Seite früh vorausgeladen werden sollen.

## Fragen und Wissenswertes

### Wie funktioniert prefetching?

Der Browser entscheidet, ...

1. ...anhand der ihm zur Verfügung gestellten `<link>`-Tags im `<head>` deiner Webseite und 
2. der Information darüber, ob man sich in einem schnellen/langsamen oder getakteten/ungetakteten Internet befindet,...

... ob er ein oder mehrere Dokumente und Ressourcen laden soll, noch bevor der Nutzer diese bspw. über einen Link klickt aufrufen möchte.

Erfahre mehr über das Prinzip unter

* https://web.dev/link-prefetch/
* https://3perf.com/blog/link-rels/

### Was ist der Unterschied zwischen prefetching und preloading?

Preloading ist, wenn der Browser ganz zwingend ganz früh wissen sollte, welche Ressourcen (JS, CSS, Webfonts, weitere Medien) für den **aktuellen Seitenaufruf** benötigt werden.

Prefetching ist, wenn der Browser erfahren soll, welche Ressourcen **bei der vermutlich nächsten Interaktion** benötigt werden, z.B. eine Webseite (Dokument) oder andere Ressourcen.

### Warum beeinflusst das Prefetching nicht meinen Google Page Speed Score?

Beim Prefetching werden Dokumente angefordert und vorgehalten, obwohl der Website-Besuchende diese noch nicht angefordert hat. Die tatsächliche Ladezeit der Dokumente, vom Zeitpunkt des Anforderns bis zur vollständigen Serverantwort bleiben hiervon unberührt. Ebenso nicht optimierter Programm-Code, Datenbank-Tabellen und Abfragen, HTML-Code oder Servereinstellungen/Performance. Hier geht es ausschließlich, um die Usability und die wahrgenommene Ladezeit.

Wenn du stattdessen wissen möchtest, wie du auf deiner REDAXO-Website einen Page Speed Score von bis 100 Punkten erreichen kannst, nimm Kontakt mit diesem Addon-Entwickler auf.

## Lizenz

MIT Lizenz, siehe [LICENSE.md](https://github.com/alexplusde/speed_up/blob/master/LICENSE.md)  

## Autoren

**Alexander Walther**  
https://www.alexplus.de
https://github.com/alexplusde

**Projekt-Lead**  
[Alexander Walther](https://github.com/alxndr-w)

## Credits

Danke an den MSG - Erste Hilfe Schule Ludwigsburg zur Beauftragung
