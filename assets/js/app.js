    // /* SEARCH */

    // const searchInput =
    // document.getElementById("searchInput");

    // let searchTimeout;

    // if(searchInput){

    // searchInput.addEventListener("input", function(){

    //     clearTimeout(searchTimeout);

    //     searchTimeout = setTimeout(() => {

    //         const value = this.value;

    //         if(value.trim() == ""){

    //             window.location.href = "index.php";

    //         }else{

    //             window.location.href =
    //             "index.php?search=" +
    //             encodeURIComponent(value);

    //         }

    //     }, 500);

    // });
    // }


    /* QTY MODAL */

    document.addEventListener("click", function(e){

        if(e.target.classList.contains("plus")){

            let input =
            e.target.parentElement
            .querySelector(".qty-input");

            input.value =
            parseInt(input.value) + 1;

        }

        if(e.target.classList.contains("minus")){

            let input =
            e.target.parentElement
            .querySelector(".qty-input");

            if(parseInt(input.value) > 1){

                input.value =
                parseInt(input.value) - 1;

            }

        }

    });


    /* TAMBAH KERANJANG */

    document.addEventListener("submit", function(e){

        const form =
        e.target.closest(".add-cart-form");

        if(form){

            e.preventDefault();

            const submitBtn =
            form.querySelector(".modal-cart-btn");

            submitBtn.disabled = true;

            submitBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm"></span>
            Menambahkan...
            `;

            const formData =
            new FormData(form);

            fetch(form.action,{
                method:"POST",
                body:formData
            })

            .then(res => res.text())

            .then(() => {

                showAlert(
                "Berhasil ditambahkan ke keranjang"
                );

                setTimeout(() => {

                    window.location.href =
                    "index.php";

                }, 500);

            })

            .catch(err => {

                console.log(err);

                submitBtn.disabled = false;

                submitBtn.innerHTML = `
                <i class="bi bi-cart-plus"></i>
                Tambah
                `;

                showAlert(
                "Gagal tambah keranjang"
                );

            });

        }

    });


    /* UPDATE QTY */

    document.addEventListener("click", function(e){

        const btn =
        e.target.closest(".qty-update");

        if(btn){

            e.preventDefault();

            const id =
            btn.dataset.id;

            const aksi =
            btn.dataset.aksi;

            fetch(
            `../process/update_qty.php?id=${id}&aksi=${aksi}&t=${Date.now()}`
            )

            .then(() => {

                setTimeout(() => {

                    window.location.reload();

                }, 100);

            });

        }

    });


    /* CHECKOUT */

    document.addEventListener("click", function(e){

        const checkoutBtn =
        e.target.closest("#checkoutBtn");

        if(checkoutBtn){

            const nama =
            document.getElementById("nama_pemesan").value;

            if(nama.trim() == ""){

                showAlert(
                "Nama pemesan wajib diisi"
                );

                return;

            }

            checkoutBtn.disabled = true;

            checkoutBtn.innerHTML = `
            <span class="spinner-border spinner-border-sm"></span>
            Memproses...
            `;

            const formData =
            new FormData();

            formData.append(
            "nama",
            nama
            );

            fetch("../process/checkout.php",{
                method:"POST",
                body:formData
            })

            .then(async res => {

                const text =
                await res.text();

                try{

                    return JSON.parse(text);

                }catch(e){

                    console.log(text);

                    throw new Error(
                    "Response bukan JSON"
                    );

                }

            })

            .then(data => {

                /* SUCCESS */

                if(data.status == "success"){

                    checkoutBtn.disabled = false;

                    checkoutBtn.innerHTML =
                    '<i class="bi bi-check2-circle"></i> Checkout';

                    showAlert(
                    "Checkout berhasil • Antrian #"
                    + data.antrian
                    );

                    window.scrollTo({
                        top:0,
                        behavior:"smooth"
                    });

                    setTimeout(() => {

    location.reload();

}, 1500);

                }

                /* KERANJANG KOSONG */

                else if(data.status == "kosong"){

                    showAlert(
                    "Keranjang kosong"
                    );

                    checkoutBtn.disabled = false;

                    checkoutBtn.innerHTML =
                    '<i class="bi bi-check2-circle"></i> Checkout';

                }

                /* ERROR */

                else{

        checkoutBtn.disabled = false;

        checkoutBtn.innerHTML =
        '<i class="bi bi-check2-circle"></i> Checkout';

        showAlert(
        data.message
        );

    }

            })

            .catch(err => {

                console.log(err);

                checkoutBtn.disabled = false;

                checkoutBtn.innerHTML =
                '<i class="bi bi-check2-circle"></i> Checkout';

                showAlert(
                "Checkout gagal"
                );

            });

        }

    });


    /* AUTO HIDE ALERT */

    const customAlert =
    document.querySelector(".custom-alert");

    if(customAlert){

        setTimeout(() => {

            customAlert.classList.add("hide");

            setTimeout(() => {

                customAlert.remove();

            }, 300);

        }, 2000);

    }


    document.addEventListener("click", function(e){

    const btn =
    e.target.closest(".delete-cart");

    if(btn){

    e.preventDefault();

    Swal.fire({

    title:'Hapus Produk?',

    text:'Produk akan dihapus dari keranjang',

    icon:'warning',

    showCancelButton:true,

    confirmButtonColor:'#111827',

    cancelButtonColor:'#dc2626',

    confirmButtonText:'Hapus',

    cancelButtonText:'Batal'

    }).then((result)=>{

    if(result.isConfirmed){

    window.location.href =
    btn.href;

    }

    });

    }

    });


    /* MOBILE CART */

    const mobileCart =
    document.querySelector(".mobile-cart");

    if(mobileCart){

        mobileCart.addEventListener("click", function(){

            document.getElementById("cart-area")
            .scrollIntoView({
                behavior:"smooth"
            });

        });

    }


    /* ALERT */

    function showAlert(text){

        const oldAlert =
        document.querySelector(".custom-alert");

        if(oldAlert){

            oldAlert.remove();

        }

        const alertBox =
        document.createElement("div");

        alertBox.className =
        "custom-alert";

        alertBox.innerHTML = `
        <i class="bi bi-check-circle-fill"></i>
        ${text}
        `;

        document.body.appendChild(alertBox);

        setTimeout(() => {

            alertBox.classList.add("hide");

            setTimeout(() => {

                alertBox.remove();

            }, 300);

        }, 2000);

    }

    /* ACTIVE MENU */

    const menuItems =
    document.querySelectorAll('.sidebar-menu li');

    const sections =
    document.querySelectorAll('#semua,#minuman,#makanan');

    if(menuItems.length > 0){

    window.addEventListener('scroll', () => {

        let current = 'semua';

        sections.forEach(section => {

            const sectionTop =
            section.offsetTop - 200;

            if(window.scrollY >= sectionTop){

                current =
                section.getAttribute('id');

            }

        });

        menuItems.forEach(item => {

            item.classList.remove(
            'active-menu'
            );

            const link =
            item.querySelector('a');

            if(
            link &&
            link.getAttribute('href')
            === '#' + current
            ){

                item.classList.add(
                'active-menu'
                );

            }

        });

    });

    }


    /* MODAL CLEANUP */

    document.addEventListener(
    'hidden.bs.modal',
    function () {

        document.body.classList.remove(
        'modal-open'
        );

        document.body.style = '';

        document
        .querySelectorAll('.modal-backdrop')
        .forEach(el => el.remove());

    });


    /* SEARCH MODAL */

    const searchModal =
    document.getElementById("searchModal");

    if(searchModal){

        window.addEventListener("load", function(){

            const modal =
            new bootstrap.Modal(
            searchModal
            );

            modal.show();

        });

    }