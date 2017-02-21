<body onload="loadPage()">
<div id="referer">
          <a class="btn dropdown-toggle" href="http://<?echo $referer['host'];?>" target="_parent">
            <i class="fa fa-globe"></i> <?echo $referer['host'];?>
          </a>
    
</div>

<SCRIPT LANGUAGE="JavaScript">
<!--

function loadPage() {
  if (window == parent) return;
  else {
	var ref_source=document.getElementById('referer').innerHTML;
    parent.document.getElementById('referer').innerHTML=ref_source;
  }
}
//-->
</SCRIPT>
</body>