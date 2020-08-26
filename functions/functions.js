function fConfirm() {
    return confirm('Der aktuelle Datensatz wird gelöscht und kann nicht wieder hergestellt werden! Wirklich fortfahren?');
}

function fPrompt(sid) {
    var url =  prompt('Hier kannst Du eine fehlende Stream-URL nachtragen', '');
    if (url != null) {
        document.getElementById("stream_"+sid).value = url;
        document.getElementById(sid).submit();
    } else {
        return false
    }
}

function winBBCopen(url, popup, width, height) {
    var left = (screen.width - width) / 2;
    var top = (screen.height - height) / 2;
    var bbcWin = window.open(url, popup,'menubar=no, location=no, resizable=yes, width=' + width +
        ',height=' + height + ',top=' + top + ',left=' + left);
}