<?php
include_once("../util/system.php");
include_once("header.php");
  getHeader(4,"Regression Analysis","Trip Generation");
?> 
<script type="text/x-mathjax-config">
    MathJax.Hub.Config({tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}});
    MathJax.Hub.Config({ TeX: { equationNumbers: {autoNumber: "all"} } });
    MathJax.Hub.Config({"HTML-CSS": { linebreaks: { automatic: true } },SVG: { linebreaks: { automatic: true } }});
</script>
<script type="text/javascript" src="../mathjax-MathJax-24a378e/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<div id="body">
    <?php
    session_start();
    $UploadFile = $_SESSION['user'];
    $folder = USER_ROOT . "/" . $UploadFile . "/Experiment2/";

// Retrieving the values of variables

    $m_AnalysisVar = $_POST['AnalysisVar'];
    $m_TripFile = $_POST['TripFile'];



//----------------------------------verifying the format of the file---------------------------

    $file_ext1 = substr($m_TripFile, strripos($m_TripFile, '.'));

    if (!($file_ext1 == '.csv' || $file_ext1 == '.xls')) {
        ?>
        <script language="javascript">

            alert("invalid file format");
            location = "DataRegrMod.php";

        </script>

        <?php
    }

//----------------------------------------------------------------------------------------------
    ?>

    <script language="javaScript" src="js/exp_col.js"></script>  <!-- for expanding and collapsing on click -->

    <style type="text/css">
        #scroller 
        {
            width:800px;
            height:300px;
            overflow:auto;    
        }
        #vert
        {
            /* for firefox, safari, chrome, etc. */
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            /* for ie */
            filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=3);
        }
    </style>

    <script language="javascript">

    </script>

</head>

<center>     


