<?php

//___________________Main, high level functions_______________________________

function createTemplate(): string
{
    $data = getAll();
    $picsPath = '/wp-content/plugins/BSBA/storage';
    $html = '<div id="BSBA-plugin"><div class="slider_all">';

    foreach($data as $item){
        $html .= '<div class="ba-Slider" style="width:852px;height:480px;" unselectable="on" onselectstart="return false;" onmousedown="return false;">    
        <div id="before"><img src="' . $picsPath . '/before/'. $item->pic_name . '" /></div>
        <div class="slider"></div>
        <div id="after"><img src="' . $picsPath . '/after/'. $item->pic_name . '" /></div>
        </div>';
    }
    $html .= '</div></div>';
    
    return $html;
}

/**
 * 
 */
function photoUpdate(): bool
{
    if(isset($_SESSION)){

        $oldID = $_SESSION['bsba_item_id'];
        $_SESSION['bsba_item_id'] = null;
        
        $oldPicsName = getNameById($oldID);
        $oldPicsPath = str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/BSBA/storage/');
       
        unlink($oldPicsPath . 'before/' . $oldPicsName);
        unlink($oldPicsPath . 'after/'  . $oldPicsName);
        
        if($newPicsName = filesUpload()){
            if(update($oldID, $newPicsName)){
                return true;
            }
        }
    }

    return false;
}

/**
 * 
 */
function photoDelete(int $id): bool
{
    //create path to pics in storage
    $picName = getNameById($id);
    $picsPath = str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/BSBA/storage/');

    //if delete from db...
    if(delete($id)){
        // ...delete pics from storage too
        unlink($picsPath . 'before/' . $picName);
        unlink($picsPath . 'after/'  . $picName);

        return true;
    }
   
    return false;
}

/**
 * upload files on the server &
 * adds one to database
 */
function photoUpload(): bool
{
   if($picsName = filesUpload()){
      return insert($picsName);
   }
}

/**
 * 
 */
function photoRename(int $id, string $newName): bool
{
    $oldName = getNameById($id);

    $picsPath = str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/BSBA/storage/');
    if(update($id, $newName)){
        rename($picsPath . 'before/' . $oldName, $picsPath . 'before/' . $newName);
        rename($picsPath . 'after/'  . $oldName, $picsPath . 'after/'  . $newName);

        return true;
    }

    return false;
}

//_________________Database functions______________________//

function update(int $id, string $pic_name): bool
{
    global $wpdb;
    if($wpdb->update( 'wp_bsba', ['pic_name' => $pic_name], ['id' => $id], ["%s"], ["%d"] )){
        return true;
    }

    return false;
}

/**
 * 
 */
function delete(int $id): bool
{
    global $wpdb;
    if($wpdb->query("DELETE FROM wp_bsba WHERE id = '$id' ")){
        return true;
    }
    
    return false;
}

/**
 * 
 */
function insert(string $picName): bool
{
    global $wpdb;
    if($wpdb->insert('wp_bsba', ['pic_name' => $picName], ["%s"])){
        return true;
    }

    return false;
}

/**
 * 
 */
function getAll(): ?array
{
    global $wpdb;
    return $wpdb->get_results("SELECT id, pic_name FROM wp_bsba");
}

/**
 * 
 */
function getNameById(int $id): ?string
{
    global $wpdb;
    if($data = $wpdb->get_results("SELECT pic_name FROM wp_bsba WHERE id= '$id' ")){
        foreach($data as $item){
            return $item->pic_name;
        }
    }

    return null;
}

//____________________Additional functions_________________________________//

// Uploads photoes & return files common name
// or return null in case falt
function filesUpload(): ?string
{
    $beforeUploadedFlag = false;
    $afterUploadedFlag  = false;
 
    /** Check if the file was choosen */
    if($_FILES['before']['error'] > 0 || $_FILES['after']['error'] > 0) {
        return false;
    } else {

        //generate files common name with `salt`
        $picsName = getSalt() . '_' . $_POST['name'] . '.jpg';

        /** Set up valid image extensions */
        $extsAllowed = ['jpg', 'jpeg', 'png', 'gif'];
        $extUploadBefore = strtolower( substr( strrchr($_FILES['before']['name'], '.'), 1)) ;
        $extUploadAfter  = strtolower( substr( strrchr($_FILES['after']['name'], '.'), 1)) ;

        /** Check is the uploaded `before` file extension is allowed */
        if(in_array($extUploadBefore, $extsAllowed)){
            // rename `before` pictures
            $_FILES['before']['name'] = $picsName;

            /** Upload  files on the server */
            $beforeUploadedFlag = move_uploaded_file($_FILES['before']['tmp_name'], '../storage/before/' . $_FILES['before']['name']);
        }

        /** Check is the uploaded `after` file extension is allowed */
        if(in_array($extUploadAfter, $extsAllowed)){
            // rename `after` picture
            $_FILES['after']['name'] = $picsName;

            /** Upload  files on the server */
            $afterUploadedFlag = move_uploaded_file($_FILES['after']['tmp_name'], '../storage/after/' . $_FILES['after']['name']);
        }
        // if both pics already uploaded to `storage` 
        // folder, write them uri path in database
        if($beforeUploadedFlag && $afterUploadedFlag){
            return $picsName;
        }
    }

    return null;
}

/**
 *
 */
function getBlockName(string $picName): string
{
    $arr = explode('_', $picName);
    $arr = explode('.', $arr[1]);
    
    return $arr[0];
}

/**
 * 
 */
function getSalt(): string
{
    return substr(md5(rand()), 0, 3);
}




