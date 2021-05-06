<?php

//export.php

include 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_POST["file_content"]))
{
    // echo $_POST["file_content"];
 $temporary_html_file = './tmp_html/' . time() . '.html';

 file_put_contents($temporary_html_file, $_POST["file_content"]);

 $reader = IOFactory::createReader('Html');

 $spreadsheet = $reader->load($temporary_html_file);

 $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
ob_end_clean();

 $filename = time(). '.xlsx';

 

// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
// header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');




$writer->save($filename);

  header('Content-Type: application/x-www-form-urlencoded');

header('Content-Transfer-Encoding: Binary');

  header("Content-disposition: attachment; filename=\"".$filename."\"");

  header('Cache-Control: max-age=0');

 readfile($filename);

 unlink($temporary_html_file);

 unlink($filename);

 exit;
}

?>