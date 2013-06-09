<?php
include_once("../util/system.php");
include_once("header.php");
getHeader(4, "All or Nothing (AON) Assignment", "Trip Assignment");

session_start();
$UploadFile = $_SESSION['user'];
$folder = USER_ROOT . "/" . $UploadFile . "/Experiment10/";

// Retrieving the values of variables

$file = fopen($folder . "AONModReport.xls", "a+");
fclose($file);

$file1 = fopen($folder . "NodeFile.xls", "w");
$url = "../Docs/link.xls";
//$m_TripFile = basename($url);
copy($url, $folder . "NodeFile.xls");

$m_NodeFile = "NodeFile.xls";

$file2 = fopen($folder . "ODFile.xls", "w");
$url = "../Docs/OD.xls";
//$m_TripFile = basename($url);
copy($url, $folder . "ODFile.xls");

$m_ODFile = "ODFile.xls";

move_uploaded_file($_FILES["NodeFile"]["tmp_name"], $folder . $_FILES["NodeFile"]["name"]);
move_uploaded_file($_FILES["ODFile"]["tmp_name"], $folder . $_FILES["ODFile"]["name"]);
?>


<style type="text/css">
    #scroller 
    {
        width:800px;
        height:300px;
        overflow:auto;  
    } 	
</style>

<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../js/jquery.inputfocus-0.9.min.js"></script>
<script type="text/javascript">


    $(document).ready(function() {
        $("#OD").hide();
        $("#Final").hide();
        $(".btn1").click(function() {
            $("#link").slideUp("slow");
            $("#OD").slideDown("slow");

        });
        $(".btn2").click(function() {
            $("#OD").slideUp("slow");
            $("#link").slideDown("slow");

        });


    });
</script>	 

<script language="javascript">
    function chk1()
    {
        document.Frm.action = "AONModRes.php?Exp=8";
    }

</script>

</head>
<div id="body">
    <center> 

        <div id ="link">

            <?php
// reading Xls file
            // Node File

            include '../phpExcelReader/Excel/reader.php';
            $dataTripF = new Spreadsheet_Excel_Reader();
            $dataTripF->setOutputEncoding('CP1251');
            $dataTripF->read($folder . $m_NodeFile);

            error_reporting(E_ALL ^ E_NOTICE);
            $m_nlinks = $dataTripF->sheets[0]['numRows'] - 1;
            $Col = $dataTripF->sheets[0]['numCols'];

            echo '<div id="scroller"><caption><b> Link Flow Characteristics </b></caption><table class="table table-bordered table-hover">';
            for ($i = 1; $i <= $m_nlinks + 1; $i++) {
                echo '<tr align="center" bgcolor="#EBF5FF">';
                for ($j = 1; $j <= $Col; $j++) {
                    $m_TripMtx[$i][$j] = $dataTripF->sheets[0]['cells'][$i][$j];

                    if ($i == 1) {
                        echo '<td bgcolor="#B8DBFF">';
                        echo '<b>' . $m_TripMtx[$i][$j] . '</b>';
                        echo "</td>";
                    } else {
                        echo '<td>';
                        echo $m_TripMtx[$i][$j];
                        echo "</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</table></div>";


            echo "<button class = 'btn1'> Next </button>";
            echo "</div>";
// reading XLS file
            echo "<div id ='OD'>";

            // OD File

            $OdTripF = new Spreadsheet_Excel_Reader();
            $OdTripF->setOutputEncoding('CP1251');
            $OdTripF->read($folder . $m_ODFile);

            error_reporting(E_ALL ^ E_NOTICE);
            $m_nnodes = $dataTripF->sheets[0]['numRows'] - 1;
            $m_Columns = $dataTripF->sheets[0]['numCols'];

            echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><B>Origin Destination matrix</B></caption>';
            for ($i = 1; $i <= $m_nnodes + 2; $i++) {
                echo '<tr align="center" bgcolor="#EBF5FF">';

                for ($j = 1; $j <= $m_Columns - 1; $j++) {
                    $m_ODMtx[$i][$j] = $OdTripF->sheets[0]['cells'][$i][$j];

                    if ($i == 1) {
                        echo '<td bgcolor="#B8DBFF">';
                        echo '<b>' . $m_ODMtx[$i][$j] . '</b>';
                        echo "</td>";
                    } else {
                        if ($j == 1) {
                            echo '<td bgcolor="#B8DBFF">';
                            echo '<b>' . $m_ODMtx[$i][$j] . '</b>';
                            echo "</td>";
                        } else {
                            echo "<td>";
                            echo $m_ODMtx[$i][$j];
                            echo "</td>";
                        }
                    }
                }
                echo "</tr>";
            }
            echo "</table></div><br>";




////////////////////////////////////////////////////////////////////////////////
            ?>        

            <form enctype="multipart/form-data" method="post" name="Frm" >

                <input type="hidden" name="NodeFile" value="<?= $m_NodeFile ?>"> 
                <input type="hidden" name="ODFile" value="<?= $m_ODFile ?>"> 
            <?php
            $_SESSION['NodeFile'] = $m_NodeFile;
            $_SESSION['ODFile'] = $m_ODFile;
            ?>

                <button class = 'btn2'> Previous </button>
                <input type="submit" class=button value="Next" name="Submit" OnClick="return chk1()">


                <a href="AONModDel.php?Exp=8&NodeFile=<?= $m_NodeFile ?>&ODFile=<?= $m_ODFile ?>">
                        <input class="pull-right" type="button" value="Restart Experiment">


                        </form>
                        </center>
                        </div>
<?php
include_once("footer.php");
getFooter(4);
?>  

