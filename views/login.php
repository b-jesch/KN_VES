<?php

# Prolog

if (!defined('CONTEXT')) {
    require '../config.php';
    header('Location: ' . ROOT);
    exit();
}

?>


<form name="n" id="n" action="<?php echo CONTROLLER; ?>" method="post">
    <div class="content">
        <h1><?php echo TITLE.'Check In'; ?></h1>
        <p>Du bist ein Mitglied der Kodinerds Community und möchtest Informationen und Streaming-Details zu interessanten
            Events für das Kodinerds Streaming Addon einpflegen? Du kannst dich mit deinen Kodinerds Zugangsdaten einloggen.
        </p>
        <hr>
        <table>
            <tr>
                <td class="desc_form">
                     <label for="username">Kodinerds Username:</label>
                </td>
                <td>
                    <input type="text" name="username" id="username" form="n">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="password">Kodinerds Password:</label>
                </td>
                <td>
                    <input type="password" name="password" id="password" form="n">
                </td>
            </tr>
            <tr>
                <td class="desc_form">
                    <label for="twofactor">Mehrfaktor-Authentifizierung:</label>
                </td>
                <td>
                    <input type="text" pattern="[0-9]*" minlength="6" maxlength="6" placeholder="123456" size="6" name="twofactor" id="twofactor" form="n">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="center">
                    <input class="button" type="submit" name='check' title="mit den Daten von kodinerds.net einchecken" value="Check In">
                    <input class="button" type="submit" name='abort' value="Abbrechen">
                </td>
            </tr>
        </table>
    </div>
</form>

<div class="footer">Kodinerds Event Server by BJ1, TehTux</div>
