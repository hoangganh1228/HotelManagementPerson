<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();

    // if(isset($_POST['add_room'])) {
    //     $frm_data = filteration($_POST);

    //     print_r($frm_data);
    // }

    if(isset($_POST['get_users'])) {
        // $res = select('user_cred');
        $i = 1;

        $data = "";

        while($row = mysqli_fetch_assoc($res)) {
            if($row['status'] == 1) {
                $status = "
                    <button onclick='toggle_status($row[id], 0)' class='btn btn-dark btn-sm shadow-none'>
                        active
                    </button>
                ";
            } else {
                $status = "
                    <button onclick='toggle_status($row[id], 1)' class='btn btn-warning btn-sm shadow-none'>
                        inactive
                    </button>
                ";  
            }

            
            $data .= "
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>$row[name]</td>
                    <td>$row[area] sq. ft.</td>
                    <td>
                        <span class='badge rounded-pill bg-light text-dark'>
                            Adult: $row[adult]
                        </span> <br>
                        <span class='badge rounded-pill bg-light text-dark'>
                            Children: $row[children]
                        </span>
                    </td>
                    <td>$row[price] VND</td>
                    <td>$row[quantity]</td>  
                    <td>$status</td>
                      <td>
                        <button type='button' onclick='edit_details($row[id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-room'>
                            <i class='bi bi-pencil-square'></i> 
                        </button>
                        <button type='button' onclick=\"room_images($row[id], '$row[name]')\" class='btn btn-info shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#room-images'>
                            <i class='bi bi-images'></i> 
                        </button>
                        <button type='button' onclick='remove_room($row[id])' class='btn btn-danger shadow-none btn-sm'>
                            <i class='bi bi-trash'></i> 
                        </button>
                    </td>
                </tr>
            ";
            $i++;
        }


        echo $data;
    }

    // if(isset($_POST['toggle_status'])) {
    //     $frm_data = filteration($_POST);

    //     $q = "UPDATE `rooms` SET `status`=? WHERE `id`=?";
    //     $v = [$frm_data['value'], $frm_data['toggle_status']];
    
    //     if(update($q, $v, 'ii')) {
    //         echo 1;
    //     } else {
    //         echo 0;
    //     }
    // }

    // if(isset($_POST['remove_room'])) {
    //     $frm_data = filteration($_POST);
        
    //     $res1 = select("SELECT * FROM `room_images` WHERE `room_id`=?", [$frm_data['room_id']], 'i');

    //     while($row = mysqli_fetch_assoc($res1)) {
    //         deleteImage($row['image'], ROOMS_FOLDER);
    //     }

    //     $res2 = delete("DELETE FROM `room_images` WHERE `room_id`=?", [$frm_data['room_id']], 'i');
    //     $res3 = delete("DELETE FROM `room_features` WHERE `room_id`=?", [$frm_data['room_id']], 'i');
    //     $res4 = delete("DELETE FROM `room_facilities` WHERE `room_id`=?", [$frm_data['room_id']], 'i');
    //     $res5 = update("UPDATE `rooms` SET `removed`=? WHERE `id`=?", [1,$frm_data['room_id']], 'ii');

    //     if($res2 || $res3 || $res4 || $res5) {
    //         echo 1;
    //     } else {
    //         echo 0; 
    //     }


    // }   
?>