<?php
//--------------------- reading Xls file-----------------------------------------------
if ($file_ext1 == '.xls') {

    // Trip File


    require_once EXCELREADER . '/Excel/reader.php';
    $dataTripF = new Spreadsheet_Excel_Reader();
    $dataTripF->setOutputEncoding('CP1251');
    $dataTripF->read($folder . $m_TripFile);
    error_reporting(E_ALL ^ E_NOTICE);

    $nRow = $dataTripF->sheets[0]['numRows'];
    $nCol = $dataTripF->sheets[0]['numCols'];
    ?>

        <table class="table table-bordered table-hover">
            <tr id="Input">
                <td colspan="2" class="title1"  onClick="expCol('Input', 1)" align ="left">
                    <b>Observed Socio-Economic Trip Data : (<u>Click Here</u>)</td><b>
                </tr>
        </table>
        <table>
            <tr  id="Input1" style="display:none">
                <td colspan="2"><div id="div_key_info" style="display:inline-table">
                        <table width="100%"  border="0" cellspacing="1" cellpadding="1">
                            <tr>
                                <td class="label1">
    <?php
    echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Observed Socio-Economic Trip Data </b></caption>';
    for ($i = 1; $i <= $nRow; $i++) {
        echo '<tr align="center" >';

        if ($i == 1) {
            echo "<td ><b>Zone</b></td>";
        } else {
            echo "<td ><b>" . ($i - 1) . "</b></td>";
        }
        for ($j = 1; $j <= $nCol; $j++) {
            // saving excel file data in to $m_TripMtx 2-Dimension array varible

            $m_TripMtx[$i][$j] = $dataTripF->sheets[0]['cells'][$i][$j];

            if ($i >= 2) {
                if (!is_numeric($m_TripMtx[$i][$j])) {
                    ?>
                                                    <script>
                        alert("Numeric value is missing in some cell, please check your file !!!");
                        document.location = "DataRegrMod.php";
                                                    </script>	
                                                    <?php
                                                }
                                            }

                                            if ($i == 1) {
                                                echo "<td ><b>" . $m_TripMtx[$i][$j] . "</b></td>";
                                            } else {
                                                echo '<td >';
                                                echo $m_TripMtx[$i][$j];
                                                echo "</td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                    echo "</table></div>";
                                    ?>   	
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>	
            <tr><td colspan="2">&nbsp;</td>	</tr>
        </table>

                                    <?php
                                }
//----------------------------------------------------------------------------------
//----------------------------- reading csv file---------------------------------------------
                                elseif ($file_ext1 == '.csv') {

                                    $nCol = 0;
                                    $nRow = 0;
                                    $name = $folder . $m_TripFile;
                                    $file = fopen($name, "r");
                                    while (($data = fgetcsv($file, 8000, ",")) !== FALSE) {
                                        $nCol = count($data);

                                        for ($c = 0; $c < $nCol; $c++) {

                                            $m_Trip[$nRow][$c] = $data[$c];
                                        }
                                        $nRow++;
                                    }

                                    for ($i = 0; $i < $nRow; $i++) {
                                        for ($j = 0; $j < $nCol; $j++) {
                                            $m_TripMtx[$i + 1][$j + 1] = $m_Trip[$i][$j];
                                        }
                                    }
                                    ?>
        <table class="table table-bordered table-hover">
            <tr id="Input">
                <td colspan="2" class="title1"  onClick="expCol('Input', 1)" align ="left">
                    <b>Input: (<u>Click Here</u>)</td><b>
                </tr>
        </table>
        <table>
            <tr  id="Input1" style="display:none">
                <td colspan="2"><div id="div_key_info" style="display:inline-table">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <td class="label1">
        <?php
        echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Observed Socio-Economic Trip Data </b></caption>';
        for ($i = 1; $i <= $nRow; $i++) {
            echo '<tr align="center" >';

            if ($i == 1) {
                echo "<td ><b>Zone</b></td>";
            } else {
                echo "<td ><b>" . ($i - 1) . "</b></td>";
            }
            for ($j = 1; $j <= $nCol; $j++) {

                if ($i >= 2) {
                    if (!is_numeric($m_TripMtx[$i][$j])) {
                        ?>
                                                    <script>
                        alert("Numeric value is missing in some cell, please check your file !!!");
                        document.location = "DataRegrMod.php";
                                                    </script>	
                    <?php
                }
            }

            if ($i == 1) {
                echo "<td ><b>" . $m_TripMtx[$i][$j] . "</b></td>";
            } else {
                echo '<td >';
                echo $m_TripMtx[$i][$j];
                echo "</td>";
            }
        }
        echo "</tr>";
    }
    echo "</table></div>";
    ?>  	
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>	
            <tr><td colspan="2">&nbsp;</td>	</tr>
        </table>

                                    <?php
                                }
//------------------------------------------------------------------------------------------------  
                                ?>

                                <?php
                                if ($m_AnalysisVar == "DataAna") {
                                    $m_DataChoiceVar = $_POST['DataChoiceVar'];

                                    if ($m_DataChoiceVar == "Correlation") {
                                        for ($i = 0; $i < count($_POST['CorrDescVar']); $i++) {
                                            $m_CorrDescVar[$i] = $_POST['CorrDescVar'][$i];
                                        }

                                        // Correlation Analysis starts from here

                                        $SelectCol = $i;

                                        $m_finalrow = $nRow;
                                        for ($j = 0; $j < $SelectCol; $j++) {
                                            $SumC[$j] = 0;
                                            $avg[$j] = 0;
                                            for ($i = 2; $i <= $m_finalrow; $i++) {
                                                $tripmatrix[$i][$j] = $m_TripMtx[$i][$m_CorrDescVar[$j]];
                                                $SumC[$j] += $tripmatrix[$i][$j];
                                            }

                                            $avg[$j] = $SumC[$j] / ($m_finalrow - 1);
                                        }



                                        for ($j = 0; $j < $SelectCol; $j++) {
                                            for ($i = 2; $i <= $m_finalrow; $i++) {
                                                $delta[$i][$j] = $tripmatrix[$i][$j] - $avg[$j];
                                            }
                                        }

                                        for ($j = 0; $j < $SelectCol; $j++) {
                                            $deltaSum[$j] = 0;
                                            for ($i = 2; $i <= $m_finalrow; $i++) {
                                                $deltaPro[$i][$j] = $delta[$i][$j] * $delta[$i][$j];
                                                $deltaSum[$j] += $deltaPro[$i][$j];
                                            }
                                            $deltaRoot[$j] = sqrt($deltaSum[$j]);
                                        }

                                        for ($j = 0; $j < $SelectCol; $j++) {
                                            for ($i = 0; $i < $SelectCol; $i++) {
                                                $sump[$j][$i] = 0;
                                                for ($k = 2; $k <= $m_finalrow; $k++) {
                                                    $sump[$j][$i]+=$delta[$k][$j] * $delta[$k][$i];
                                                }
                                            }
                                        }

                                        for ($j = 0; $j < $SelectCol; $j++) {
                                            for ($i = 0; $i < $SelectCol; $i++) {
                                                if ($deltaRoot[$j] == 0) {
                                                    /*
                                                      ?>
                                                      <script>
                                                      alert("All values in any column can not be same");
                                                      document.location = "DataRegrMod2.php";
                                                      </script>
                                                      <?php
                                                     */
                                                } else {
                                                    $reg[$i][$j] = $sump[$j][$i] / ($deltaRoot[$j] * $deltaRoot[$i]);
                                                }
                                            }
                                        }

                                        echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><B>Correlation Matrix</B></caption>';
                                        echo '<tr align="center"><td >&nbsp;</td>';

                                        for ($i = 0; $i < $SelectCol; $i++) {
                                            echo "<td ><B>" . $m_TripMtx[1][$m_CorrDescVar[$i]] . "</B></td>";
                                        }
                                        echo "</tr>";
                                        for ($j = 0; $j < $SelectCol; $j++) {
                                            echo '<tr align="center">';
                                            echo '<td ><B>' . $m_TripMtx[1][$m_CorrDescVar[$j]] . '</B></td>';
                                            for ($i = 0; $i < $SelectCol; $i++) {
                                                echo "<td >" . round($reg[$j][$i], 4) . "</td>";
                                            }
                                            echo "</tr>";
                                        }
                                        echo "</table></div>";
                                    } elseif ($m_DataChoiceVar == "Descriptives") {
                                        for ($i = 0; $i < count($_POST['CorrDescVar']); $i++) {
                                            $m_CorrDescVar[$i] = $_POST['CorrDescVar'][$i];
                                        }

                                        // Descriptives Analysis start from here

                                        $SelectCol = $i;
                                        $m_finalrow = $nRow;

                                        for ($j = 0; $j < $SelectCol; $j++) {
                                            $SumC[$j] = 0;
                                            $avg[$j] = 0;
                                            for ($i = 2; $i <= $m_finalrow; $i++) {
                                                $tripmatrix[$i][$j] = $m_TripMtx[$i][$m_CorrDescVar[$j]];
                                                $SumC[$j] += $tripmatrix[$i][$j];
                                            }
                                            $avg[$j] = $SumC[$j] / ($m_finalrow - 1);
                                        }

                                        for ($j = 0; $j < $SelectCol; $j++) {
                                            $max[$j] = 0;
                                            $min[$j] = $tripmatrix[2][1];
                                            for ($i = 2; $i <= $m_finalrow; $i++) {
                                                if ($tripmatrix[$i][$j] > $max[$j]) {
                                                    $max[$j] = $tripmatrix[$i][$j];
                                                } elseif ($tripmatrix[$i][$j] < $min[$j]) {
                                                    $min[$j] = $tripmatrix[$i][$j];
                                                }
                                            }
                                        }

                                        for ($j = 0; $j < $SelectCol; $j++) {
                                            for ($i = 2; $i <= $m_finalrow; $i++) {
                                                $delta[$i][$j] = $tripmatrix[$i][$j] - $avg[$j];
                                            }
                                        }

                                        for ($j = 0; $j < $SelectCol; $j++) {
                                            $deltaSum[$j] = 0;
                                            for ($i = 2; $i <= $m_finalrow; $i++) {
                                                $deltaPro[$i][$j] = $delta[$i][$j] * $delta[$i][$j];
                                                $deltaSum[$j] += $deltaPro[$i][$j];
                                            }
                                            $deltaRoot[$j] = sqrt(($deltaSum[$j]) / ($m_finalrow - 2));
                                        }

                                        echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Descriptive Statistics</b></caption>';
                                        echo '<tr align="center" ><td>&nbsp;</td><td><b>N</b></td><td><b>Minimum</b></td><td><b>Maximum</b></td><td><b>Mean</b></td><td><b>Standard Deviation</b></td></tr>';

                                        for ($i = 0; $i < $SelectCol; $i++) {
                                            echo '<tr align="center" >';
                                            echo'<td  ><b>' . $m_TripMtx[1][$m_CorrDescVar[$i]] . '</b></td>';
                                            echo'<td>' . ($m_finalrow - 1) . '</td>';
                                            echo'<td>' . $min[$i] . '</td>';
                                            echo'<td>' . $max[$i] . '</td>';
                                            echo'<td>' . round($avg[$i], 4) . '</td>';
                                            echo'<td>' . round($deltaRoot[$i], 4) . '</td>';
                                            echo "</tr>";
                                        }
                                        echo "</table></div>";
                                    }
                                } elseif ($m_AnalysisVar == "RegrAna") {
                                    $m_RegrDepdVar = $_POST['RegrDepdVar'];

                                    $m_RegrType = $_POST['RegrType'];


                                    for ($i = 0; $i < count($_POST['RegrInpdVar']); $i++) {
                                        $m_RegrInpdVar[$i] = $_POST['RegrInpdVar'][$i];
                                    }

                                    // Regression Analysis start from here

                                    $SelectCol = $i;
                                    $m_finalrow = $nRow;



                                    //------------------------------- Reading Xls file for output variable --------------------------------------------

                                    if ($file_ext1 == '.xls') {

                                        for ($i = 1; $i <= $m_finalrow; $i++) {
                                            if ($i == 1) {
                                                
                                            } else {
                                                $Y[$i][$m_RegrDepdVar] = $dataTripF->sheets[0]['cells'][$i][$m_RegrDepdVar];
                                            }
                                        }
                                    }
                                    //----------------------------------------------------------------------------------
                                    //----------------------------- Reading CSV file for output variable ----------------------------------------
                                    elseif ($file_ext1 == '.csv') {

                                        for ($i = 1; $i <= $m_finalrow; $i++) {
                                            if ($i == 1) {
                                                
                                            } else {
                                                $Y[$i][$m_RegrDepdVar] = $m_TripMtx[$i][$m_RegrDepdVar];
                                            }
                                        }
                                    }
                                    $m_finalrow = $m_finalrow - 1;
                                    $m_type = $_POST['Type'];
                                    if ($_POST['Type'] == "Linear") {
                                        //------------------------------------------------------------------------------------------

                                        $m_RegrType = $_POST['Type'];


                                        for ($i = 1; $i <= $m_finalrow; $i++) {
                                            $X[$i][1] = 1;
                                        }

                                        $k = 1;
                                        $m = 0;

                                        for ($j = 0; $j < $SelectCol; $j++) {
                                            $k++;
                                            $m = 0;
                                            for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                                                $m++;
                                                $X[$m][$k] = $m_TripMtx[$i][$m_RegrInpdVar[$j]];
                                            }
                                        }

                                        $p = $SelectCol + 1;



                                        for ($j = 1; $j <= $p; $j++) {
                                            for ($i = 1; $i <= $m_finalrow; $i++) {
                                                $X_t[$j][$i] = $X[$i][$j];
                                            }
                                        }


                                        for ($i = 1; $i <= $p; $i++) {
                                            for ($j = 1; $j <= $m_finalrow; $j++) {
                                                for ($k = 1; $k <= $p; $k++) {
                                                    $s = 0;
                                                    $s = $X_t[$i][$j] * $X[$j][$k];
                                                    $multi[$i][$k] = $multi[$i][$k] + $s;
                                                }
                                            }
                                        }


                                        //multiplication  of XT and Y

                                        for ($i = 1; $i <= $p; $i++) {
                                            for ($j = 1; $j <= $m_finalrow; $j++) {
                                                $r = 0;
                                                $r = $X_t[$i][$j] * $Y[$j + 1][$m_RegrDepdVar];
                                                $multiXTY[$i] = $multiXTY[$i] + $r;
                                            }
                                        }



                                        //INVERSE OF MATRIX
                                        $b = array();
                                        for ($i = 1; $i <= $p; $i++) {
                                            for ($j = 1; $j <= $p; $j++) {
                                                if ($i == $j) {
                                                    $b[$i][$j] = 1;
                                                } else {
                                                    $b[$i][$j] = 0;
                                                }
                                            }
                                        }
                                        for ($i = 1; $i <= $p; $i++) {
                                            for ($k = 1; $k <= $p; $k++) {
                                                $b[$i][$k];
                                            }
                                        }

                                        //IMP

                                        for ($k = 1; $k <= $p; $k++) {
                                            for ($i = $k + 1; $i <= $p; $i++) {
                                                $q = $multi[$i][$k];
                                                for ($j = 1; $j <= $p; $j++) {
                                                    $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);

                                                    $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                                                }
                                            }
                                        }

                                        //checking for determinant to be 0

                                        for ($i = 1; $i <= $p; $i++) {
                                            if ($b[$i][$i] == 0) {
                                                ?>
                    <script>
                        alert("Non Singular Matrix");
                    </script>
                    <?php
                }
            }

            for ($k = $p; $k > 0; $k--) {
                for ($i = $k - 1; $i > 0; $i--) {
                    $q = $multi[$i][$k];
                    for ($j = $p; $j >= 1; $j--) {
                        $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                        $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                    }
                }
            }

            for ($i = 1; $i <= $p; $i++) {
                $q = $multi[$i][$i];
                for ($k = 1; $k <= $p; $k++) {
                    $b[$i][$k] = ($b[$i][$k] / $q);
                    $multi[$i][$k] = ($multi[$i][$k] / $q);
                }
            }


            //matrix b is xtx-1

            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $p; $j++) {
                    $t = 0;
                    $t = $b[$i][$j] * $multiXTY[$j];
                    $ans[$i] = $ans[$i] + $t;
                }
            }

            //ESTIMATED VALUE OF OUTPUTS

            for ($i = 1; $i <= $m_finalrow; $i++) {
                for ($j = 1; $j <= $p; $j++) {
                    $t = 0;
                    $t = $X[$i][$j] * $ans[$j];
                    $output[$i] = $output[$i] + $t;
                }
            }

            // standard variables

            for ($i = 1; $i <= $m_finalrow; $i++) {
                $Res[$i] = $Y[$i + 1][$m_RegrDepdVar] - $output[$i];
            }

            // standard variables
            $deltaSum = 0;
            for ($j = 1; $j <= $m_finalrow; $j++) {
                $deltaSum += $Res[$j] * $Res[$j];
            }

            $deltaSum1 = $deltaSum / ($m_finalrow - $p);
            $deltaRoot = sqrt($deltaSum1);

            //

            for ($j = 1; $j <= $m_finalrow; $j++) {
                $stdres[$j] = $Res[$j] / $deltaRoot;
            }

            // for r square value

            for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                $SumC += $Y[$i][$m_RegrDepdVar];
            }
            $avg = $SumC / $m_finalrow;

            $deltaSum2 = 0;
            for ($j = 1; $j <= $m_finalrow; $j++) {
                $deltaPro1 = ($avg - $Y[$j + 1][$m_RegrDepdVar]) * ($avg - $Y[$j + 1][$m_RegrDepdVar]);
                $deltaSum2 += $deltaPro1;
            }

            $v = $deltaSum / $deltaSum2;
            $r_sqr = 1 - $v;



            // fot t value

            for ($i = 1; $i <= $p; $i++) {
                $msemse[$i] = sqrt($deltaSum1 * $b[$i][$i]);
            }

            for ($i = 1; $i <= $p; $i++) {
                $t_value[$i] = $ans[$i] / $msemse[$i];
                $t_value[$i];
            }


            $k = 1;
            //  	echo '<table class="table table-bordered table-hover"><caption><b> Equation </b></caption>';
            //  	echo "<tr ><td align='center'><b>";
            echo "$\begin{align*}";
            echo $m_TripMtx[1][$m_RegrDepdVar] . "=" . round($ans[$k], 4) . "+";
            $k++;
            for ($i = 0; $i < $p - 1; $i++) {
                if ($i == 0) {
                    echo "(" . round($ans[$k], 4) . ")*(" . $m_TripMtx[1][$m_RegrInpdVar[$i]] . ")+";
                } elseif ($i <= $p - 3) {
                    echo "(" . round($ans[$k], 4) . ")*(" . $m_TripMtx[1][$m_RegrInpdVar[$i]] . ")+";
                } else {
                    echo "(" . round($ans[$k], 4) . ")*(" . $m_TripMtx[1][$m_RegrInpdVar[$i]] . ")";
                }
                $k++;
            }
            echo "\end{align*}$";




            if ($p > 10) {
                echo '<div id="scroller">';
            }
            echo '<table class="table table-bordered table-hover"><caption><b> Coefficients</b></caption>';
            echo "<tr align='center' ><td><b>&nbsp;</b></td><td><b>Estimate</b></td><td><b>Standard Error of Estimate</b></td><td><b>T-Stat</b></td></tr>";
            $k = 0;

            for ($i = 1; $i <= $p; $i++) {
                //echo "<tr align='center' ><td>&#946<sub>".($i-1)."</sub></td>";
                if ($i == 1) {
                    echo "<tr align='center'><td ><b>Intercept</b></td>";
                    echo "<td >" . round($ans[$i], 4) . "</td>";
                    echo "<td >" . round($msemse[$i], 4) . "</td>";
                    echo "<td >" . round($t_value[$i], 4) . "</td></tr>";
                } else {
                    echo "<tr align='center'><td ><b>" . $m_TripMtx[1][$m_RegrInpdVar[$k]] . "</b></td>";
                    echo "<td >" . round($ans[$i], 4) . "</td>";
                    echo "<td >" . round($msemse[$i], 4) . "</td>";
                    echo "<td >" . round($t_value[$i], 4) . "</td></tr>";
                    $k++;
                }
            }
            echo "</table>";
            if ($p > 10) {
                echo '</div>';
            }



            echo '<table class="table table-bordered table-hover">';
            echo '<tr align="center" ><td><b>R-Square<b></td>';
            echo '<td><b>Standard Error<b></td></tr>';
            echo '<tr  align="center"align="center"><td>' . round($r_sqr, 4) . '</td><td>' . round($deltaRoot, 4) . '</td></tr>';
            echo "</table>";

            echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Estimated output values</b></caption>';
            echo "<tr ><td align='center'><b>Output variables</b></td><td align='center'><b>Y<sub>i</sub> Values</td></b><td align='center'><b>Residuals</b></td><td align='center'><b>Standard Residuals</b></td></tr>";
            for ($i = 1; $i <= $m_finalrow; $i++) {
                echo "<tr align='center' ><td>Y<sub>" . $i . "</sub></td>";
                echo "<td>" . round($output[$i], 4) . "</td><td>" . round($Res[$i], 4) . "</td><td>" . round($stdres[$i], 4) . "</td></tr>";
            }
            echo "</table></div>";
        } else if ($m_RegrType == "Quadratic") {

            echo $m_RegrType . " Regression";


            for ($i = 1; $i <= $m_finalrow; $i++) {
                $X[$i][1] = 1;
            }

            $k = 1;
            $m = 0;

            for ($j = 0; $j < $SelectCol; $j++) {
                $k++;
                $m = 0;
                for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                    $m++;
                    $X[$m][$k] = $m_TripMtx[$i][$m_RegrInpdVar[$j]];
                    $X[$m][$SelectCol + $k] = pow($m_TripMtx[$i][$m_RegrInpdVar[$j]], 2);
                }
            }


            $p = 2 * $SelectCol + 1;

            for ($j = 1; $j <= $p; $j++) {
                for ($i = 1; $i <= $m_finalrow; $i++) {
                    $X_t[$j][$i] = $X[$i][$j];
                }
            }

            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $m_finalrow; $j++) {
                    for ($k = 1; $k <= $p; $k++) {
                        $s = 0;
                        $s = $X_t[$i][$j] * $X[$j][$k];
                        $multi[$i][$k] = $multi[$i][$k] + $s;
                    }
                }
            }

            //multiplication  of XT and Y

            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $m_finalrow; $j++) {

                    $r = 0;
                    $r = $X_t[$i][$j] * $Y[$j + 1][$m_RegrDepdVar];
                    $multiXTY[$i] = $multiXTY[$i] + $r;
                }
            }

            //INVERSE OF MATRIX
            $b = array();
            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $p; $j++) {
                    if ($i == $j) {
                        $b[$i][$j] = 1;
                    } else {
                        $b[$i][$j] = 0;
                    }
                }
            }
            for ($i = 1; $i <= $p; $i++) {
                for ($k = 1; $k <= $p; $k++) {
                    $b[$i][$k];
                }
            }
            //IMP

            for ($k = 1; $k <= $p; $k++) {
                for ($i = $k + 1; $i <= $p; $i++) {
                    $q = $multi[$i][$k];
                    for ($j = 1; $j <= $p; $j++) {
                        $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                        $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                    }
                }
            }

            //checking for determinant to be 0


            for ($i = 1; $i <= $p; $i++) {

                if ($b[$i][$i] == 0) {
                    ?>
                    <script>
                        alert("Non Singular Matrix");
                        //document.location = "RegrMod.php";
                    </script>
                    <?php
                }
            }

            for ($k = $p; $k > 0; $k--) {
                for ($i = $k - 1; $i > 0; $i--) {
                    $q = $multi[$i][$k];
                    for ($j = $p; $j >= 1; $j--) {
                        $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                        $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                    }
                }
            }

            for ($i = 1; $i <= $p; $i++) {
                $q = $multi[$i][$i];
                for ($k = 1; $k <= $p; $k++) {
                    $b[$i][$k] = ($b[$i][$k] / $q);
                    $multi[$i][$k] = ($multi[$i][$k] / $q);
                }
            }

            //matrix b is xtx-1


            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $p; $j++) {

                    $t = 0;
                    $t = $b[$i][$j] * $multiXTY[$j];
                    $ans[$i] = $ans[$i] + $t;
                }
            }




            //ESTIMATED VALUE OF OUTPUTS

            for ($i = 1; $i <= $m_finalrow; $i++) {
                for ($j = 1; $j <= $p; $j++) {

                    $t = 0;
                    $t = $X[$i][$j] * $ans[$j];
                    $output[$i] = $output[$i] + $t;
                }
            }

            // standard variables


            for ($i = 1; $i <= $m_finalrow; $i++) {
                $Res[$i] = $Y[$i + 1][$m_RegrDepdVar] - $output[$i];
            }
            // standard variables 
            $deltaSum = 0;
            for ($j = 1; $j <= $m_finalrow; $j++) {

                $deltaSum += $Res[$j] * $Res[$j];
            }

            $deltaSum1 = $deltaSum / ($m_finalrow - $p);
            $deltaRoot = sqrt($deltaSum1);

            //

            for ($j = 1; $j <= $m_finalrow; $j++) {

                $stdres[$j] = $Res[$j] / $deltaRoot;
            }




            // for r square value



            for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                $SumC += $Y[$i][$m_RegrDepdVar];
            }
            $avg = $SumC / $m_finalrow;


            $deltaSum2 = 0;
            for ($j = 1; $j <= $m_finalrow; $j++) {
                $deltaPro1 = ($avg - $Y[$j + 1][$m_RegrDepdVar]) * ($avg - $Y[$j + 1][$m_RegrDepdVar]);
                $deltaSum2 += $deltaPro1;
            }
            $v = $deltaSum / $deltaSum2;
            $r_sqr = 1 - $v;


            $k = 1;
            //  	echo '<table class="table table-bordered table-hover"><caption><b> Equation </b></caption>';
            // 	echo "<tr colspan='3'><td align='center'><b>";
            echo "$\begin{align*}";
            echo $m_TripMtx[1][$m_RegrDepdVar] . "&nbsp;=&nbsp;" . round($ans[$k], 4) . "+";
            $k++;
            for ($i = 0; $i < $p - 4; $i++) {
                if ($i == 0) {
                    echo "(" . round($ans[$k], 7) . ")*(" . $m_TripMtx[1][$m_RegrInpdVar[$i]] . ")+";
                } elseif ($i <= $p - 6) {
                    echo "(" . round($ans[$k], 7) . ")*(" . $m_TripMtx[1][$m_RegrInpdVar[$i]] . ")+";
                } else {
                    echo "(" . round($ans[$k], 7) . ")*(" . $m_TripMtx[1][$m_RegrInpdVar[$i]] . ")+";
                }
                $k++;
            }
            for ($i = 0; $i < $p - 4; $i++) {
                if ($i < $p - 5) {
                    echo "(" . round($ans[$k], 7) . ")*(" . $m_TripMtx[1][$m_RegrInpdVar[$i]] . ")^2+";
                } else {
                    echo "(" . round($ans[$k], 7) . ")*(" . $m_TripMtx[1][$m_RegrInpdVar[$i]] . ")^2";
                }
                $k++;
            }
            echo "\end{align*}$";



            // fot t value


            for ($i = 1; $i <= $p; $i++) {
                $msemse[$i] = sqrt($deltaSum1 * $b[$i][$i]);
            }

            for ($i = 1; $i <= $p; $i++) {
                $t_value[$i] = $ans[$i] / $msemse[$i];
            }



            if ($p - 3 > 10) {
                echo '<div id="scroller">';
            }
            echo '<table class="table table-bordered table-hover"><caption><b> Coefficients</b></caption>';
            echo "<tr align='center' ><td><b>&nbsp;</b></td><td><b>Estimate</b></td><td><b>Standard Error of Estimate</b></td><td><b>T-Stat</b></td></tr>";
            for ($i = 1; $i <= $p - 3; $i++) {
                //echo "<tr align='center' ><td>&#946<sub>".($i-1)."</sub></td>";
                if ($i == 1) {
                    echo "<tr align='center'><td ><b>Intercept</b></td>";
                    echo "<td >" . $ans[$i] . "</td>";
                    echo "<td >" . $msemse[$i] . "</td>";
                    echo "<td >" . $t_value[$i] . "</td></tr>";
                } else {
                    echo "<tr align='center'><td ><b>" . $m_TripMtx[1][$i] . "</b></td>";
                    echo "<td >" . $ans[$i] . "</td>";
                    echo "<td >" . $msemse[$i] . "</td>";
                    echo "<td >" . $t_value[$i] . "</td></tr>";
                }
            }
            echo "</table>";
            if ($p - 3 > 10) {
                echo '</div>';
            }





            echo '<table class="table table-bordered table-hover">';
            echo '<tr align="center" ><td><b>R-Square<b></td>';
            echo '<td><b>Standard Error<b></td>';
            echo '<tr  align="center"align="center"><td>' . $r_sqr . '</td><td>' . $deltaRoot . '</td></tr>';
            echo "</table>";



            echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Estimated output values</b></caption>';
            echo "<tr ><td align='center'><b>Output variables</b></td><td align='center'><b>Y<sub>i</sub> Values</td></b><td align='center'><b>Residuals</b></td><td align='center'><b>Standard Residuals</b></td></tr>";
            for ($i = 1; $i <= $m_finalrow; $i++) {
                echo "<tr align='center' ><td>Y<sub>" . $i . "</sub></td>";
                echo "<td>" . round($output[$i], 4) . "</td><td>" . round($Res[$i], 4) . "</td><td>" . round($stdres[$i], 4) . "</td></tr>";
            }
            echo "</table></div>";
        } else if ($m_RegrType == "Power") {
            echo $m_RegrType . " Regression";
            for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                $Y1[$i][$m_RegrDepdVar] = $Y[$i][$m_RegrDepdVar];
                $Y[$i][$m_RegrDepdVar] = log($Y[$i][$m_RegrDepdVar]);
            }
            //$m_finalrow=$m_finalrow-1;


            for ($i = 1; $i <= $m_finalrow; $i++) {
                $X[$i][1] = 1;
            }

            $k = 1;
            $m = 0;

            for ($j = 0; $j < $SelectCol; $j++) {
                $k++;
                $m = 0;
                for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                    $m++;
                    $X[$m][$k] = log($m_TripMtx[$i][$m_RegrInpdVar[$j]]);
                }
            }


            $p = $SelectCol + 1;


            /*
              echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> X[i][j] </b></caption>';
              for ($i = 1; $i <= $m_finalrow; $i++)
              {
              echo"<tr >";
              for ($j = 1; $j <= $p; $j++)
              {
              echo"<td align='center'>".$X[$i][$j]."</td>";

              }
              echo "</tr>";
              }
              echo "</table></div>";
             */

            for ($j = 1; $j <= $p; $j++) {
                for ($i = 1; $i <= $m_finalrow; $i++) {
                    $X_t[$j][$i] = $X[$i][$j];
                }
            }
            /*       echo '<div id="scroller"><table border=1 cellspacing=1 align="center" width="100%" height="25%"><caption><b> X<sup>T</sup>[i][j] </b></caption>';  
              for ($i = 1; $i <= $p; $i++)
              {
              echo"<tr >";
              for ($j = 1; $j <= $m_finalrow; $j++)
              {
              echo"<td align='center'>". $X_t[$i][$j]."</td>";

              }
              echo "</tr>";
              }

              echo "</table></div>";
             */

            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $m_finalrow; $j++) {
                    for ($k = 1; $k <= $p; $k++) {
                        $s = 0;
                        $s = $X_t[$i][$j] * $X[$j][$k];
                        $multi[$i][$k] = $multi[$i][$k] + $s;
                    }
                }
            }

            //multiplication  of XT and Y

            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $m_finalrow; $j++) {

                    $r = 0;
                    $r = $X_t[$i][$j] * $Y[$j + 1][$m_RegrDepdVar];

                    $multiXTY[$i] = $multiXTY[$i] + $r;
                }
            }


            //INVERSE OF MATRIX
            $b = array();
            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $p; $j++) {
                    if ($i == $j) {
                        $b[$i][$j] = 1;
                    } else {
                        $b[$i][$j] = 0;
                    }
                }
            }
            for ($i = 1; $i <= $p; $i++) {
                for ($k = 1; $k <= $p; $k++) {
                    $b[$i][$k];
                }
            }
            //IMP

            for ($k = 1; $k <= $p; $k++) {
                for ($i = $k + 1; $i <= $p; $i++) {
                    $q = $multi[$i][$k];
                    for ($j = 1; $j <= $p; $j++) {
                        $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                        $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                    }
                }
            }

            //checking for determinant to be 0


            for ($i = 1; $i <= $p; $i++) {

                if ($b[$i][$i] == 0) {
                    ?>
                    <script>
                        alert("Non Singular Matrix");
                        //document.location = "RegrMod.php";
                    </script>
                    <?php
                }
            }

            for ($k = $p; $k > 0; $k--) {
                for ($i = $k - 1; $i > 0; $i--) {
                    $q = $multi[$i][$k];
                    for ($j = $p; $j >= 1; $j--) {
                        $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                        $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                    }
                }
            }

            for ($i = 1; $i <= $p; $i++) {
                $q = $multi[$i][$i];
                for ($k = 1; $k <= $p; $k++) {
                    $b[$i][$k] = ($b[$i][$k] / $q);
                    $multi[$i][$k] = ($multi[$i][$k] / $q);
                }
            }



            //matrix b is xtx-1


            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $p; $j++) {

                    $t = 0;
                    $t = $b[$i][$j] * $multiXTY[$j];
                    $ans[$i] = $ans[$i] + $t;
                }
            }

            for ($j = 1; $j <= $p; $j++) {
                $ans[$j] = round($ans[$j], 4);
                // echo $ans[$j]."amit";
            }



