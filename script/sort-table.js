
function sortcol(n) {
    const tbody = $("#restable");

    let asc = $(this).attr("sort");

    if (asc === "1") {
        asc = "0";
    } else {
        asc = "1";
    }

    $(this).attr("sort", asc);

    tbody.find("tr").sort(function (a, b) {
        return (asc === "1") ?
            $(`td:nth-child(${n})`, a).text()
                .localeCompare($(`td:nth-child(${n})`, b).text(), undefined, {numeric: true}) :
            $(`td:nth-child(${n})`, b).text()
                .localeCompare($(`td:nth-child(${n})`, a).text(), undefined, {numeric: true});

    }).appendTo(tbody);
}