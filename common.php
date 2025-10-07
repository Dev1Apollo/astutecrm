<?php
ob_start();
include('config.php');

class connect
{

    public $conn;

    var $pages;   // Total number of pages required

    var $openPage;  // currently opened page



    function BindDropDown($result, $text, $value, $select = '', $opt= '')
    {

        if ($select != '') {

            echo "<option value=''>{$select}</option>";
        }

        while ($row = mysqli_fetch_array($result)) {

            if ($opt == $row[$value])

                echo "<option value='{$row[$value]}' selected='selected'>{$row[$text]}</option> ";

            else

                echo "<option value='{$row[$value]}'>{$row[$text]}</option> ";
        }
    }



    //		

    function htmltodb($date)
    {

        $date = str_replace('/', '-', $date);

        return date('Y-m-d', strtotime($date));
    }



    //	 



    function dbtohtml($date)
    {

        $date = str_replace('-', '/', $date);

        return date('d/m/Y', strtotime($date));
    }



    //	 

    function deleterecord($dbconn, $table, $where = '')
    {

        $query = 'delete from ' . $table . " " . $where;





        return $this->GenQuery($dbconn, $query);
    }


    function GenQuery($dbconn, $query)
    {



        $result = mysqli_query($dbconn, $query) or die(mysqli_connect_error());

        return $result;
    }



    function Gridbind($dbconn, $table, $where = '', $order = '')
    {

        $query = 'select * from ' . $table . " " . $where . " " . $order;



        return $this->GenQuery($dbconn, $query);
    }



    function Gridbindparam($dbconn, $table, $param, $where = '', $order = '')
    {

        //echo $query;

        //exit;

        $query = 'select ' . $param . ' from ' . $table . " " . $where . " " . $order;

        return $this->GenQuery($dbconn, $query);
    }



    
    function insertrecord($dbconn, $table, $data)
    {

        //print_r($data);

        $fields = '';

        $detail = "";

        foreach ($data as $key => $value) {

            if ($value != 'Save') {

                $fields .= $key . ",";

                $value = $this->Strsinglequate_replace(trim($value));

                $value = trim($value);

                $detail .= "'" . $value . "',";
            }
        }



        $fields = substr($fields, 0, strrpos($fields, ","));

        $detail = substr($detail, 0, strrpos($detail, ","));



        //exit;

        $query = "insert into " . $table . " (" . $fields . ") values (" . $detail . ")";



        $result = mysqli_query($dbconn, $query) or die(mysqli_connect_error());

        $id = mysqli_insert_id($dbconn);

        return $id;
    }



    function updaterecord($dbconn, $table, $data, $where)
    {

        $detail = "";



        foreach ($data as $key => $value) {

            if ($value != 'Update') {

                $value = $this->Strsinglequate_replace($value);

                $value = trim($value);

                $detail .= $key . "='" . $value . "',";
            }
        }

        $detail = substr($detail, 0, strrpos($detail, ","));

        $query = "update " . $table . " set " . $detail . " " . $where;

        $result = mysqli_query($dbconn, $query) or die(mysqli_connect_error());

        $id = mysqli_affected_rows($dbconn);

        return $id;
    }



    function Strsinglequate_replace($strvalue)
    {

        return str_replace("'", "''", $strvalue);
    }



    function RemoveSpecialChapr($value)
    {

        $title = str_replace(array('\'', '"', ',', ';', '<', '>', '\n'), '', $value);

        return $title;
    }



    //	 //pagination

    function createPaging($dbconn, $table, $where, $resultPerPage, $order = '')
    {

        $query = 'select * from ' . $table . " " . $where . " " . $order;

        //echo $query;

        //exit;

        $fullresult = $this->Gridbind($table, $where);

        $totalresult = mysqli_num_rows($fullresult);

        $this->pages = $this->findPages($totalresult, $resultPerPage);

        if (isset($_GET['pno']) && isset($_GET['pno']) > 0) {

            $this->openPage = $_GET['pno'];

            if ($this->openPage > $this->pages) {

                $this->pages = 1;
            }

            $start = $this->openPage * $resultPerPage - $resultPerPage;

            $end = $resultPerPage;

            $query .= " LIMIT $start,$end";
        } elseif (isset($_GET['pno']) > $this->pages) {

            $start = $this->pages;

            $end = $resultPerPage;

            $query .= " LIMIT $start,$end";
        } else {

            $this->openPage = 1;

            $query .= " LIMIT 0,$resultPerPage";
        }

        //	echo $query;

        $resultpage = mysqli_query($dbconn, $query);

        return $resultpage;
    }



    ///*

    //function to calculate the total number of pages required

    //@param - Total number of records available

    //@param - Result per page

    //*/

    function findPages($total, $perpage)
    {

        $this->pages = intval($total / $perpage);

        if ($total % $perpage > 0)

            $this->pages++;

        return $this->pages;
    }



    //	

    ///*

    //function to display the pagination

    //*/





    function fetchData($dbconn, $table, $where)
    {

        $query = "select * from " . $table . " where " . $where;

        $result = mysqli_query($dbconn, $query) or die(mysqli_connect_error());



        return mysqli_fetch_array($result);
    }