//ESTIMATED VALUE OF OUTPUTS


            for ($i = 1; $i <= $m_finalrow; $i++) {
                $output[$i] = 1;
            }

            for ($i = 1; $i <= $m_finalrow; $i++) {
                for ($j = 2; $j <= $p; $j++) {

                    $t = 1;
                    $t = pow(exp($X[$i][$j]), $ans[$j]);
                    $output[$i] = $output[$i] * $t;
                }
            }

            $ans[1] = exp($ans[1]);
            // echo $ans[1];
            for ($i = 1; $i <= $m_finalrow; $i++) {
                $output[$i] = $ans[1] * $output[$i];
                // echo $output[$i]=round($output[$i],4);
            }

            // standard variables





            for ($i = 1; $i <= $m_finalrow; $i++) {
                $Res[$i] = $Y1[$i + 1][$m_RegrDepdVar] - $output[$i];
            }
            // standard variables 
            $deltaSum = 0;
            for ($j = 1; $j <= $m_finalrow; $j++) {

                $deltaSum += $Res[$j] * $Res[$j];
            }

            $deltaSum1 = $deltaSum / ($m_finalrow - $p);
            $deltaRoot = sqrt($deltaSum1);

            //

            for ($j = 1; $j <= $m_finalrow; $j++) {

                $stdres[$j] = $Res[$j] / $deltaRoot;
            }




            // for r square value



            for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                $SumC += $Y[$i][$m_RegrDepdVar];
            }
            $avg = $SumC / $m_finalrow;
            //echo "<td ><b>".$SumC[$j]."\t".$avg[$j]."</b></td>";  


            $deltaSum2 = 0;
            for ($j = 1; $j <= $m_finalrow; $j++) {
                $deltaPro1 = ($avg - $Y[$j + 1][$m_RegrDepdVar]) * ($avg - $Y[$j + 1][$m_RegrDepdVar]);
                $deltaSum2 += $deltaPro1;
            }

            $v = $deltaSum / $deltaSum2;
            $r_sqr = 1 - $v;


            // fot t value


            for ($i = 1; $i <= $p; $i++) {
                $msemse[$i] = sqrt($deltaSum1 * $b[$i][$i]);
            }

            for ($i = 1; $i <= $p; $i++) {
                $t_value[$i] = $ans[$i] / $msemse[$i];
            }


            $k = 1;
            //     	echo '<table class="table table-bordered table-hover"><caption><b> Equation </b></caption>';
            //	echo "<tr ><td align='center'><b>";
            echo "$\begin{align*}";
            echo $m_TripMtx[1][$m_RegrDepdVar] . "=" . $ans[$k] . "*";
            $k++;
            for ($i = 0; $i < count($m_RegrInpdVar); $i++) {


                if ($i < count($m_RegrInpdVar) - 1) {
                    echo "(" . $m_TripMtx[1][$m_RegrInpdVar[$i]] . ")^{(" . $ans[$k] . ")}*";
                } else {
                    echo "(" . $m_TripMtx[1][$m_RegrInpdVar[$i]] . ")^{(" . $ans[$k] . ")}";
                }
                $k++;
            }
            echo "\end{align*}$";


            echo "</table>";
            if ($p > 10) {
                echo '<div id="scroller">';
            }

            echo '<table class="table table-bordered table-hover"><caption><b> Coefficients</b></caption>';
            echo "<tr align='center' ><td><b></b></td><td><b>Estimate</b></td><td><b>Standard Error of Estimate</b></td><td><b>T-Stat</b></td></tr>";
            for ($i = 1; $i <= $p; $i++) {
                //echo "<tr align='center' ><td>&#946<sub>".($i-1)."</sub></td>";
                if ($i == 1) {
                    echo "<tr align='center'><td ><b>Intercept</b></td>";
                    echo "<td >" . $ans[$i] . "</td>";
                    echo "<td >" . $msemse[$i] . "</td>";
                    echo "<td >" . $t_value[$i] . "</td></tr>";
                } else {
                    echo "<tr align='center'><td ><b>" . $m_TripMtx[1][$i] . "</b></td>";
                    echo "<td >" . $ans[$i] . "</td>";
                    echo "<td >" . $msemse[$i] . "</td>";
                    echo "<td >" . $t_value[$i] . "</td></tr>";
                }
            }
            echo "</table>";
            echo "</table>";
            if ($p > 10) {
                echo '</div>';
            }


            echo '<table class="table table-bordered table-hover">';
            echo '<tr align="center" ><td><b>R-Square<b></td>';
            echo '<td><b>Standard Error<b></td>';
            echo '<tr  align="center"align="center"><td>' . $r_sqr . '</td><td>' . $deltaRoot . '</td></tr>';
            echo "</table>";






            echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Estimated output values</b></caption>';
            echo "<tr ><td align='center'><b>Output variables</b></td><td align='center'><b>Y<sub>i</sub> Values</td></b><td align='center'><b>Residuals</b></td><td align='center'><b>Standard Residuals</b></td></tr>";
            for ($i = 1; $i <= $m_finalrow; $i++) {
                echo "<tr align='center' ><td>Y<sub>" . $i . "</sub></td>";
                echo "<td>" . $output[$i] . "</td><td>$Res[$i]</td><td>" . $stdres[$i] . "</td></tr>";
            }

            echo "</table></div>";
        } else if ($m_RegrType == "Exponential") {
            echo $m_RegrType . " Regression";
            for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                $Y1[$i][$m_RegrDepdVar] = $Y[$i][$m_RegrDepdVar];
                $Y[$i][$m_RegrDepdVar] = log($Y[$i][$m_RegrDepdVar]);
            }
            //$m_finalrow=$m_finalrow-1;


            for ($i = 1; $i <= $m_finalrow; $i++) {
                $X[$i][1] = 1;
            }

            $k = 1;
            $m = 0;

            for ($j = 0; $j < $SelectCol; $j++) {
                $k++;
                $m = 0;
                for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                    $m++;
                    $X[$m][$k] = ($m_TripMtx[$i][$m_RegrInpdVar[$j]]);
                }
            }


            $p = $SelectCol + 1;


            for ($j = 1; $j <= $p; $j++) {
                for ($i = 1; $i <= $m_finalrow; $i++) {
                    $X_t[$j][$i] = $X[$i][$j];
                }
            }

            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $m_finalrow; $j++) {
                    for ($k = 1; $k <= $p; $k++) {
                        $s = 0;
                        $s = $X_t[$i][$j] * $X[$j][$k];
                        $multi[$i][$k] = $multi[$i][$k] + $s;
                    }
                }
            }


            //multiplication  of XT and Y

            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $m_finalrow; $j++) {

                    $r = 0;
                    $r = $X_t[$i][$j] * $Y[$j + 1][$m_RegrDepdVar];
                    // echo $Y[$j+1][0];
                    $multiXTY[$i] = $multiXTY[$i] + $r;
                }
            }


            //INVERSE OF MATRIX
            $b = array();
            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $p; $j++) {
                    if ($i == $j) {
                        $b[$i][$j] = 1;
                    } else {
                        $b[$i][$j] = 0;
                    }
                }
            }
            for ($i = 1; $i <= $p; $i++) {
                for ($k = 1; $k <= $p; $k++) {
                    $b[$i][$k];
                }
            }
            //IMP

            for ($k = 1; $k <= $p; $k++) {
                for ($i = $k + 1; $i <= $p; $i++) {
                    $q = $multi[$i][$k];
                    for ($j = 1; $j <= $p; $j++) {
                        $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                        $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                    }
                }
            }

            //checking for determinant to be 0


            for ($i = 1; $i <= $p; $i++) {

                if ($b[$i][$i] == 0) {
                    ?>
                    <script>
                        alert("Non Singular Matrix");
                        //document.location = "RegrMod.php";
                    </script>
                    <?php
                }
            }

            for ($k = $p; $k > 0; $k--) {
                for ($i = $k - 1; $i > 0; $i--) {
                    $q = $multi[$i][$k];
                    for ($j = $p; $j >= 1; $j--) {
                        $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                        $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                    }
                }
            }

            for ($i = 1; $i <= $p; $i++) {
                $q = $multi[$i][$i];
                for ($k = 1; $k <= $p; $k++) {
                    $b[$i][$k] = ($b[$i][$k] / $q);
                    $multi[$i][$k] = ($multi[$i][$k] / $q);
                }
            }


            //matrix b is xtx-1


            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $p; $j++) {

                    $t = 0;
                    $t = $b[$i][$j] * $multiXTY[$j];
                    $ans[$i] = $ans[$i] + $t;
                }
            }




