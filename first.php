<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    
  </head>
  <body>
    <?php
    $v1 = $_POST[value1];
    $v2 = $_POST[value2];
    $v3 = $_POST[value3];
    $v4 = $_POST[value4];

    // echo $v1."<br>";
    // echo $v2."<br>";
    // echo $v3."<br>";
    // echo $v4."<br>";

    $data = array ('left-weight,left-distance,right-weight,right-distance,class',
    '5,1,3,2,L',
    '4,2,3,1,B',
    '3,5,2,1,R',
    ''.$v1.','.$v2.','.$v3.','.$v4.',?');
    $fp = fopen('balance_csv.csv', 'w');
    foreach($data as $line){
    $val = explode(",",$line);
    fputcsv($fp, $val);
    }
    fclose($fp);
    // save file csv to arff-file
    // -L last set last attribute is a normial value

    $cmd = 'java -classpath "weka.jar" weka.core.converters.CSVLoader ';
    $cmd.='-N "last" balance_csv.csv > balance_unseen_test.arff ';
    exec($cmd,$output);
    // run unseen data -p 5 is class attribute
    $cmd1 = 'java -classpath "weka.jar" weka.classifiers.trees.J48 -T ';
    $cmd1.='"balance_unseen_test.arff" -l "balance.model" -p 5'; // show output prediction
    exec($cmd1,$output1);
    $w = count($output1)-2;
    echo $output1[$w]."<br>";
    $returnValue = substr($output1[$w],29);
    // for ($i=sizeof($output1)-2;$i<sizeof($output1);$i++)
    // {
    // trim($output1[$i]);
    // echo $output1[$i]."<br>";
    // }
    echo "ข้อมูลที่กรอก : ".$v1.','.$v2.','.$v3.','.$v4."<br>";
    echo "ผลลัพธ์ : ".$returnValue;
    ?>

  </body>
</html>
