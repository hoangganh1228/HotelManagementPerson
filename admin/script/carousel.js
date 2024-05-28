let carousel_s_form = document.getElementById("carousel_s_form");
let carousel_picture_inp = document.getElementById("carousel_picture_inp")


carousel_s_form.addEventListener('submit', function(e) {
    e.preventDefault();
    add_image();
})

function add_image() {
    let data = new FormData();
    data.append('picture', carousel_picture_inp.files[0]);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true); // yêu cầu là một yêu cầu POST (được xác định bằng "POST"). Địa chỉ URL mà yêu cầu sẽ được gửi đến là "ajax/settings_crud.php". Tham số thứ ba là true, nó cho biết yêu cầu là không đồng bộ.
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded') //đặt một tiêu đề HTTP cho yêu cầu. Trong trường hợp này, tiêu đề 'Content-Type' được thiết lập là 'application/x-www-form-urlencoded'. Điều này cho biết dữ liệu gửi đi sẽ được mã hóa dưới dạng x-www-form-urlencoded, là cách thông thường để gửi dữ liệu biểu mẫu qua mạng.   
    

    xhr.onload = function() {
        var myModal = document.getElementById('carousel-s');
        var modal = bootstrap.Modal.getInstance(myModal);

        modal.hide();

        if(this.responseText == 'inv_img') {
            alert('error', 'Only JPG and PNG images are allowed!');
        } else if(this.responseText == 'inv_size') {
            alert('error', 'Image should be less than 2 MB!');

        } else if(this.responseText == 'upd_failed') {
            alert('error', 'Image upload failed. Server Down!');

        } else {
            alert('success', 'New Image added!');
            carousel_picture_inp.value='';
            get_carousel();
        }
        
    }

    xhr.send(data);
}

function add_image() {
    let data = new FormData();
    data.append('picture', carousel_picture_inp.files[0]);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true); // yêu cầu là một yêu cầu POST (được xác định bằng "POST"). Địa chỉ URL mà yêu cầu sẽ được gửi đến là "ajax/settings_crud.php". Tham số thứ ba là true, nó cho biết yêu cầu là không đồng bộ.
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded') //đặt một tiêu đề HTTP cho yêu cầu. Trong trường hợp này, tiêu đề 'Content-Type' được thiết lập là 'application/x-www-form-urlencoded'. Điều này cho biết dữ liệu gửi đi sẽ được mã hóa dưới dạng x-www-form-urlencoded, là cách thông thường để gửi dữ liệu biểu mẫu qua mạng.   
    

    xhr.onload = function() {
        var myModal = document.getElementById('carousel-s');
        var modal = bootstrap.Modal.getInstance(myModal);

        modal.hide();

        if(this.responseText == 'inv_img') {
            alert('error', 'Only JPG and PNG images are allowed!');
        } else if(this.responseText == 'inv_size') {
            alert('error', 'Image should be less than 2 MB!');

        } else if(this.responseText == 'upd_failed') {
            alert('error', 'Image upload failed. Server Down!');

        } else {
            alert('success', 'Image added!');
            carousel_picture_inp.value='';
            get_carousel();
        }
        
    }

    xhr.send(data);
}

function get_carousel() {
    let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/carousel_crud.php", true); // yêu cầu là một yêu cầu POST (được xác định bằng "POST"). Địa chỉ URL mà yêu cầu sẽ được gửi đến là "ajax/settings_crud.php". Tham số thứ ba là true, nó cho biết yêu cầu là không đồng bộ.
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded') //đặt một tiêu đề HTTP cho yêu cầu. Trong trường hợp này, tiêu đề 'Content-Type' được thiết lập là 'application/x-www-form-urlencoded'. Điều này cho biết dữ liệu gửi đi sẽ được mã hóa dưới dạng x-www-form-urlencoded, là cách thông thường để gửi dữ liệu biểu mẫu qua mạng.
        

        xhr.onload = function() {
            document.getElementById('carousel-data').innerHTML = this.responseText;
        }

        xhr.send('get_carousel');
}


function rem_image(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true); // yêu cầu là một yêu cầu POST (được xác định bằng "POST"). Địa chỉ URL mà yêu cầu sẽ được gửi đến là "ajax/settings_crud.php". Tham số thứ ba là true, nó cho biết yêu cầu là không đồng bộ.
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded') //đặt một tiêu đề HTTP cho yêu cầu. Trong trường hợp này, tiêu đề 'Content-Type' được thiết lập là 'application/x-www-form-urlencoded'. Điều này cho biết dữ liệu gửi đi sẽ được mã hóa dưới dạng x-www-form-urlencoded, là cách thông thường để gửi dữ liệu biểu mẫu qua mạng.

    xhr.onload = function() {
        if(this.responseText==1) {
            alert('success', 'Image removed!');
            get_carousel();
        } else {
            alert('error', 'Server down!')
        }
    }

    xhr.send('rem_image='+val);
}

window.onload = function() {
    get_carousel();
}