//ESTIMATED VALUE OF OUTPUTS


            for ($i = 1; $i <= $m_finalrow; $i++) {
                $output[$i] = 1;
            }

            for ($i = 1; $i <= $m_finalrow; $i++) {
                for ($j = 2; $j <= $p; $j++) {

                    $t = 1;
                    $t = exp($X[$i][$j] * $ans[$j]);
                    $output[$i] = $output[$i] * $t;
                }
            }

            $ans[1] = exp($ans[1]);
            // echo $ans[1];
            for ($i = 1; $i <= $m_finalrow; $i++) {
                $output[$i] = $ans[1] * $output[$i];
                // echo $output[$i]=round($output[$i],4);
            }

            // standard variables

            for ($i = 1; $i <= $m_finalrow; $i++) {
                $Y[$i][$m_RegrDepdVar] = $Y1[$i][$m_RegrDepdVar];
            }



            for ($i = 1; $i <= $m_finalrow; $i++) {
                $Res[$i] = $Y[$i + 1][$m_RegrDepdVar] - $output[$i];
            }
            // standard variables 
            $deltaSum = 0;
            for ($j = 1; $j <= $m_finalrow; $j++) {

                $deltaSum += $Res[$j] * $Res[$j];
            }

            $deltaSum1 = $deltaSum / ($m_finalrow - $p);
            $deltaRoot = sqrt($deltaSum1);

            //

            for ($j = 1; $j <= $m_finalrow; $j++) {

                $stdres[$j] = $Res[$j] / $deltaRoot;
            }




            // for r square value



            for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                $SumC += $Y[$i][$m_RegrDepdVar];
            }
            $avg = $SumC / $m_finalrow;
            //echo "<td ><b>".$SumC[$j]."\t".$avg[$j]."</b></td>";  


            $deltaSum2 = 0;
            for ($j = 1; $j <= $m_finalrow; $j++) {
                $deltaPro1 = ($avg - $Y[$j + 1][$m_RegrDepdVar]) * ($avg - $Y[$j + 1][$m_RegrDepdVar]);
                $deltaSum2 += $deltaPro1;
            }

            $v = $deltaSum / $deltaSum2;
            $r_sqr = 1 - $v;




            // echo '<table class="table table-bordered table-hover"><caption><b> Equation </b></caption>';
            // echo "<tr ><td align='center'><b>";
            echo "$\begin{align*}";
            for ($i = 1; $i <= $p; $i++) {
                if ($i == 1) {
                    echo $dataTripF->sheets[0]['cells'][$i][$m_RegrDepdVar] . "=" . $ans[$i] . "*";
                } elseif ($i != $p) {
                    echo "e^{((" . $ans[$i] . ")*" . $m_TripMtx[1][$i] . " )}*";
                } else {
                    echo "e^{((" . $ans[$i] . ")*" . $m_TripMtx[1][$i] . " )}";
                }
            }
            echo "\end{align*}$";


            // fot t value


            for ($i = 1; $i <= $p; $i++) {
                $msemse[$i] = sqrt($deltaSum1 * $b[$i][$i]);
            }

            for ($i = 1; $i <= $p; $i++) {
                $t_value[$i] = $ans[$i] / $msemse[$i];
            }

            if ($p > 10) {
                echo '<div id="scroller">';
            }
            echo '<table class="table table-bordered table-hover"><caption><b> Coefficients</b></caption>';
            echo "<tr align='center' ><td><b>&nbsp;</b></td><td><b>Estimate</b></td><td><b>Standard Error of Estimate</b></td><td><b>T-Stat</b></td></tr>";
            for ($i = 1; $i <= $p; $i++) {
                //echo "<tr align='center' ><td>&#946<sub>".($i-1)."</sub></td>";
                if ($i == 1) {
                    echo "<tr align='center'><td ><b>Intercept</b></td>";
                    echo "<td >" . $ans[$i] . "</td>";
                    echo "<td >" . $msemse[$i] . "</td>";
                    echo "<td >" . $t_value[$i] . "</td></tr>";
                } else {
                    echo "<tr align='center'><td ><b>" . $m_TripMtx[1][$i] . "</b></td>";
                    echo "<td >" . $ans[$i] . "</td>";
                    echo "<td >" . $msemse[$i] . "</td>";
                    echo "<td >" . $t_value[$i] . "</td></tr>";
                }
            }
            echo "</table>";
            if ($p > 10) {
                echo '</div>';
            }


            echo '<table class="table table-bordered table-hover">';
            echo '<tr align="center" ><td><b>R-Square<b></td>';
            echo '<td><b>Standard Error<b></td>';
            echo '<tr  align="center"align="center"><td>' . $r_sqr . '</td><td>' . $deltaRoot . '</td></tr>';
            echo "</table>";



            echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Estimated output values</b></caption>';
            echo "<tr ><td align='center'><b>Output variables</b></td><td align='center'><b>Y<sub>i</sub> Values</td></b><td align='center'><b>Residuals</b></td><td align='center'><b>Standard Residuals</b></td></tr>";
            for ($i = 1; $i <= $m_finalrow; $i++) {
                echo "<tr align='center' ><td>Y<sub>" . $i . "</sub></td>";
                echo "<td>" . $output[$i] . "</td><td>$Res[$i]</td><td>" . $stdres[$i] . "</td></tr>";
            }

            echo "</table></div>";
        } else if ($m_RegrType == "Logarithmic") {
            echo $m_RegrType . " Regression<br>";
            for ($i = 1; $i <= $m_finalrow; $i++) {
                $X[$i][1] = 1;
            }

            $k = 1;
            $m = 0;

            for ($j = 0; $j < $SelectCol; $j++) {
                $k++;
                $m = 0;
                for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                    $m++;
                    $X[$m][$k] = log($m_TripMtx[$i][$m_RegrInpdVar[$j]]);
                }
            }

            $p = $SelectCol + 1;



            for ($j = 1; $j <= $p; $j++) {
                for ($i = 1; $i <= $m_finalrow; $i++) {
                    $X_t[$j][$i] = $X[$i][$j];
                }
            }

            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $m_finalrow; $j++) {
                    for ($k = 1; $k <= $p; $k++) {
                        $s = 0;
                        $s = $X_t[$i][$j] * $X[$j][$k];
                        $multi[$i][$k] = $multi[$i][$k] + $s;
                    }
                }
            }



            //multiplication  of XT and Y

            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $m_finalrow; $j++) {
                    $r = 0;
                    $r = $X_t[$i][$j] * $Y[$j + 1][$m_RegrDepdVar];
                    $multiXTY[$i] = $multiXTY[$i] + $r;
                }
            }
