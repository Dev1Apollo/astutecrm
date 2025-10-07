<?php
   ob_start();
   error_reporting(E_ALL);
   include('../common.php');
   $connect = new connect();
   include 'IsLogin.php';
   include '../password_hash.php';
   require('../spreadsheet-reader-master/SpreadsheetReader.php');
   require_once '../spreadsheet-reader-master/php-excel-reader/excel_reader2.php';

   $action = $_REQUEST['action'];
   switch ($action) {
        /*case "UploadQuestionAnswerExcel":
            if (isset($_REQUEST['IMgallery'])) {
               $headerArray = array();
               $filename = trim($_REQUEST['IMgallery']);
               $file_path = 'temp/' . $filename;
               $Reader = new SpreadsheetReader($file_path);
               $Sheets = $Reader->Sheets();
               foreach ($Sheets as $Index => $Name) {
                   $Reader->ChangeSheet($Index);
                   $icount = 1;
                   $ValCounter = 0;
                   $insert = 0;
                   foreach ($Reader as $key => $slice) {
                       if ($ValCounter > 0) {
                           if ($key != 0) {
                               $data = array(
                                   "examId" => $_REQUEST['examId'],
                                   "question" => $slice[1],
                                   "option1" => $slice[2],
                                   "option2" => $slice[3],
                                   "option3" => $slice[4],
                                   "option4" => $slice[5],
                                   "rightAnswer" => $slice[7],      
                                   "questionMarks" => $slice[6],
                                   "strEntryDate" => date('d-m-Y H:i:s'),
                                   "strIP" => $_SERVER['REMOTE_ADDR']
                       
                               );      
                              $insert = $connect->insertrecord($dbconn, 'questionanswer', $data);
                       
                           }
                       }
                       $ValCounter++;
                   }
               }
            }
   
        @unlink($file_path);
        echo $statusMsg = $insert ? '1' : '0';
        break;*/
        
        case "UploadQuestionAnswerExcel":
    $insertedSuccessfully = true; // Flag to track overall insertion status
    $errorString = "";
    $ValCounter = 0;
    $SuccessEntry = 0;
    $ErrorEntry = 0;
    $iColumnCounter = array();

    if (isset($_REQUEST['IMgallery'])) {
        $headerArray = array();
        $filename = trim($_REQUEST['IMgallery']);
        $file_path = 'temp/' . $filename;
        $Reader = new SpreadsheetReader($file_path);
        $Sheets = $Reader->Sheets();
        
        foreach ($Sheets as $Index => $Name) {
            $Reader->ChangeSheet($Index);
            
            foreach ($Reader as $key => $slice) {
                if ($ValCounter == 0) {
                    // Process header row to map columns
                    for ($icounter = 0; $icounter < count($slice); $icounter++) {
                        if (trim($slice[$icounter]) != "") {
                            $headerArray[] = $slice[$icounter];
                            if (trim($slice[$icounter]) == "Question") {
                                $iColumnCounter[1] = $icounter;
                            }
                            if (trim($slice[$icounter]) == "Option 1") {
                                $iColumnCounter[2] = $icounter;
                            }
                            if (trim($slice[$icounter]) == "Option 2") {
                                $iColumnCounter[3] = $icounter;
                            }
                            if (trim($slice[$icounter]) == "Option 3") {
                                $iColumnCounter[4] = $icounter;
                            }
                            if (trim($slice[$icounter]) == "Option 4") {
                                $iColumnCounter[5] = $icounter;
                            }
                            if (trim($slice[$icounter]) == "Question Marks") {
                                $iColumnCounter[6] = $icounter;
                            }
                            if (trim($slice[$icounter]) == "Right Answer") {
                                $iColumnCounter[7] = $icounter;
                            }
                        }
                    }
                    
                    // Validate all required columns are present
                    
                    if (count($iColumnCounter) < 7) {
                        $insertedSuccessfully = false;
                        echo "Error: Missing required columns in the Excel file.";
                        break 2; // Exit both loops
                    }
                } else {
                    // Process data rows
                    $RowCounter = $ValCounter; // Current row number
                    
                    // Get values from mapped columns
                    $examId = $_REQUEST['examId'];
                    $question = isset($iColumnCounter[1]) ? trim($slice[$iColumnCounter[1]]) : '';
                    $option1 = isset($iColumnCounter[2]) ? trim($slice[$iColumnCounter[2]]) : '';
                    $option2 = isset($iColumnCounter[3]) ? trim($slice[$iColumnCounter[3]]) : '';
                    $option3 = isset($iColumnCounter[4]) ? trim($slice[$iColumnCounter[4]]) : '';
                    $option4 = isset($iColumnCounter[5]) ? trim($slice[$iColumnCounter[5]]) : '';
                    $questionMarks = isset($iColumnCounter[6]) ? trim($slice[$iColumnCounter[6]]) : '';
                    $rightAnswer = isset($iColumnCounter[7]) ? trim($slice[$iColumnCounter[7]]) : '';
                    $entryDate = date('Y-m-d H:i:s');
                    $ipAddress = $_SERVER['REMOTE_ADDR'];
                    
                    // Reset error string for each row
                    $errorString = "";
                    
                    // Validate question
                    if (empty($question)) {
                        $errorString .= "Row $RowCounter: Question cannot be empty. ";
                    }
                    
                    // Validate options
                    if (empty($option1)) $errorString .= "Row $RowCounter: Option 1 cannot be empty. ";
                    if (empty($option2)) $errorString .= "Row $RowCounter: Option 2 cannot be empty. ";
                    if (empty($option3)) $errorString .= "Row $RowCounter: Option 3 cannot be empty. ";
                    if (empty($option4)) $errorString .= "Row $RowCounter: Option 4 cannot be empty. ";
                    
                    // Validate right answer
                    $validAnswers = ["Option 1", "Option 2", "Option 3", "Option 4", "1", "2", "3", "4"];
                    if (!in_array($rightAnswer, $validAnswers)) {
                        $errorString .= "Row $RowCounter: Right Answer must be one of: Option 1, Option 2, Option 3, Option 4 or 1, 2, 3, 4. ";
                    } else {
                        // Normalize answer format to "Option X"
                        if (is_numeric($rightAnswer)) {
                            $rightAnswer = $rightAnswer;
                        }
                    }
                    
                    // Validate question marks
                    if (!is_numeric($questionMarks) || $questionMarks <= 0) {
                        $errorString .= "Row $RowCounter: Marks must be a positive number. ";
                    }
                    
                    if (!empty($errorString)) {
                        $ErrorEntry++;
                        $insertedSuccessfully = false;
                        
                        // Insert error record if needed
                        /*$data = array(
                            "examId" => $examId,
                            "question" => $question,
                            "option1" => $option1,
                            "option2" => $option2,
                            "option3" => $option3,
                            "option4" => $option4,
                            "rightAnswer" => $rightAnswer,
                            "questionMarks" => $questionMarks,
                            "strEntryDate" => $entryDate,
                            "strIP" => $ipAddress,
                            "ErrorLog" => $errorString
                        );
                        
                        // Assuming you have an error table for questions
                        $connect->insertrecord($dbconn, 'questionanswer_errors', $data);*/
                        
                        echo $errorString . "<br />";
                    } else {
                        // Data is valid, proceed with insertion
                        $data = array(
                            "examId" => $examId,
                            "question" => $question,
                            "option1" => $option1,
                            "option2" => $option2,
                            "option3" => $option3,
                            "option4" => $option4,
                            "rightAnswer" => $rightAnswer,
                            "questionMarks" => $questionMarks,
                            "strEntryDate" => $entryDate,
                            "strIP" => $ipAddress
                        );
                        
                        $insert = $connect->insertrecord($dbconn, 'questionanswer', $data);
                        
                        if (!$insert) {
                            $ErrorEntry++;
                            $insertedSuccessfully = false;
                            echo "Row $RowCounter: Failed to insert data into database.<br />";
                        } else {
                            $SuccessEntry++;
                        }
                    }
                }
                
                $ValCounter++;
            }
        }
        
        // Delete temporary file after processing
        @unlink($file_path);
        
        // Output summary
        echo "Error Count: " . $ErrorEntry . "<br />";
        echo "Success Count: " . $SuccessEntry . "<br />";
        echo $insertedSuccessfully ? 'Overall Status: Success' : 'Overall Status: Completed with errors';
        break;
    }
    echo '0'; // No file provided
    break;

            
        default:
           echo "Page not Found";
            break;
    }
   
   ?>