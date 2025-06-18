<script>
function enviar_formulario(){

   document.buscador.submit()
}
</script>
   <form name="buscador" id="buscador" method="post" action="buscador.php?user=<?=$_GET["user"]?>&tipo=<?=$_GET["tipo"]?>&i=<?=$_GET["i"]?>&b=E2camiones&idU=<?=$_GET["idU"]?>">
                  <p>
                    <input type="search" name="bfamilia"   list="videos3"  style=" font-family: Arial, Helvetica, sans-serif;; font-weight:normal; color:#666;border-bottom: 1px solid #FFC773; border-top:0px; border-left:0px; border-right:0px;
  border-radius: 0px; padding:0px; width:85%; padding-left:0px; text-align:right; background-color:transparent;
  height:36px;font-size:14px;" placeholder="Ingrese nombre " onchange="this.form.submit()"/>
                  
<datalist id="videos3">
  
  
  <?
 
$b3="SELECT Nombre FROM clientes2 order by Nombre asc";

$bv3=mysql_query($b3,$conexion);

?>
  <?
while( $row= mysql_fetch_assoc($bv3)){
		echo '<option value="'.$row['Nombre'].'"/>';
}
?>
  
</datalist>
 <a href="javascript:enviar_formulario()">  <inu class="icon" style="font-size:25px; margin-right:0px; margin-left:0px;  color:#f29100" id="submit" onclick="this.form.submit()"><i class="fa fa-search" style="cursor:pointer;padding:10px;" ></i></span></a>
   
  </form>