//INVERSE OF MATRIX
            $b = array();
            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $p; $j++) {
                    if ($i == $j) {
                        $b[$i][$j] = 1;
                    } else {
                        $b[$i][$j] = 0;
                    }
                }
            }
            for ($i = 1; $i <= $p; $i++) {
                for ($k = 1; $k <= $p; $k++) {
                    $b[$i][$k];
                }
            }
            //IMP

            for ($k = 1; $k <= $p; $k++) {
                for ($i = $k + 1; $i <= $p; $i++) {
                    $q = $multi[$i][$k];
                    for ($j = 1; $j <= $p; $j++) {
                        $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                        $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                    }
                }
            }

//checking for determinant to be 0

            for ($i = 1; $i <= $p; $i++) {
                if ($b[$i][$i] == 0) {
                    ?>
                    <script>
                        alert("Non Singular Matrix");
                        //document.location = "RegrMod.php";
                    </script>
                    <?php
                }
            }

            for ($k = $p; $k > 0; $k--) {
                for ($i = $k - 1; $i > 0; $i--) {
                    $q = $multi[$i][$k];
                    for ($j = $p; $j >= 1; $j--) {
                        $multi[$i][$j] = $multi[$i][$j] - ($multi[$k][$j] * $q / $multi[$k][$k]);
                        $b[$i][$j] = $b[$i][$j] - ($b[$k][$j] * $q / $multi[$k][$k]);
                    }
                }
            }


            for ($i = 1; $i <= $p; $i++) {
                $q = $multi[$i][$i];
                for ($k = 1; $k <= $p; $k++) {
                    $b[$i][$k] = ($b[$i][$k] / $q);
                    $multi[$i][$k] = ($multi[$i][$k] / $q);
                }
            }



            //matrix b is xtx-1

            for ($i = 1; $i <= $p; $i++) {
                for ($j = 1; $j <= $p; $j++) {
                    $t = 0;
                    $t = $b[$i][$j] * $multiXTY[$j];
                    $ans[$i] = $ans[$i] + $t;
                }
            }
            /* 		
              for($j=1;$j<=$p;$j++){
              $ans[$j]=round($ans[$j],4);

              }

             */


