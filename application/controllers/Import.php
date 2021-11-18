<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Import extends MY_Controller {


    public function file() {
        $fileUrl = 'assets\dich_bo_sung.xlsx';
        if (!empty($fileUrl)) {
            if (ROOT_PATH != '/') $fileUrl = str_replace(ROOT_PATH, '', $fileUrl);
            $fileUrl = FCPATH . $fileUrl;
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($fileUrl);
            $countRows = $spreadsheet->getActiveSheet()->toArray();
            if($countRows > 0){
                $this->load->helper('file');

                $data2 = 'Some file data';
                    
                for ($row = 2; $row <= count($countRows); $row++) {
                    $data = $countRows[$row];
                    if(!empty(trim($data[1]))) {
                        
                        // login

                        // $textCode = makeSlug(trim($data[0]));
                        // $en = trim($data[0]);
                        // $vn = trim($data[1]);
                        // $german = trim($data[2]);
                        // $cz = trim($data[3]);
                        
                        // customer

                        // $textCode = makeSlug(trim($data[5]));
                        // $en = trim($data[5]);
                        // $vn = trim($data[6]);
                        // $german = trim($data[7]);
                        // $cz = trim($data[8]);

                        //business_profile_lang

                        // $textCode = substr(makeSlug(trim($data[10])), 0, 45);
                        // $en = trim($data[10]);
                        // $vn = trim($data[11]);
                        // $german = trim($data[12]);
                        // $cz = trim($data[13]);

                        // user_account_management_lang

                        // $textCode = substr(makeSlug(trim($data[15])), 0, 30);
                        // $en = trim($data[15]);
                        // $vn = trim($data[16]);
                        // $german = trim($data[17]);
                        // $cz = trim($data[18]);

                        //business_management

                        $textCode = substr(makeSlug(trim($data[1])), 0, 30).strtotime("now");
                        // $en = trim($data[1]);
                        // $vn = trim($data[2]);
                        // $german = trim($data[3]);
                        $cz = trim($data[4]);


                        // $testAll = '$lang["'.$textCode.'"] = "'.$en.'";';

                        // $testAll = '$lang["'.$textCode.'"] = "'.$vn.'";';

                        // $testAll = '$lang["'.$textCode.'"] = "'.$german.'";';

                        $testAll = '$lang["'.$textCode.'"] = "'.$cz.'";';

                        if ( write_file(FCPATH."assets/file.txt", $testAll."\n", "a+") == FALSE){
                            echo "Unable to write the file".PHP_EOL;
                        }
                
                
                    } else {
                        echo 'No data'.PHP_EOL;
                        die;

                    };
                    
                    
                }
            } else {
                echo 'No data'.PHP_EOL;
                die;

            };;
        } else echo 'File Error'.PHP_EOL;
        
    }
}