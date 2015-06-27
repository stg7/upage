window.onload = function() {

    var elements = document.getElementsByClassName("bib-entry");
    for(var i = 0; i < elements.length; i++) {
        var element = elements[i];
        console.log(element.id);
        element.onclick = function() {
            var key = this.id;
            console.log(key);
            var pre = document.getElementById("plain-" + key);
            if (pre.style.display == "block") {
                pre.style.display = "none";
            } else {
                pre.style.display = "block";
            }
            return false;
        }
    }
}