<?php

# Prolog

if (!defined('CONTEXT')) {
    require '../config.php';
    header('Location: ' . ROOT);
    exit();
}


if (isset($c_pars['item'])) {

    $ev = new Event();
    $ev->read($c_pars['item']);
    $ids = $ev->event['user_id'];
    $id = array_shift($ids);
    if (in_array($_SESSION['id'], $ev->event['user_id'])) {

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
                        <td class="desc_form">
                            <label for="id">Kodinerds User ID:</label>
                        </td>
                        <td>
                            <input type="text" class="short" name="id" id="id" form="n"
                                   value="<?php echo $id;  ?>" readonly>
                            <span class="desc_form">weitere:</span>
                            <input type="text" class="short" name="contributors" id="contributors" form="n"
                                   value="<?php echo implode(', ', $ids); ?>"
                                   title="weitere User-IDs, die das Event bearbeiten dürfen">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><hr></td>
                    </tr>
                    <tr>
                        <td class="desc_form">
                            <label for="event_date">Startdatum:</label>
                        </td>
                        <td>
                            <input type="date" class="short" name="event_date" id="event_date" form="n"
                                   value="<?php echo $ev->event['event_date']; ?>" required
                                   title="Startdatum des Events, Pflichtfeld">
                        </td>
                    </tr>
                    <tr>
                        <td class="desc_form">
                            <label for="event">Event:</label>
                        </td>
                        <td>
                            <input type="text" class="short" name="event" id="event" form="n"
                                   value="<?php echo $ev->event['event']; ?>" required
                                   title="Titel des Events, Pflichtfeld">
                        </td>
                    </tr>
                    <tr>
                        <td class="desc_form">
                            <label for="genre">Genre:</label>
                        </td>
                        <td>
                            <input type="text" class="short" name="genre" id="genre"
                                   value="<?php echo $ev->event['genre']; ?>" form="n" required
                                   title="Genre oder Kategorie des Events, Pflichtfeld">
                        </td>
                    </tr>
                    <tr>
                        <td class="desc_form">
                            <label for="web">Website:</label>
                        </td>
                        <td>
                            <input type="text" class="long" name="web" id="web" form="n"
                                   value="<?php echo $ev->event['web']; ?>"
                                   title="Webseite, die das Event bekannt gibt, Pflichtfeld">
                        </td>
                    </tr>
                    <tr><td colspan="2"><hr></td></tr>
                    <tr>
                        <td class="desc_form">
                            <label for="stream">Stream URL:</label>
                        </td>
                        <td>
                            <input type="text" class="long" name="stream" id="stream" form="n"
                                   value="<?php echo $ev->event['stream']; ?>"
                                   title="URL des M3U(8) Streams oder des Youtube Streams">
                        </td>
                    </tr>
                    <tr>
                        <td class="desc_form">
                            <label for="iseditable">Stream URL änderbar:</label>
                        </td>
                        <td>
                            <input type="checkbox" name="iseditable" id="iseditable" form="n"
                                <?php echo ($ev->event['iseditable']) ? ' checked' : ''; ?>
                                   title="Stream URL darf nachträglich durch andere User geändert/korrigiert werden">
                        </td>
                    </tr>
                    <tr>
                        <td class="desc_form">
                            <label for="isyoutube">Youtube Link:</label>
                        </td>
                        <td>
                            <input type="checkbox" name="isyoutube" id="isyoutube" form="n"
                                <?php echo ($ev->event['isyoutube']) ? ' checked' : ''; ?>
                                   title="Zum Abspielen des Streams Youtube Downloader verwenden">
                        </td>
                    </tr>
                    <tr>
                        <td class="desc_form">
                            <label for="from">gültig ab:</label>
                        </td>
                        <td>
                            <input type="datetime-local" class="short" name="from" id="from" form="n"
                                   value="<?php echo str_replace(' ', 'T', $ev->event['from']); ?>"
                                   title="Datums-/Zeitformat YYYY-MM-DD HH:MM für Firefox und Safari">&nbsp;YYYY-MM-DD&nbsp;HH:MM
                        </td>
                    </tr>
                    <tr>
                        <td class="desc_form">
                            <label for="to">gültig bis:</label>
                        </td>
                        <td>
                            <input type="datetime-local" class="short" name="to" id="to" form="n"
                                   value="<?php echo str_replace(' ', 'T', $ev->event['to']); ?>"
                                   title="Datums-/Zeitformat YYYY-MM-DD HH:MM für Firefox und Safari">&nbsp;YYYY-MM-DD&nbsp;HH:MM
                        </td>
                    </tr>
                    <tr>
                        <td class="desc_form">
                            <label for="permalink">dauerhaft gültig (Permastream):</label>
                        </td>
                        <td>
                            <input type="checkbox" name="permalink" id="permalink" form="n"
                            <?php echo ($ev->event['permalink']) ? ' checked' : ''; ?>
                                   title="24/7 Stream ohne Zeitbegrenzung">
                        </td>
                    </tr>
                    <tr>
                        <td class="desc_form">
                            <label for="icon">Icon URL:</label>
                        </td>
                        <td>
                            <input type="text" class="long" name="icon" id="icon" form="n"
                                   value="<?php echo $ev->event['icon']; ?>"
                                   title="Icon URL des Events, wird als Cover oder Poster verwendet">
                        </td>
                    </tr>
                    <tr>
                        <td class="desc_form">
                            <label for="fanart">Poster URL:</label>
                        </td>
                        <td>
                            <input type="text" class="long" name="fanart" id="fanart" form="n"
                                   value="<?php echo $ev->event['fanart']; ?>"
                                   title="Fanart URL des Events, wird als Hintergrund verwendet">
                        </td>
                    </tr>
                    <tr>
                        <td class="desc_form" va="top">
                            <label for="plot">Beschreibung:</label>
                        </td>
                        <td>
                            <textarea name="plot" id="plot" form="n"><?php echo $ev->event['plot']; ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="center">
                            <input class="button" type="submit" name='add' title="Änderungen auf dem Server speichern" value="Speichern">
                            <input class="button" type="button" name='abort' title="zurück zur Liste" value="Abbrechen"
                                   onclick="document.location.href='?site=list_event';">
                        </td>
                    </tr>
                </table>
            </div>
            <input type="hidden" name="item" value="<?php echo $ev->event['id']; ?>">
        </form>

        <?php
    }
}
