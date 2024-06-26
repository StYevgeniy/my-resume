"use strict"

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form');
    form.addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();

        let error = formValidate(form);

        let formData = new FormData(form);
        formData.append('image', formImage.files[0]);

        if (error === 0) {
            form.classList.add('_sending');
            let response = await fetch("sendmail.php", {
              method: "POST",
              body: formData,
            });
            if (response.ok) {
                let result = await response.json();
                alert(result.message);
                formPreview.innerHTML = '';
                form.reset();
                form.classList.remove('_sending');
            } else {
                alert("Error");
                form.classList.remove("_sending");
            }
            
        } else {
            alert('Fill in required fields');
        }
    }

    function formValidate(form) {
        let error = 0;
        let formReq = document.querySelectorAll('._req');

        for (let index = 0; index < formReq.length; index++) {
            const input = formReq[index];
            formRemoveError(input);

            if (input.classList.contains('_email')) {
                if (emailTest(input)) {
                    formAddError(input);
                    error++;
                }
            } else if (input.getAttribute('type') === "checkbox" && input.checked === false) {
                formAddError(input);
                error++;
            } else {
                if (input.value === '') {
                    formAddError(input);
                    error++;
                }
            }
        }
        return error;

    }
    function formAddError(input) {
        input.parentElement.classList.add("_error");
        input.classList.add("_error");
    }
    function formRemoveError(input) {
        input.parentElement.classList.remove('_error');
        input.classList.remove('_error');
    }
    //Function test emsil
    function emailTest(input) {
        return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value);
    }

    //We get input file into a varirble
    const formImage = document.getElementById('formImage');

    const formPreview = document.getElementById("formPreview");

    //Listening to chages in the input
    formImage.addEventListener('change', () => {
        uploadFile(formImage.files[0]);
    });

    function uploadFile(file) {
        //Checking the file type
        if (!['image/jpeg', 'image/jpg', 'image/png', 'image/doc', 'image/docx', 'image/pdf'].includes(file.type)) {
            alert('Allowed images (jpeg. jpg, png) and documets (doc, docx, pdf)');
            formImage.value = '';
            return;
        }
        //Checking the file size (< 2 Mb)
        if (file.size > 2 * 1024 * 1024) {
            alert('The file must be less than 2 Mb')
            return;
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            formPreview.innerHTML = `<img src="${e.target.result}" alt="Photo">`;
        };
        reader.onerror = function (e) {
            alert('Error');
        };
        reader.readAsDataURL(file);
    }

});