# Bewerber-Checklist<br />
Dieses Plugin lässt euch verschiedene Profiloptionen auswählen, die einem User in der Bewerbungsphase als Pflicht angezeigt werden. Er sieht im Header des Forums eine persönliche "To Do-Liste" und weiß somit, welche vom Team vorgegebenen Punkte er noch nicht erledigt hat. Dabei ist das Eintragen eines Steckbriefs und die Eintragung des Geburtstags optional. Möglich sind bisher folgende Einstellungen:

<ul>
<li> Ist ein Avatar hochgeladen?
<li> Auswahl bestimmter Profilfelder (optional, welche Felder)
<li> Geburtstag eingetragen? (optional)
<li> Steckbrief gepostet? (optional)
</ul>

<h1>Plugin funktionsfähig machen</h1>
<ul>
<li>Die Plugin-Datei ladet ihr in den angegebenen Ordner <b>inc/plugins</b> hoch.
<li>Die Sprachdatei ladet ihr in den angegebenen Ordner <b>inc/languages/deutsch_du</b> hoch.
<li>Das Plugin muss nun im Admin CP unter <b>Konfiguration - Plugins</b> installiert und aktiviert werden
<li>In den Foreneinstellungen findet ihr nun - ganz unten - Einstellungen zu "Bewerber-Checklist". Macht dort eure Einstellungen.
</ul><br />

Das Plugin ist nun einsatzbereit. Solltet ihr schon einiges an eurem Forum gemacht haben, und nicht wie ich im Testdurchlauf ein Default-Theme verwenden, kann es sein, dass nicht alle Variablen eingefügt werden. Sollte euch eine Anzeige fehlen, könnt ihr auf folgende Variablen zurückgreifen:

<blockquote>{$header_checklist}  // Checklist-Kasten im Header
* ruft checklist auf
</blockquote>

<h1>Template-Änderungen</h1>
Folgende Templates werden durch dieses Plugin <i>neu hinzugefügt</i>:
<ul>
<li>checklist
<li>checklist_application_checked
<li>checklist_application_unchecked
<li>checklist_avatar_checked
<li>checklist_avatar_unchecked
<li>checklist_birthday_checked
<li>checklist_birthday_unchecked
<li>checklist_field_checked
<li>checklist_field_unchecked
</ul>

Folgende Templates werden durch dieses Plugin <i>bearbeitet</i>:
<ul>
<li>header
</ul>

<h1>Demo</h1><br />
<center>

<img src="http://fs5.directupload.net/images/170528/u2ea8x5h.jpg" /><br />
http://fs5.directupload.net/images/170528/u2ea8x5h.jpg<br /><br />

<img src="http://fs5.directupload.net/images/170528/42woqhsx.jpg" /><br />
http://fs5.directupload.net/images/170528/42woqhsx.jpg<br /><br />

<img src="http://fs5.directupload.net/images/170528/tg5ggqrt.jpg" /><br />
http://fs5.directupload.net/images/170528/tg5ggqrt.jpg<br /><br />

<img src="http://fs5.directupload.net/images/170528/xm8bh2yz.jpg" /><br />
http://fs5.directupload.net/images/170528/xm8bh2yz.jpg<br /><br />

</center>

Lokal unter MyBB 1.8.8 getestet und es funktionierte alles - da es allerdings nicht im alltäglichen Forengebrauch zum Test kam, kann es natürlich sein, dass es die ersten Härtetests aus diversen Gründen nicht besteht. Sollte es zu Fehlermeldungen oder Problemen kommen, könnt ihr euch jederzeit <b><u>im Support-Thema</u></b> melden. Auch für Ergänzungen und Ideen bin ich immer sehr dankbar. Aus Zeitgründen garantiere ich aber nicht immer zeitnahen Support. 
