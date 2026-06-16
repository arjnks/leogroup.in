<div class="clearall"></div>
<script language="JavaScript">
function marcarTodos(){
           var objCheckBoxes = document.forms["form"].elements["checkbox[]"];
           if(!objCheckBoxes){
              alert("No item for select");
			  return;
		   }
           var countCheckBoxes = objCheckBoxes.length;
           for(i=0;i<countCheckBoxes;i++){
               objCheckBoxes[i].click();
            }
}
</script>
</div>
<!-- closing <div page> -->
<!-- Opening <div footer> -->
<div id="footer" style="height:22px; line-height:28px;">
Copyright © 2010 www.leogroup.in | Powered by <a href="http://www.programmersglobal.com" target="_blank" class="powered">PROGRAMERS</a>
</div>
<!-- closing <div footer> -->
</div>
<!-- closing <div container> -->
</body>
</html>