//ESTIMATED VALUE OF OUTPUTS

            for ($i = 1; $i <= $m_finalrow; $i++) {
                for ($j = 1; $j <= $p; $j++) {

                    $t = 0;
                    $t = $X[$i][$j] * $ans[$j];
                    $output[$i] = $output[$i] + $t;
                }
            }


// standard variables


            for ($i = 1; $i <= $m_finalrow; $i++) {
                $Res[$i] = $Y[$i + 1][$m_RegrDepdVar] - $output[$i];
            }

            // standard variables
            $deltaSum = 0;
            for ($j = 1; $j <= $m_finalrow; $j++) {
                $deltaSum += $Res[$j] * $Res[$j];
            }

            $deltaSum1 = $deltaSum / ($m_finalrow - $p);
            $deltaRoot = sqrt($deltaSum1);

            //

            for ($j = 1; $j <= $m_finalrow; $j++) {
                $stdres[$j] = $Res[$j] / $deltaRoot;
            }

            // for r square value

            for ($i = 2; $i <= $m_finalrow + 1; $i++) {
                $SumC += $Y[$i][$m_RegrDepdVar];
            }
            $avg = $SumC / $m_finalrow;

            $deltaSum2 = 0;
            for ($j = 1; $j <= $m_finalrow; $j++) {
                $deltaPro1 = ($avg - $Y[$j + 1][$m_RegrDepdVar]) * ($avg - $Y[$j + 1][$m_RegrDepdVar]);
                $deltaSum2 += $deltaPro1;
            }

            $v = $deltaSum / $deltaSum2;
            $r_sqr = 1 - $v;

