function tambahPertanyaan() {
    var container = document.getElementById("pertanyaanContainer");
    var pertanyaanCount = container.getElementsByTagName("input").length + 1;

    var label = document.createElement("label");
    label.innerHTML = "Pertanyaan " + pertanyaanCount + ":";

    var input = document.createElement("input");
    input.type = "text";
    input.name = "pertanyaan[]";
    input.required = true;

    container.appendChild(label);
    container.appendChild(input);
}
