<?php

# Prolog

if (!defined('CONTEXT')) {
    require '../config.php';
    header('Location: ' . ROOT);
    exit();
}

?>
<form name="n" id="n" action="<?php echo CONTROLLER; ?>" method="post" enctype="multipart/form-data">
    <div class="content" type="large">
        <h1><?php echo TITLE.'Eventdaten erfassen'; ?></h1>
        <p>Hier werden anstehende Events in die Datenbank aufgenommen. Du kannst diese Daten noch nachträglich
            ändern. Zur Identifikation wird Deine User-ID herangezogen. Zusätzlich dürfen auch weitere User das
            Event bearbeiten, wenn Du deren User-ID im Feld "weitere" einträgst.
        </p>
        <hr>
        <table>
            <tr>
                <td class="desc_form"><label for="id">Kodinerds User ID:</label></td>
                <td>
                    <input type="text" class="short" name="id" id="id" form="n"
                           value="<?php echo $_SESSION['id'];  ?>" readonly>
                    <span class="desc_form">weitere:</span>
                    <input type="text" class="short" name="contributors" id="contributors" form="n"
                           title="weitere User-IDs, die das Event bearbeiten dürfen">
                </td>
            </tr>
            <tr><td colspan="2"><hr></td></tr>
            <tr>
                <td class="desc_form">
                    <label for="event_date">Startdatum:</label>
                </td>
                <td>
                    <input type="date" class="short" name="event_date" id="event_date" form="n" required
                    title="Startdatum des Events, Pflichtfeld, Datumsformat YYYY-MM-DD für Firefox und Safari""> YYYY-MM-DD
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="event">Event:</label>
                </td>
                <td>
                    <input type="text" class="short" name="event" id="event" form="n" required
                    title="Titel des Events, Pflichtfeld">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="genre">Genre:</label>
                </td>
                <td>
                    <input type="text" class="short" name="genre" id="genre" form="n" required
                    title="Genre oder Kategorie des Events, Pflichtfeld">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="web">Website:</label>
                </td>
                <td>
                    <input type="text" class="long" name="web" id="web" form="n" required
                    title="Webseite, die das Event bekannt gibt, Pflichtfeld">
                </td>
            </tr>
            <tr>
                <td colspan="2"><hr></td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="stream">Stream URL:</label>
                </td>
                <td>
                    <input type="text" class="long" name="stream" id="stream" form="n"
                    title="URL des M3U(8) Streams oder des Youtube Streams">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="iseditable">Stream URL änderbar:</label>
                </td>
                <td>
                    <input type="checkbox" name="iseditable" id="iseditable" checked form="n"
                           title="Stream URL darf nachträglich durch andere User geändert/korrigiert werden">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="isyoutube">Youtube Link:</label>
                </td>
                <td>
                    <input type="checkbox" name="isyoutube" id="isyoutube" form="n"
                    title="Zum Abspielen des Streams Youtube Downloader verwenden">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="from">gültig ab:</label>
                </td>
                <td>
                    <input type="datetime-local" class="short" name="from" id="from" form="n"
                    title="Datums-/Zeitformat YYYY-MM-DD HH:MM für Firefox und Safari">&nbsp;YYYY-MM-DD&nbsp;HH:MM
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="to">gültig bis:</label>
                </td>
                <td>
                    <input type="datetime-local" class="short" name="to" id="to" form="n"
                           title="Datums-/Zeitformat YYYY-MM-DD HH:MM für Firefox und Safari">&nbsp;YYYY-MM-DD&nbsp;HH:MM
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="permalink">dauerhaft gültig (Permastream):</label>
                </td>
                <td>
                    <input type="checkbox" name="permalink" id="permalink" form="n"
                    title="24/7 Stream ohne Zeitbegrenzung">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="icon">Icon/Poster URL:</label>
                </td>
                <td>
                    <input type="text" class="middle" name="icon" id="icon" form="n"
                    title="Icon URL des Events, wird als Cover oder Poster verwendet"> oder:
                    <input class="fileupload" type="file" name='icon_upload' id='icon_upload' accept="image/*"
                           onchange="window.n.icon.value = this.value.replace('C:\\fakepath\\', '');">
                    <label for="icon_upload" class="button" >Hochladen</label>
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="fanart">Fanart URL:</label>
                </td>
                <td>
                    <input type="text" class="middle" name="fanart" id="fanart" form="n"
                    title="Fanart URL des Events, wird als Hintergrund verwendet"> oder:
                    <input class="fileupload" type="file" name='fanart_upload' id='fanart_upload' accept="image/*"
                           onchange="window.n.fanart.value = this.value.replace('C:\\fakepath\\', '');">
                    <label for="fanart_upload" class="button" >Hochladen</label>
                </td>
            </tr>
            <tr>
                <td class="desc_form" va="top">
                    <label for="plot">Beschreibung:</label>
                </td>
                <td>
                    <textarea name="plot" id="plot" form="n" placeholder="Plot..."></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="center">
                    <input class="button" type="submit" name='add' title="Eintrag auf dem Server erstellen" value="Erstellen">
                    <input class="button" type="button" name='abort' title="zurück zur Liste" value="Abbrechen"
                           onclick="document.location.href='?site=list_event';">
                </td>
            </tr>
        </table>
    </div>
    <input type="hidden" name="site" value="collect_2">
    <input type="hidden" name="item" value="<?php echo time(); ?>">
</form>

