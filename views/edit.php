<?php
# Prolog
if (!defined('CONTEXT')) {
    require 'start.php';
    header('Location: '.ROOT);
    exit();
}
include HEADER;

if (isset($c_pars['item'])) {

    $ev = new Event();
    $ev->read($c_pars['item']);
    if ($ev->event['user_id'] == $_SESSION['id']) {

        ?>

        <div class="main_content">
            <form name="n" id="n" action="<?php echo ROOT.CONTROLLER; ?>" method="post">
                <div class="content" type="large">
                    <h1><?php echo $title; ?></h1>
                    <p>Hier werden anstehende Events in die Datenbank aufgenommen. Du kannst diese Daten noch nachträglich
                        ändern. Zur Identifikation wird Deine User-ID herangezogen.
                    </p>
                    <hr>
                    <table><tr><td class="desc_form"><label for="id">Kodinerds User ID: </td>
                            <td>
                                <input type="text" class="short" name="id" id="id" form="n"
                                       value="<?php echo $_SESSION['id'];  ?>"readonly></label>
                            </td></tr>
                        <tr><td colspan="2"><hr></td></tr>
                        <tr><td class="desc_form"><label for="event_date">Startdatum:</td>
                            <td><input type="date" class="short" name="event_date" id="event_date" form="n"
                                       value="<?php echo $ev->event['event_date']; ?>" required></label>
                            </td></tr>
                        <tr><td class="desc_form"><label for="event">Event:</td>
                            <td><input type="text" class="short" name="event" id="event" form="n"
                                       value="<?php echo $ev->event['event']; ?>" required></label>
                            </td></tr>
                        <tr><td class="desc_form"><label for="genre">Genre:</td>
                            <td><input type="text" class="short" name="genre" id="genre"
                                       value="<?php echo $ev->event['genre']; ?>" form="n" required></label>
                            </td></tr>
                        <tr><td colspan="2"><hr></td></tr>
                        <tr><td class="desc_form"><label for="stream">Stream URL:</td>
                            <td><input type="text" class="long" name="stream" id="stream" form="n"
                                       value="<?php echo $ev->event['stream']; ?>"></label>
                            </td></tr>
                        <tr><td class="desc_form"><label for="from">gültig ab:</td>
                            <td><input type="datetime-local" class="short" name="from" id="from" form="n"
                                       value="<?php echo str_replace(' ', 'T', $ev->event['from']); ?>"></label>
                            </td></tr>
                        <tr><td class="desc_form"><label for="to">gültig bis:</td>
                            <td><input type="datetime-local" class="short" name="to" id="to" form="n"
                                       value="<?php echo str_replace(' ', 'T', $ev->event['to']); ?>"></label>
                            </td></tr>
                        <tr><td class="desc_form"><label for="to">dauerhaft gültig (Permastream):</td>
                            <td><input type="checkbox" class="permalink" name="permalink" id="permalink" form="n"
                                <?php echo ($ev->event['permalink']) ? ' checked' : ''; ?> ></label>
                            </td></tr>
                        <tr><td class="desc_form"><label for="icon">Icon URL:</td>
                            <td><input type="text" class="long" name="icon" id="icon" form="n"
                                       value="<?php echo $ev->event['icon']; ?>"></label>
                            </td></tr>
                        <tr><td class="desc_form"><label for="fanart">Poster URL:</td>
                            <td><input type="text" class="long" name="fanart" id="fanart" form="n"
                                       value="<?php echo $ev->event['fanart']; ?>"></label>
                            </td></tr>
                        <tr><td class="desc_form"><label for="plot">Beschreibung:</td>
                            <td><textarea name="plot" id="plot" form="n"><?php echo $ev->event['plot']; ?></textarea></label>
                            </td></tr>

                        <tr><td colspan="2" class="center">
                                <input class="button" type="submit" name='add' value="Speichern">
                                <input class="button" type="button" name='abort' value="Abbrechen"
                                       onclick="document.location.href='<?php echo ROOT.'?abort'; ?>';">
                            </td></tr>
                    </table>
                </div>
                <input type="hidden" name="item" value="<?php echo $ev->event['id']; ?>">
            </form>
        </div>

        <?php
    }
}
# Epilog
include FOOTER;