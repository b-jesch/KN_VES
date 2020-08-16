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