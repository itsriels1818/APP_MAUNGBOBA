const searchInput =
document.getElementById("searchInput");


function doSearch(){

    const value =
    searchInput.value.trim();

    if(value == ""){

        window.location.href =
        "index.php";

    }else{

        window.location.href =
        "index.php?search=" +
        encodeURIComponent(value);

    }

}

/* Klik tombol search */

if(searchBtn){

    searchBtn.addEventListener(
    "click",
    doSearch
    );

}

/* Tekan Enter */

if(searchInput){

    searchInput.addEventListener(
    "keypress",
    function(e){

        if(e.key === "Enter"){

            e.preventDefault();

            doSearch();

        }

    });

}