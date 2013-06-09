<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Growth Factor Model</title>	
</head>
<body>
<?php
$height=$_GET['height'];
$width=$_GET['width'];
?>
<applet id="x1" code = "ViewPanel.class" archive= "SignedDataAnalysis.jar,jxl.jar,itextpdf-5.1.3.jar,jh.jar,src.jar,grad.jar,grad-srcs.jar,hsviewer.jar,itextpdf-5.1.3-javadoc.jar,itextpdf-5.1.3-sources.jar,itext-xtra-5.1.3.jar,itext-xtra-5.1.3-javadoc.jar,itext-xtra-5.1.3-sources.jar,jcommon-1.0.17.jar,jfreechart-1.0.14.jar,jhindexer.jar,jhsearch.jar," height="<?php echo $height;?>" width="<?php echo $width;?>">
	</applet>
</body>
</html>