// fot t value

            for ($i = 1; $i <= $p; $i++) {
                $msemse[$i] = sqrt($deltaSum1 * $b[$i][$i]);
            }

            for ($i = 1; $i <= $p; $i++) {
                $t_value[$i] = $ans[$i] / $msemse[$i];
            }
            $k = 1;
            //echo '<table class="table table-bordered table-hover"><caption><b> Equation </b></caption>';
            //	echo "<tr ><td align='center'><b>";
            echo "$\begin{align*}";
            echo $m_TripMtx[1][$m_RegrDepdVar] . "=" . $ans[$k] . "+";
            $k++;
            for ($i = 2; $i <= $p; $i++) {

                if ($i != $p) {
                    echo "(" . $ans[$k] . ")ln(" . $m_TripMtx[1][$m_RegrInpdVar[$i - 2]] . ")+";
                } else {
                    echo "(" . $ans[$k] . ")ln(" . $m_TripMtx[1][$m_RegrInpdVar[$i - 2]] . ")";
                }
                $k++;
            }

            echo "\end{align*}$<br><br><br>";
            //echo "</b></td></tr></table><br><br>";

            if ($p > 10) {
                echo '<div id="scroller">';
            }
            echo '<table class="table table-bordered table-hover"><caption><b> Coefficients</b></caption>';
            echo "<tr align='center' ><td><b>&nbsp;</b></td><td><b>Estimate</b></td><td><b>Standard Error of Estimate</b></td><td><b>T-Stat</b></td></tr>";
            $k = 0;

            for ($i = 1; $i <= $p; $i++) {
                //echo "<tr align='center' ><td>&#946<sub>".($i-1)."</sub></td>";
                if ($i == 1) {
                    echo "<tr align='center'><td ><b>Intercept</b></td>";
                    echo "<td >" . $ans[$i] . "</td>";
                    echo "<td >" . $msemse[$i] . "</td>";
                    echo "<td >" . $t_value[$i] . "</td></tr>";
                } else {
                    echo "<tr align='center'><td ><b>" . $m_TripMtx[1][$m_RegrInpdVar[$k]] . "</b></td>";
                    echo "<td >" . $ans[$i] . "</td>";
                    echo "<td >" . $msemse[$i] . "</td>";
                    echo "<td >" . $t_value[$i] . "</td></tr>";
                    $k++;
                }
            }
            echo "</table>";
            if ($p > 10) {
                echo '</div>';
            }
            echo "<br>";



            echo '<br><table class="table table-bordered table-hover">';
            echo '<tr align="center" ><td><b>R-Square<b></td>';
            echo '<td><b>Standard Error<b></td></tr>';
            echo '<tr  align="center"align="center"><td>' . $r_sqr . '</td><td>' . $deltaRoot . '</td></tr>';
            echo "</table>";

            echo '<div id="scroller"><table class="table table-bordered table-hover"><caption><b> Estimated output values</b></caption>';
            echo "<tr ><td align='center'><b>Output variables</b></td><td align='center'><b>Y<sub>i</sub> Values</td></b><td align='center'><b>Residuals</b></td><td align='center'><b>Standard Residuals</b></td></tr>";
            for ($i = 1; $i <= $m_finalrow; $i++) {
                echo "<tr align='center' ><td>Y<sub>" . $i . "</sub></td>";
                echo "<td>" . $output[$i] . "</td><td>" . $Res[$i] . "</td><td>" . $stdres[$i] . "</td></tr>";
            }
            echo "</table></div>";
        }
    }
    ?>
    <script language="javascript">
        function chk1(str)
        {
            if (str == "Save")
            {
                document.Frm.action = "DataRegrModRpt.php";
            }
            else if (str == "Exit")
            {
                document.Frm.action = "DataRegrModDel.php";
            }

        }
        function chk2(str)
        {
            if (str == "Save")
            {
                document.Frm.action = "DataRegrModRptpdf.php";
            }
            else if (str == "Exit")
            {
                document.Frm.action = "DataRegrModDel.php";
            }

        }
        function chk3()
        {
            document.Frm.action = "intermediateDataRegr.php";
            //document.Frm.action="AddDataRegrRpt.php";
        }
        function check2()
        {
            if (document.Frm.tripfile2.value == "")
            {
                alert("Chhose your future trip file !!");
                document.Frm.tripfile2.focus();
                return false;
            }
            document.Frm.action = "DataRegrModRes2.php";

        }
    </script>

    <form enctype="multipart/form-data" method="post" name="Frm" action="DataRegrModRes2.php">
    <?php
    if ($m_AnalysisVar != "DataAna") {
        ?>
<br><br>
            <table class="table table-bordered table-hover">
                <tr align='center'><td>Does the above equation satisfy your Model.If yes then choose future year trip file and click next else click back</td></tr>
                <tr align='center'><td>Choose future year trip file&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='file' name='tripfile2' accept="xls"></td></tr>
                <tr align='center'><td><a href="<?echo DOC_FOLDER?>/pune.xls">Click here to download the sample input file for future year trip(.xls)</td></tr>
                <tr align='center'><td><a href="<?echo DOC_FOLDER?>/punecsv.csv">Click here to download the sample input file for future year trip(.csv)</td></tr>
            </table>
        <?php
    }
    ?>
        <table cellspacing=5>
            <tr>
    <?php $_SESSION['ANS'] = $ans; ?>
    <?php $_SESSION['RegrDepdVar'] = $m_RegrDepdVar; ?>
    <?php $_SESSION['RegrInpdVar'] = $m_RegrInpdVar; ?>
    <?php $_SESSION['RegrType'] = $m_RegrType; ?>
    <?php $_SESSION['Type'] = $m_type; ?>
    <?php $_SESSION['AnalysisVar'] = $m_AnalysisVar; ?>
            <input type="hidden" name="TripFile" size="50" value="<?= $m_TripFile ?>"> 
            <input type="hidden" name="AnalysisVar" size="50" value="<?= $m_AnalysisVar ?>">
            <input type="hidden" name="DataChoiceVar" size="50" value="<?= $m_DataChoiceVar ?>">
            <input type="hidden" name="Type" size="50" value="<?= $_POST['Type'] ?>">
        </table>
    <?php
    for ($i = 0; $i < count($_POST['CorrDescVar']); $i++) {
        ?>
            <input type="hidden" name="CorrDescVar[]" size="50" value="<?= $m_CorrDescVar[$i] ?>">
        <?php
    }
    ?>

        <input type="hidden" name="PlotXVar" size="50" value="<?= $m_PlotXVar ?>">
        <input type="hidden" name="PlotYVar" size="50" value="<?= $m_PlotYVar ?>">



        <input type="hidden" name="RegrDepdVar" size="50" value="<?= $m_RegrDepdVar ?>">
        <input type="hidden" name="RegrType" size="50" value="<?= $m_RegrType ?>">
    <?php
    for ($i = 0; $i < count($_POST['RegrInpdVar']); $i++) {
        ?>
            <input type="hidden" name="RegrInpdVar[]" size="50" value="<?= $m_RegrInpdVar[$i] ?>">
        <?php
    }
    ?>
        </center>
    <?php
    if ($m_AnalysisVar == "DataAna") {
        ?>

            <table align="right">
                <tr align ="right"><td>
                        <input type="submit" class=button value="Add To Report" name="Submit" OnClick="return chk3()">
                    </td>
                </tr>
            </table>
        <?php
    }
    ?>

        <center>
            <a href="DataRegrMod2.php?TripFile=<?php echo $m_TripFile ?>"><input type ="button" value="Back"></a>
    <?php
    if ($m_AnalysisVar != "DataAna") {
        ?>
                <span class="tab"></span>
                <input type ="submit" class=button value="Next" OnClick="return check2()">
        <?php
    }
    ?>

            </form>
        </center>
        </div>
    <?php
    include_once("footer.php");
    getFooter(4);
    ?> 	