

function get_users() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        document.getElementById('users-data').innerHTML = this.responseText;
    };

    xhr.send('get_users');
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.crud.php", true); // yêu cầu là một yêu cầu POST (được xác định bằng "POST"). Địa chỉ URL mà yêu cầu sẽ được gửi đến là "ajax/settings_crud.php". Tham số thứ ba là true, nó cho biết yêu cầu là không đồng bộ.
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded') //đặt một tiêu đề HTTP cho yêu cầu. Trong trường hợp này, tiêu đề 'Content-Type' được thiết lập là 'application/x-www-form-urlencoded'. Điều này cho biết dữ liệu gửi đi sẽ được mã hóa dưới dạng x-www-form-urlencoded, là cách thông thường để gửi dữ liệu biểu mẫu qua mạng.   
    
    
    xhr.onload = function() {
        if(this.responseText==1) {
            alert('success', 'Status toggled!');
            get_users();    
        } else {    
            alert('error', 'Server Down!');

        }
    }

    xhr.send('toggle_status='+id+'&value='+val); 
}

function remove_user(user_id) {
    if(confirm("Are you sure, you want to remove this user?")) {
        let data = new FormData();
        data.append('user_id', user_id);
        data.append('remove_user', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users.crud.php", true); // yêu cầu là một yêu cầu POST (được xác định bằng "POST"). Địa chỉ URL mà yêu cầu sẽ được gửi đến là "ajax/settings_crud.php". Tham số thứ ba là true, nó cho biết yêu cầu là không đồng bộ.
        

        xhr.onload = function() {
            if(this.responseText == 1) {
                alert('success', 'User removed!');
                get_users();
                } 
            else {
                alert('error', 'User removed failed');
            }    
        }
        xhr.send(data);
    }

}

function search_user(username) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        document.getElementById('users-data').innerHTML = this.responseText;
    };

    xhr.send('search_user&name='+username);
}

window.onload = function() {
    get_users();
}
