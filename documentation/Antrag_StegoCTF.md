**Martin Rammerstorfer, 3BHITM**

# StegoCTF

**Eine Seite speziell für auf Steganografie basierende CTFs („Capture the Flag“)**

## USP

Da Steganografie-Aufgaben bei vielen CTF-Websites selten bis gar nicht vorkommen, finden diese bei StegoCTF gesammelt Platz.

## UI & UX

Der Benutzer kann über Filtermöglichkeiten nach Aufgaben suchen. Jede Aufgabe ist je nach Schwierigkeit unterschiedlich viele Punkte wert und man kann sehen, wer sie wann gelöst hat. Die Aufgaben beinhalten Dateien, in denen eine Flag versteckt ist. Nach Eingabe der korrekten Flag können Bewertung und Kommentar abgegeben und die Kommentare anderer gelesen werden. Auf dem Leaderboard kann man sich sich mit anderen Nutzern der Seite vergleichen sowie deren Profile und Statistiken einsehen.

## Coder Plan

Der Datei-Download und das Rendern von Statistiken auf den Nutzerprofilen wird wahrscheinlich über JavaScript-Libaries umgesetzt.

In der Datenbank werden die Nutzerdaten (Name, Passwort, Team, gelöste Aufgaben mit Datum ...) und Daten über die Aufgaben (Beschreibung, Kategorie, Bewertungen ...) gespeichert.