    function displayPaging($qry_str = '')
    {

        if (isset($_GET['page'])) {

            $self = $_SERVER['PHP_SELF'] . '?page=' . $_GET['page'];
        } else {

            $self = $_SERVER['PHP_SELF'] . '?1=1';
        }

        $self = $self . $qry_str;

        if ($this->openPage <= 0) {

            $next = 2;
        } else {

            $next = $this->openPage + 1;
        }



        $prev = $this->openPage - 1;

        $last = $this->pages;



        if ($this->openPage > 1) {

            echo "<a href=$self&pno=1>First</a>&nbsp&nbsp;";

            echo "<a href=$self&pno=$prev>Prev</a>&nbsp&nbsp;";
        } else {

            echo "First&nbsp&nbsp;";

            echo "Prev&nbsp&nbsp;";
        }

        /* for($i=1;$i<=$this->pages;$i++) {

          if($i == $this->openPage)

          echo "$i&nbsp&nbsp;";

          else

          echo "<a href=$self&pno=$i>$i</a>&nbsp&nbsp;";

          } */

        if ($this->openPage < $this->pages) {

            echo "<a href=$self&pno=$next>Next</a>&nbsp&nbsp;";

            echo "<a href=$self&pno=$last>Last</a>&nbsp&nbsp;";
        } else {

            echo "Next&nbsp&nbsp;";

            echo "Last&nbsp&nbsp;";
        }
    }



   


    function sendmail($detail, $giveorder, $sub = '', $mailHost='', $mailFrom='', $mailFromName='', $mailSMTPSecure='', $mailAddReplyTo='', $mailUsername='', $mailPassword='')
    {



        $mail = new PHPMailer();



        try {

            $mail->IsSMTP();

            $mail->Host = $mailHost;

            $mail->SMTPAuth = true;

            $mail->Username = $mailUsername;

            $mail->Password = $mailPassword;

            $mail->SMTPSecure = $mailSMTPSecure;                            // Enable TLS encryption, `ssl` also accepted

            $mail->Port = 587;



            $mail->From = $mailFrom;

            $mail->FromName = $mailFromName;

            $mail->AddReplyTo($mailAddReplyTo);

            $emailids = explode(',', $giveorder);

            foreach ($emailids as $key => $value) {

                $mail->AddAddress($value);
            }

            $mail->addBCC();

            $mail->IsHTML(true);

            $mail->Subject = $sub;

            $mail->Body = $detail;

            //echo $detail;

            //exit;

            //print_r($mail);

            $res_ofmail = $mail->Send();

            //var_dump($res_ofmail);

        } catch (phpmailerException $e) {

            //echo $e->errorMessage(); //Pretty error messages from PHPMailer

        } catch (Exception $e) {

            //echo $e->getMessage(); //Boring error messages from anything else!

        }
    }


    function create_hash($password)
    {

        $saltBytes = random_bytes(48);

        $PassSalt = bin2hex($saltBytes);

        $salt = base64_encode($PassSalt);

        // format: algorithm:iterations:salt:hash

        //$salt = base64_encode(mcrypt_create_iv(PBKDF2_SALT_BYTES, MCRYPT_DEV_URANDOM));

        return PBKDF2_HASH_ALGORITHM . ":" . PBKDF2_ITERATIONS . ":" . $salt .

            ":" .

            base64_encode($this->pbkdf2(

                PBKDF2_HASH_ALGORITHM,
                $password,
                $salt,
                PBKDF2_ITERATIONS,
                PBKDF2_HASH_BYTES,
                true

            ));
    }



    function validate_password($password, $good_hash)
    {

        $params = explode(":", $good_hash);

        if (count($params) < HASH_SECTIONS)

            return false;

        $pbkdf2 = base64_decode($params[HASH_PBKDF2_INDEX]);

        return $this->slow_equals(

            $pbkdf2,
            $this->pbkdf2(

                $params[HASH_ALGORITHM_INDEX],
                $password,
                $params[HASH_SALT_INDEX],
                (int) $params[HASH_ITERATION_INDEX],
                strlen($pbkdf2),
                true

            )

        );
    }



    function pbkdf2($algorithm, $password, $salt, $count, $key_length, $raw_output = false)
    {

        $algorithm = strtolower($algorithm);

        if (!in_array($algorithm, hash_algos(), true))

            die('PBKDF2 ERROR: Invalid hash algorithm.');

        if ($count <= 0 || $key_length <= 0)

            die('PBKDF2 ERROR: Invalid parameters.');



        $hash_length = strlen(hash($algorithm, "", true));

        $block_count = ceil($key_length / $hash_length);



        $output = "";

        for ($i = 1; $i <= $block_count; $i++) {

            // $i encoded as 4 bytes, big endian.

            $last = $salt . pack("N", $i);

            // first iteration

            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);

            // perform the other $count - 1 iterations

            for ($j = 1; $j < $count; $j++) {

                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }

            $output .= $xorsum;
        }



        if ($raw_output)

            return substr($output, 0, $key_length);

        else

            return bin2hex(substr($output, 0, $key_length));
    }



    function slow_equals($a, $b)
    {

        $diff = strlen($a) ^ strlen($b);

        for ($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {

            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }

        return $diff === 0;
    }



    function generatePassword()
    {

        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $res = "";

        for ($i = 0; $i < 6; $i++) {

            $res .= $chars[mt_rand(0, strlen($chars) - 1)];
        }

        return $res;
    }
}



//$connect = new dboperation($dbServer,$dbUser,$dbPass,$dbName);

//define( "DBH", $connect->conn );	
