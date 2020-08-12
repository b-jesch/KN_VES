<?php

# Prolog

if (!defined('CONTEXT')) {
    require '../config.php';
    header('Location: ' . ROOT);
    exit();
}

?>
<form name="n" id="n" action="<?php echo CONTROLLER; ?>" method="post">
    <div class="content" type="large">
        <h1><?php echo $title; ?></h1>
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
                    <input type="date" class="short" name="event_date" id="event_date" form="n" required>
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="event">Event:</label>
                </td>
                <td>
                    <input type="text" class="short" name="event" id="event" form="n" required>
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="genre">Genre:</label>
                </td>
                <td>
                    <input type="text" class="short" name="genre" id="genre" form="n" required>
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="web">Website:</label>
                </td>
                <td>
                    <input type="text" class="long" name="web" id="web" form="n" required>
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
                    <input type="text" class="long" name="stream" id="stream" form="n">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="isyoutube">Youtube Link:</label>
                </td>
                <td>
                    <input type="checkbox" name="isyoutube" id="isyoutube" form="n">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="from">gültig ab:</label>
                </td>
                <td>
                    <input type="datetime-local" class="short" name="from" id="from" form="n">&nbsp;YYYY-MM-DD&nbsp;HH:MM
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="to">gültig bis:</label>
                </td>
                <td>
                    <input type="datetime-local" class="short" name="to" id="to" form="n">&nbsp;YYYY-MM-DD&nbsp;HH:MM
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="permalink">dauerhaft gültig (Permastream):</label>
                </td>
                <td>
                    <input type="checkbox" name="permalink" id="permalink" form="n">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="icon">Icon URL:</label>
                </td>
                <td>
                    <input type="text" class="long" name="icon" id="icon" form="n">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="fanart">Poster URL:</label>
                </td>
                <td>
                    <input type="text" class="long" name="fanart" id="fanart" form="n">
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

