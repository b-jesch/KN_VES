<?php
# Prolog
if (!defined('CONTEXT')) {
    require 'start.php';
    header('Location: '.ROOT);
    exit();
}
include HEADER;

# Inhalt der View


?>

<div class="main_content">
<form name="n" id="n" action="<?php echo ROOT.CONTROLLER; ?>" method="post">
        <div class="content">
            <h1><?php echo $title; ?></h1>
            <p>Du bist ein Mitglied der Kodinerds Community und möchtest Informationen und Streaming-Details zu interessanten
                Events für das Kodinerds Streaming Addon einpflegen? Dazu benötigen wir von Deinem Kodinerds Account den
                Usernamen sowie Deine User-ID.
            </p>
            <hr>
            <table><tr><td class="desc_form"><label for="user">Kodinerds Username: </td>
                    <td>
                        <input type="text" name="user" id="user" form="n"></label>
                    </td></tr>
                <tr><td class="desc_form"><label for="id">Kodinerds User ID:</td>
                    <td><input type="text" name="id" id="id" form="n"></label>
                    </td></tr>
                <tr><td colspan="2" class="center">
                        <input class="button" type="submit" name='check' value="Check In">
                        <input class="button" type="submit" name='abort' value="Abbrechen">
                    </td></tr>
            </table>
        </div>
</div>
<?php
# Epilog
include FOOTER;